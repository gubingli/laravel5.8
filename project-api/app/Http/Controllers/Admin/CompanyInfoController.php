<?php

namespace App\Http\Controllers\Admin;

use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyInfoController extends Controller
{
   public function add(Request $request)
   {
       $data = $request->json('data');
       $user = $this->user();
       $company_info =  CompanyInfo::where(['user_id'=>$user->id,'audit_status'=>2])->first();
       if(!$company_info)  return $this->response->array(['message'=>'完善公司资料并审核通过后，才可以进行此操作','status_code'=>403]);
       $data['company_id'] = $company_info->cid;
       return $data;
   }
}
