<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengurus extends Model
{
    protected $table = 'pengurus';
    public $primaryKey = 'id';

    protected $fillable = [
        'nama', 'foto', 'jabatan'
    ];
}
