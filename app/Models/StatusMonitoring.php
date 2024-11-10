<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusMonitoring extends Model
{

    protected $fillable = ['module_id', 'status'];

    // Define the relationship with the Module model
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
