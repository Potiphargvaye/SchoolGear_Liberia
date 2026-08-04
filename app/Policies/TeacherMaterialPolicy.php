<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TeacherMaterial;
use Illuminate\Auth\Access\Response;

class TeacherMaterialPolicy
{
    public function view(User $user, TeacherMaterial $material)
    {
        return $user->id === $material->teacher_id;
    }

    public function update(User $user, TeacherMaterial $material)
    {
        return $user->id === $material->teacher_id;
    }

    public function delete(User $user, TeacherMaterial $material)
    {
        return $user->id === $material->teacher_id;
    }
}