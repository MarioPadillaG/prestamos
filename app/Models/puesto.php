<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class puesto extends Model
{
    protected $table = 'puesto';
    use HasFactory;
    protected $primarykey = 'id_puesto';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $nombre;
    protected $sueldo;
    public $timestamps = false;
    protected $fillable = ['nombre','sueldo'];
}
