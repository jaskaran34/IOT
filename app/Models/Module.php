<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name', 'type', 'status'];

    public function data()
    {
        return $this->hasMany(ModuleData::class);
    }
}
