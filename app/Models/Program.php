<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    protected $table = 'program';

    protected $primaryKey = 'program_id';

    protected $fillable = ['code', 'title', 'years'];

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'program', 'program_id');
    }
}
