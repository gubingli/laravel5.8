<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    public function isFillable($key)
    {
        return true;
    }
}
