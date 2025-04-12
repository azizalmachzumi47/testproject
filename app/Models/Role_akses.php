<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_akses extends Model
{
    use HasFactory;

    protected $table = 'users_role';

    protected $fillable = [
        'role'
    ];
}