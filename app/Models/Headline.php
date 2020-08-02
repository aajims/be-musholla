<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Headline extends Model
{
    protected $table = 'headline';
    public $primaryKey = 'id';

    protected $fillable = [
        'title', 'content', 'status'
    ];
}
