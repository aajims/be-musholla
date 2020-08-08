<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'penasehat';
    public $primaryKey = 'id';

    protected $fillable = [
        'nama', 'foto', 'jabatan'
    ];
}
