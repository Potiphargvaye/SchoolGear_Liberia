# SchoolGear Liberia - Migration File Organizer
# This script reorganizes migration files according to table dependencies

$migrationDir = "C:\laragon\www\schoolgearliberia\database\migrations"

# Remove all numbered prefix files first (cleanup from previous runs)
Get-ChildItem -Path $migrationDir -File | Where-Object { $_.Name -match '^\d{6}_' } | Remove-Item -Force

# Define the correct dependency order based on table relationships
# Format: (OriginalFilename, NewSequenceNumber)
$order = @(
    # === PHASE 1: CORE LARAVEL TABLES (No dependencies) ===
    '0001_01_01_000000_create_users_table.php',
    '0001_01_01_000001_create_cache_table.php',
    '0001_01_01_000002_create_jobs_table.php',
    
    # === PHASE 2: BASE REFERENCE TABLES (No FK dependencies) ===
    '2025_07_29_213912_create_grades_table.php',
    '2025_10_31_231135_create_subjects_table.php',
    '2026_03_01_153220_create_permission_tables.php',
    
    # === PHASE 3: SCHOOLS SYSTEM ===
    # schools table created (references users.owner_user_id but nullable)
    '2026_08_09_201825_create_schools_table.php',
    
    # === PHASE 4: USERS TABLE MODIFICATIONS ===
    # Add school_id to users (after schools table exists)
    '2026_08_15_070022_add_school_id_to_users_table.php',
    # Add created_by to users (self-reference, after users exists)
    '2026_08_04_102110_add_created_by_to_users_table.php',
    # Add grade_id to users (after grades table exists)
    '2025_07_29_215115_add__grade_id_to_users_table.php',
    # Add subjects JSON to users
    '2025_07_30_200714_add_subjects_to_users_table.php',
    
    # === PHASE 6: ANNOUNCEMENTS SYSTEM ===
    # Announcements (references users)
    '2025_08_15_172713_create_announcements_table.php',
    '2025_08_16_135313_rename_attachment_path_to_attachment_in_announcements_table.php',
    
    # === PHASE 7: STUDENTS SYSTEM ===
    # Students (references schools, users - admissions not needed yet as FK is nullable)
    '2025_08_31_160851_create_students_table.php',
    # Add grade_id and subjects to students
    '2026_02_07_150900_add_grade_subjects_to_students_table.php',
    
    # === PHASE 8: TEACHER RELATIONSHIPS ===
    # Teacher grade subject junction table (references users, grades)
    '2025_07_31_092415_create_teacher_grade_subject_table.php',
    # Change teacher_id to registration_id in teacher_grade_subject
    '2025_08_06_023239_change_teacher_id_to_registration_id_in_teacher_grade_subject.php',
    # Teacher materials (references users, grades)
    '2025_08_27_162631_create_teacher_materials_table.php',
    
    # === PHASE 9: FEE SYSTEM (Part 1) ===
    # Fee categories (initially no FK, later modified)
    '2026_08_01_173852_create_fee_categories_table.php',
    
    # === PHASE 10: ADMISSIONS SYSTEM ===
    # Admissions (references schools, grades, academic_years, users)
    '2026_08_18_131252_create_admissions_table.php',
    # Add academic_year_id to admissions
    '2026_08_19_091137_add_academic_year_id_to_admissions_table.php',
    
    # === PHASE 11: ENROLLMENTS SYSTEM ===
    # Enrollments (references schools, admissions, students, grades, academic_years)
    '2026_08_18_131301_create_enrollments_table.php',
    # Add status_changed_by to enrollments
    '2026_08_19_181846_add_status_changed_by_to_enrollments_table.php',
    
    # === PHASE 12: FEE SYSTEM (Part 2) ===
    # Fee assignments (references schools, enrollments, fee_categories, users)
    '2026_08_01_173905_create_fee_assignments_table.php',
    # Fee payments (references fee_assignments, users)
    '2026_08_01_173916_create_fee_payments_table.php',
    
    # === PHASE 13: PROMOTIONS ===
    # Promotions (references schools, students, enrollments, grades, academic_years)
    '2026_08_18_131317_create_promotions_table.php',
    
    # === PHASE 14: GRADING SYSTEM ===
    # Student grades (references schools, enrollments, academic_subjects)
    '2026_03_07_215213_create_student_grades_table.php',
    # Grade audits (references schools, enrollments, academic_subjects, users)
    '2026_03_09_155433_create_grade_audits_table.php',
    # Grade locks (references schools, grades, academic_years)
    '2026_03_10_014832_create_grade_locks_table.php',
    # Grade teacher junction (references grades, users)
    '2026_09_02_010429_create_grade_teacher_table.php',
    # Subject teacher junction (references academic_subjects, users)
    '2026_09_02_010434_create_subject_teacher_table.php',
    
    # === PHASE 15: FEE CATEGORIES MODIFICATION ===
    # Add school_id to fee_categories
    '2026_08_22_221720_add_school_id_to_fee_categories_table.php',
    
    # === PHASE 16: SCHOOL DOCUMENTS ===
    # School document settings (references schools)
    '2026_08_23_172205_create_school_document_settings_table.php',
    # Add short_name to schools
    '2026_09_14_084932_add_short_name_to_schools_table.php',
    
    # === PHASE 17: ATTENDANCE SYSTEM ===
    # Periods (references schools)
    '2026_09_17_104000_create_periods_table.php',
    # Attendances (references schools, enrollments, periods, academic_subjects, users)
    '2026_09_17_104220_create_attendances_table.php',
    # Attendance locks (references schools, academic_years, grades, users)
    '2026_09_17_104230_create_attendance_locks_table.php',
    # Attendance audits (references schools, enrollments, periods, academic_subjects, users)
    '2026_09_17_104250_create_attendance_audits_table.php',
    
    # === PHASE 18: GRADES TABLE MODIFICATION ===
    # Change grades.level from integer to string
    '2026_02_04_144145_change_grades_level_to_string.php'
)

Write-Output "Defined $($order.Count) migration files in dependency order."

# Process each file and rename with sequential numbering
$counter = 1
$pad = 'D6'

foreach ($fileName in $order) {
    $file = Get-ChildItem -Path $migrationDir -File | Where-Object { $_.Name -eq $fileName }
    if ($file) {
        $newName = "{0}_{1}" -f ($counter.ToString($pad)), $fileName
        $newPath = Join-Path $migrationDir $newName
        Move-Item -Path $file.FullName -Destination $newPath -Force
        Write-Output "[$counter/$($order.Count)] $($file.Name) -> $newName"
        $counter++
    } else {
        Write-Warning "[$counter/$($order.Count)] File not found: $fileName"
    }
}

Write-Output "`n=========================================="
Write-Output "Migration reorganization complete!"
Write-Output "Total migrations processed: $($counter - 1)"
Write-Output "=========================================="

