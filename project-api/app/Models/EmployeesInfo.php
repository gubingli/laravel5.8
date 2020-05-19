<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeesInfo extends Model
{
    public function isFillable($key)
    {
        return true;
    }
}
