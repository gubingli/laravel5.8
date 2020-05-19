<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorInfo extends Model
{
    public function isFillable($key)
    {
        return true;
    }
}
