<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $admin = Role::create(['name' => 'admin']);
        $teacher = Role::create(['name' => 'teacher']);
        $student = Role::create(['name' => 'student']);

        $permissions = [
            'view-exam' => 'Can view and take exams',
            'view-result' => 'Can view their own exam results',
            'create-category' => 'Can create categories',
            'join-exam' => 'Can join exams',
            'create-question-answer' => 'Can create questions & answers for their exams',
            'edit-delete-own-category' => 'Can edit categories they created',
            'edit-delete-own-question-answer' => 'Can edit questions & answers they created',
            'view-result-category' => 'Can view all results of students that join the exam they created',
            'manage-category' => 'Can manage any categories (Admin only)',
            'manage-question' => 'Can manage any questions (Admin only)',
            'manage-answer' => 'Can manage any answer (Admin only)',
            'view-all-results' => 'Can view all exam results (Admin only)',
            'full-access' => 'Full access to the system'
        ];

        foreach ($permissions as $permission => $description) {
            Permission::firstOrCreate(['name' => $permission, 'description' => $description]);
        }

        $admin->permissions()->sync(Permission::whereIn('name', ['manage-category', 'manage-question', 'manage-answer', 'view-all-results', 'full-access'])->get());
        $teacher->permissions()->sync(Permission::whereIn('name', ['create-category', 'join-exam', 'create-question-answer', 'view-student-result',
                                                                    'edit-delete-own-category', 'edit-delete-own-question-answer'])->get());
        $student->permissions()->sync(Permission::whereIn('name', ['view-exam', 'view-result', 'join-exam'])->get());
    }
}