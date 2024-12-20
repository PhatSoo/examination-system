<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    // Relationships
    public function permissions() {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    // Custom method
    public function hasPermission($permission) {
        return $this->permissions->contains('name', $permission);
    }

}