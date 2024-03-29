<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKriteria extends Model
{
    use HasFactory;
    public $table = 'kriteria';
    protected $fillable = [
        'nama_kriteria',
        'bobot_kriteria',
    ];
}
