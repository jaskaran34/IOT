<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeasurementType extends Model
{
    protected $fillable = ['name'];
    
    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
