<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name', 'measurement_type_id', 'status'];

    public function data()
    {
        return $this->hasMany(ModuleData::class);
    }

    public function measurementType()
    {
        return $this->belongsTo(MeasurementType::class);
    }

    public function statusMonitorings()
    {
        return $this->hasMany(StatusMonitoring::class);
    }
}
