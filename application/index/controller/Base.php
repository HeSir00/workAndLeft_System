<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir
 * Date: 2018/12/14
 * Time: 9:56
 */

namespace app\index\controller;


use think\Controller;

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers:Authorization');
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Cache-Control,Authorization");

class Base extends Controller
{
    //登录权限
    public function _initialize()
    {

        $user = session('user');

        if ($user) {
            $uid = session('user')['user_permission'];
            if ($uid < 100) {
                $return = ['num' => 1001, 'msg' => '该用户没有权限！'];
                echo json_encode($return);
                die();

            }
        } else {
            $return = ['num' => 1002, 'msg' => '请先登录系统！'];
            echo json_encode($return);
            die();
        }

    }


}