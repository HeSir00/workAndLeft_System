<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir-hws
 * Date: 2019/1/11
 * Time: 11:38
 */

namespace app\index\controller;


use think\Controller;
use think\Db;
use think\Loader;
use think\Model;

class Login extends Controller
{
    /**
     * 用户登录
     * @access    public
     * @param     string $userName 用户姓名
     * @param     string $userPassword 用户密码
     * @return    json
     */
    public function index($userName = '', $userPassword = '')
    {
        $user = Db::name('user')->where('user_name', '=', $userName)->find();

        if ($user) {
            session('user', '');
            if ($user['user_password'] == md5($userPassword)) {

                if ($user['user_permission'] < 1000) {
                    $return = ['num' => 1001, 'msg' => '该用户没有权限！'];
                    return json_encode($return, JSON_UNESCAPED_UNICODE);
                    die();
                }

                session('user', $user);
                $return = [
                    'username' => $userName,
                    'userEmail' => $user['user_email'],
                    'userId' => $user['user_id'],
                    'userSex' => $user['user_sex'],
                    'userPhone' => $user['user_phone'],
                    'userAddress' => $user['user_address'],
                    'userStatus' => $user['user_status'],
                    'num' => 101,
                    'msg' => '用户登录成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 102, 'msg' => '密码不正确!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 103, 'msg' => '用户不存在!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 用户注册
     * @access    public
     * @param     string $userName 用户姓名
     * @param     string $userPassword【md5】 用户密码
     * @param     number $userPhone 电话
     * @param     number $userSex 用户性别
     * @param     number $userQQ qq
     * @param     number $userEmail 用户email
     * @param     number $userAddress 用户地址
     * @param     number $userStatus 用户身份
     * @param     number $userPermission 用户权限    0：普通 1；管理员 2：超级管理员
     * @param     number $userFootprint 生活历程模块密码
     * @param     number $userStudyeducation YU儿有方模块密码
     * @return    json
     */
    public function register(
        $userName = '',
        $userPassword = '',
        $userPhone = '',
        $userSex = '',
        $userQQ = '',
        $userEmail = '',
        $userAddress = '',
        $userStatus = '',
        $userPermission = '',
        $userFootprint = '',
        $userStudyeducation = '')
    {
        $param = [
            'user_name' => $userName,
            'user_password' => $userPassword,
            'user_phone' => $userPhone,
            'user_sex' => $userSex,
            'user_qq' => $userQQ,
            'user_email' => $userEmail,
            'user_address' => $userAddress,
            'user_status' => $userStatus,
            'user_permission' => $userPermission,
            'user_footprint' => $userFootprint,
            'user_studyeducation' => $userStudyeducation,
        ];

        //注册验证 validate
        $validate = Loader::validate('Login');
        if (!$validate->scene('register')->check($param)) {
            $return = ['num' => 104, 'msg' => $validate->getError()];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
            die;
        } else {
            $param['user_password'] = md5($userPassword);
        }

        //添加用户到mysql
        $result = Db::name('user')->insert($param);

        //返回信息
        if ($result) {
            $return = ['num' => 101, 'msg' => '用户注册成功'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        } else {
            $return = ['num' => 102, 'msg' => '用户注册 失败'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    public function layout()
    {
        session('user', '');
    }


}