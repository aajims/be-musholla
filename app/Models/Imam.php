<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imam extends Model
{
    protected $table = 'imam';
    public $primaryKey = 'id';

    protected $fillable = [
        'nama', 'foto', 'jabatan'
    ];
}
