<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailMataPelajaran extends Model
{
    use HasFactory;
    protected $table = 'detail_mata_pelajaran';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'mata_pelajaran_ref',
        'jumlah_jam',
        'max_jam',
        'semester',
        'jenjang'
    ];
    protected $hidden;
}
