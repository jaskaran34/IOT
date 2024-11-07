<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleData extends Model
{
    protected $fillable = ['module_id', 'measured_value', 'timestamp'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
