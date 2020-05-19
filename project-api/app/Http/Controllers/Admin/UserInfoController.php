<?php

namespace App\Http\Controllers\Admin;

use App\Model\CompanyInfo;
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
       //`true_name` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户姓名',
//  `phone` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号码',
//  `description` text COLLATE utf8mb4_unicode_ci COMMENT '个人简介',
//  `nation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '民族',
//  `avatar` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '头像',
//  `birthday_at` datetime DEFAULT NULL COMMENT '出生年月',
//  `education` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '学历',
//  `card_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '身份证号码',
//  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
//  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '所在公司',
//  `company_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公司id',
//  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '职位',
//  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '部门',
//  `email` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
//  `qq` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'qq号码',
//  `wechat` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信号码',
        $data = $request->json('data');

        $user = User::find($data['user_id']);




        if($user && $user->role == 1) {
           $company_info =  CompanyInfo::where(['user_id'=>$data['user_id']])->first();

           if($company_info){
               $res =  CompanyInfo::where('id',$company_info->id)->updated($data);
           }else{
               $res =  CompanyInfo::create($data);
           }

           return $res;
        }

        if($user && $user->role == 3) {
            $user_info =  UserInfo::where(['user_id'=>$data['user_id']])->first();

            if($user_info){
                $res =  UserInfo::where('id',$user_info->id)->updated($data);
            }else{
                $res =  UserInfo::create($data);
            }

            return $res;
        }
    }

}
