<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKaryawan extends Model
{
    use HasFactory;
    public $table = 'table_datakaryawan';
    public $fillable = [
        'name',
        'email',
        'jeniskelamin',
    ];
}
