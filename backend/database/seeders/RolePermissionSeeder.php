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
            'view-result' => 'Can view their own exam results',
            'join-exam' => 'Can join exams',
            'create-category' => 'Can Create new category',
            'create-question-answer' => 'Can Create new question & answers',
            'manage-own-category' => 'Can Edit|Delete categories they created',
            'manage-own-question-answer' => 'Can Edit|Delete questions & answers they created',
            'view-own-category-result' => 'Can view all results of students that join the exam they created',
            'full-access' => 'Full access to the system'
        ];

        foreach ($permissions as $permission => $description) {
            Permission::firstOrCreate(['name' => $permission, 'description' => $description]);
        }

        $admin->permissions()->sync(Permission::where('name', 'full-access')->get());
        $teacher->permissions()->sync(Permission::whereIn('name', ['create-category', 'create-question-answer', 'manage-own-category', 'join-exam',
                                    'manage-own-question-answer', 'view-own-category-result'])->get());
        $student->permissions()->sync(Permission::whereIn('name', ['view-result', 'join-exam'])->get());
    }
}