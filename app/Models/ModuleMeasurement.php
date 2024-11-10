<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleMeasurement extends Model
{
    
    protected $fillable = ['module_id', 'value', 'reading_type'];

    // Define the relationship with the Module model
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    
}
