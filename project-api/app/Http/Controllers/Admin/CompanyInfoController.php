<?php

namespace App\Http\Controllers\Admin;

use App\Models\CompanyInfo;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyInfoController extends Controller
{
    /**机构添加会员
     * @param Request $request
     * @return mixed
     */
    public function add(Request $request)
   {
       $data = $request->json('data');
       $user = $this->user();
       if(!$user) return $this->response->array(['message'=>'完善公司资料并审核通过后，才可以进行此操作','status_code'=>403]);
       $company_info =  CompanyInfo::where(['user_id'=>$user->id,'audit_status'=>2])->first();
       if(!$company_info)  return $this->response->array(['message'=>'完善公司资料并审核通过后，才可以进行此操作','status_code'=>403]);
       $data['company_id'] = $company_info->cid;
       $res = UserInfo::create($data);

       return $this->response->array(['message'=>'操作成功','data'=>$res,'status_code'=>200]);
   }

    /**机构会员信息列表
     * @param Request $request
     * @return mixed
     */
    public function memberList(Request $request)
   {
       $res =  UserInfo::where('company_id',$request->cid)->simplePaginate(10);
       return $this->response->array(['message'=>'获取成功','data'=>$res,'status_code'=>200]);
   }
}
