<?php

use App\Models\AcademicSubject;
use App\Models\AcademicYear;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\GradePublication;
use App\Models\GradePublicationAudit;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\User;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\StudentGradeController;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

function publicationPermission(string $name): Permission
{
    return Permission::findOrCreate($name, 'web');
}

function publicationSchool(string $suffix): School
{
    return School::create([
        'registration_id' => 'SCH-' . $suffix,
        'school_name' => 'School ' . $suffix,
        'email' => strtolower($suffix) . '@example.test',
        'status' => 'active',
        'subscription_status' => 'active',
    ]);
}

function publicationUser(School $school, string $suffix): User
{
    return User::create([
        'school_id' => $school->id,
        'registration_id' => 'USR-' . $suffix,
        'name' => 'Admin ' . $suffix,
        'email' => strtolower($suffix) . '.user@example.test',
        'password' => 'password',
    ]);
}

function publicationFixture(School $school, string $suffix, ?int $score = 85): array
{
    $grade = Grade::create(['level' => 'Grade 1', 'section' => $suffix]);
    $year = AcademicYear::create([
        'school_id' => $school->id,
        'name' => '2026/2027 ' . $suffix,
        'is_active' => true,
    ]);
    $studentUser = User::create([
        'school_id' => $school->id,
        'registration_id' => 'STU-' . $suffix,
        'name' => 'Student ' . $suffix,
        'email' => strtolower($suffix) . '.student@example.test',
        'password' => 'password',
    ]);
    $student = Student::create([
        'school_id' => $school->id,
        'user_id' => $studentUser->id,
        'name' => 'Student ' . $suffix,
        'age' => 10,
        'gender' => 'Other',
        'parent_phone' => '0000000000',
    ]);
    $enrollment = Enrollment::create([
        'school_id' => $school->id,
        'student_id' => $student->id,
        'grade_id' => $grade->id,
        'academic_year_id' => $year->id,
        'status' => 'active',
    ]);
    $subject = AcademicSubject::create([
        'school_id' => $school->id,
        'name' => 'Mathematics',
        'level' => 'elementary',
    ]);
    $studentGrade = StudentGrade::create([
        'school_id' => $school->id,
        'enrollment_id' => $enrollment->id,
        'academic_subject_id' => $subject->id,
        'period1' => $score,
    ]);

    return compact('grade', 'year', 'enrollment', 'studentGrade');
}

it('leaves the existing grade save, export, and report-card routes intact', function () {
    expect(app('router')->getRoutes()->getByName('grades.store')->getActionName())
        ->toContain(StudentGradeController::class . '@store')
        ->and(app('router')->getRoutes()->getByName('grades.export')->getActionName())
        ->toContain(StudentGradeController::class . '@export')
        ->and(app('router')->getRoutes()->getByName('report.card.dynamic')->getActionName())
        ->toContain(ReportCardController::class . '@print');
});

it('publishes one slot once and records an audit without changing the grade row', function () {
    $school = publicationSchool('A');
    $admin = publicationUser($school, 'A');
    $admin->givePermissionTo(publicationPermission('publish student grades'));
    $fixture = publicationFixture($school, 'A');

    $response = $this->actingAs($admin)->post(route('grades.publish'), [
        'grade_id' => $fixture['grade']->id,
        'academic_year_id' => $fixture['year']->id,
        'slot' => 'p1',
    ]);

    $response->assertRedirect();
    expect(GradePublication::count())->toBe(1)
        ->and(GradePublicationAudit::where('action', 'published')->count())->toBe(1)
        ->and($fixture['studentGrade']->fresh()->period1)->toBe(85);

    $this->actingAs($admin)->post(route('grades.publish'), [
        'grade_id' => $fixture['grade']->id,
        'academic_year_id' => $fixture['year']->id,
        'slot' => 'p1',
    ])->assertRedirect();

    expect(GradePublication::count())->toBe(1)
        ->and(GradePublicationAudit::where('action', 'published')->count())->toBe(1);
});

it('blocks empty slots, supports unpublish, and rejects another school scope', function () {
    $schoolA = publicationSchool('B');
    $admin = publicationUser($schoolA, 'B');
    $admin->givePermissionTo([
        publicationPermission('publish student grades'),
        publicationPermission('unpublish student grades'),
    ]);
    $fixtureA = publicationFixture($schoolA, 'B');

    $this->actingAs($admin)->post(route('grades.publish'), [
        'grade_id' => $fixtureA['grade']->id,
        'academic_year_id' => $fixtureA['year']->id,
        'slot' => 'p2',
    ])->assertStatus(422);

    $schoolB = publicationSchool('C');
    $fixtureB = publicationFixture($schoolB, 'C');

    $this->actingAs($admin)->post(route('grades.publish'), [
        'grade_id' => $fixtureB['grade']->id,
        'academic_year_id' => $fixtureB['year']->id,
        'slot' => 'p1',
    ])->assertNotFound();

    $this->actingAs($admin)->post(route('grades.publish'), [
        'grade_id' => $fixtureA['grade']->id,
        'academic_year_id' => $fixtureA['year']->id,
        'slot' => 'p1',
    ])->assertRedirect();

    $this->actingAs($admin)->post(route('grades.unpublish'), [
        'grade_id' => $fixtureA['grade']->id,
        'academic_year_id' => $fixtureA['year']->id,
        'slot' => 'p1',
    ])->assertRedirect();

    expect(GradePublication::first()->isPublished())->toBeFalse()
        ->and(GradePublicationAudit::where('action', 'unpublished')->count())->toBe(1);
});

it('denies missing permissions and schoolless accounts', function () {
    $school = publicationSchool('D');
    $fixture = publicationFixture($school, 'D');
    $teacher = publicationUser($school, 'D2');
    $teacher->assignRole(Role::findOrCreate('Teacher', 'web'));

    $this->actingAs($teacher)->post(route('grades.publish'), [
        'grade_id' => $fixture['grade']->id,
        'academic_year_id' => $fixture['year']->id,
        'slot' => 'p1',
    ])->assertForbidden();

    $student = publicationUser($school, 'D3');
    $student->assignRole(Role::findOrCreate('Student', 'web'));

    $this->actingAs($student)->post(route('grades.publish'), [
        'grade_id' => $fixture['grade']->id,
        'academic_year_id' => $fixture['year']->id,
        'slot' => 'p1',
    ])->assertForbidden();

    $platformUser = User::create([
        'school_id' => null,
        'registration_id' => 'PLATFORM-D',
        'name' => 'Platform Admin',
        'email' => 'platform.d@example.test',
        'password' => 'password',
    ]);
    $platformUser->givePermissionTo(publicationPermission('publish student grades'));

    $this->actingAs($platformUser)->post(route('grades.publish'), [
        'grade_id' => $fixture['grade']->id,
        'academic_year_id' => $fixture['year']->id,
        'slot' => 'p1',
    ])->assertForbidden();
});
