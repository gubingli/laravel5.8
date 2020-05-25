<?php

namespace App\Http\Controllers\Admin;

use App\Models\CompanyInfo;
use App\Models\DoctorInfo;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserInfoController extends Controller
{
    /**平台人员列表
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $role = $request->role ? $request->role :2;

       //机构
       if($role == 1) {
          $res =  User::leftjoin('company_infos','user_id','=','id')->orderBy('users.created_at','desc')->paginate(10);
       }

       //医生
        if($role == 2) {
            $res =  User::leftjoin('doctor_infos','user_id','=','id')->orderBy('users.created_at','desc')->paginate(10);
        }

        //普通会员
        if($role == 3) {
            $res =  User::leftjoin('user_infos','user_id','=','id')->orderBy('users.created_at','desc')->paginate(10);
        }
        return $this->response->array(['message'=>'获取成功','data'=>$res,'status_code'=>200]);
    }

    /**用户信息修改
     * @param Request $request
     * @return mixed
     */
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
                $doctor_info =  DoctorInfo::where(['user_id'=>$user->id])->first();

                if($doctor_info){
                    $res =  DoctorInfo::where('user_id',$user->id)->update($data);
                }else{
                    $res =  DoctorInfo::create($data);
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

            if(!$res) return $this->response->array(['message'=>'操作失败','status_code'=>403]);

            return $this->response->array(['message'=>'操作成功','status_code'=>200]);

        }

        return $this->response->array(['message'=>'数据不存在','status_code'=>403]);
    }

    /**人员审核（医生，机构）
     * @param Request $request
     * @return mixed
     */
    public function check(Request $request)
    {
        $data = $request->json('data');
        $column['audit_status'] = $data['audit_status'];
        if($data['audit_status'] == 2) $column['pass_at'] = date('Y-m-d H:i:s');
        if($data['audit_status'] == 0) $column['reason'] = $data['reason'];

        $user = User::find($data['user_id']);
        if($user && $user->role ==1){
            $res =  CompanyInfo::where(['user_id'=>$user->id])->update($column);
        }

        if($user && $user->role ==2){
            $res =  DoctorInfo::where(['user_id'=>$user->id])->update($column);
        }

        if(!$res) return $this->response->array(['message'=>'操作失败','status_code'=>403]);

        return $this->response->array(['message'=>'操作成功','status_code'=>200]);
    }

    public function detail(Request $request)
    {
        $host =  $_SERVER["HTTP_HOST"];
        $user = User::find($request->user_id);

        if($user && $user->role > 0) {
            if($user->role == 1) {
                $res =  CompanyInfo::where(['user_id'=>$user->id])->first();
                //return $this->response->array(['message'=>'获取成功','status_code'=>200,'data'=>$res]);
            }

            if($user->role == 2) {
                $res =  DoctorInfo::where(['user_id'=>$user->id])->first();
                //return $this->response->array(['message'=>'获取成功','status_code'=>200,'data'=>$res]);
            }

            if($user->role == 3) {
                $res =  UserInfo::where(['user_id'=>$user->id])->first();
                //return $this->response->array(['message'=>'获取成功','status_code'=>200,'data'=>$res]);
            }

            if(!$res) return $this->response->array(['status_code'=>200,'data'=>null]);

            $data = $res->toArray();

            if(isset($data['license_pic']) && !empty($data['license_pic'])) {
                $url = $data['license_pic'];
                $parts = parse_url($url);
                $c=$parts['path'];
                $a=explode('/',$c);
                $data['pic_name'] = isset($a[2]) ? $a[2] : '';
                $data['url_a'] = 'http://'.$host . $data['license_pic'];
            }

            if(isset($data['pics']) && !empty($data['pics'])) {
                $url = $data['pics'];
                $parts = parse_url($url);
                $c=$parts['path'];
                $a=explode('/',$c);
                $data['pic_name'] = isset($a[2]) ? $a[2] : '' ;
                $data['url_a'] = 'http://'.$host . $data['pics'];
            }

            if(isset($data['avatar']) && !empty($data['avatar'])) {
                $url = $data['avatar'];
                $parts = parse_url($url);
                $c=$parts['path'];
                $a=explode('/',$c);
                $data['avatar_name'] = isset($a[2]) ? $a[2] : '' ;
                $data['avatar_url_a'] = 'http://'.$host . $data['avatar'];
            }

            return $this->response->array(['message'=>'获取成功','status_code'=>200,'data'=>$data]);


        }

        return $this->response->array(['message'=>'获取成功','status_code'=>200,'data'=>null]);

    }

}
