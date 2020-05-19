<?php

namespace App\Http\Controllers\Admin;

use App\Models\CompanyInfo;
use App\Models\EmployeesInfo;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserInfoController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;

        $users = User::get();
        return $this->response->array(['data' => $users])->setStatusCode(201);
    }

    public function update(Request $request)
    {
        $data = $request->json('data');

        $user = User::find($data['user_id']);
        if($user && $user->role > 0){
            //机构
            if($user->role == 1) {
                $company_info =  CompanyInfo::where(['user_id'=>$user->id])->first();

                if($company_info){
                    $res =  CompanyInfo::where('user_id',$user->id)->update($data);
                }else{
                    $res =  CompanyInfo::create($data);
                }
            }

           //医生
            if($user->role == 2) {
                $company_info =  EmployeesInfo::where(['user_id'=>$user->id])->first();

                if($company_info){
                    $res =  EmployeesInfo::where('user_id',$user->id)->update($data);
                }else{
                    $res =  EmployeesInfo::create($data);
                }
            }

           //普通会员
            if($user->role == 3) {
                $user_info =  UserInfo::where(['user_id'=>$user->id])->first();

                if($user_info){
                    $res =  UserInfo::where('user_id',$user->id)->update($data);
                }else{
                    $res =  UserInfo::create($data);
                }
            }

            if(!$res) return $this->response->error('操作失败',403);

            return $this->response->array(['message'=>'操作成功','status_code'=>200]);

        }

        return $this->response->error('数据不存在',403);
    }

}
