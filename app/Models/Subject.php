<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    protected $table = 'subject';

    protected $primaryKey = 'subject_id';

    protected $fillable = ['code', 'title', 'unit', 'program'];

    public function programDetails(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program', 'program_id');
    }
}
