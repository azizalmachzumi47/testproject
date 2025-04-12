<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datamhs extends Model
{
    use HasFactory;

    protected $table = 'datamhs';
    protected $fillable =[
        'nim',
        'nama',
        'tanggal'
    ];
}