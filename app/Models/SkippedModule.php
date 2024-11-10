<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkippedModule extends Model
{
    protected $table = 'skipped_modules';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'module_id',
        'skipped_at',
        'reason',
    ];

    /**
     * Define the relationship to the Module model.
     * Assumes that SkippedModule belongs to a Module.
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
