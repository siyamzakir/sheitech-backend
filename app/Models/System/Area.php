<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Area extends BaseModel
{
    public $timestamps = false;

    protected $fillable = ['id','city_id', 'name', 'shipping_charge'];

}

