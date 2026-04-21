<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'program';

    protected $primaryKey = 'program_id';

    protected $fillable = ['code', 'title', 'years'];
}
