<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{

    /**可这样设置不加白名单，否则不写protected $fillable = ['字段1', '字段2']; 数据就不能入库
     * @auther ifehrim@gmail.com
     * @param string $key
     * @return bool
     */
    public function isFillable($key)
    {
        return true;
    }
}
