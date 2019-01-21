<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir
 * Date: 2018/12/14
 * Time: 10:29
 */

namespace app\index\validate;


use think\Validate;

class Login extends Validate
{

    protected $rule = [
        'user_name' => 'require|min:6',
        'user_password' => 'require|min:6',
    ];

    protected $message = [
        'user_name.require' => '用户名称必须填写!',
        'user_name.min' => '用户名称不能小于6位!',
        'user_password.require' => '登录密码必须填写!',
        'user_password.min' => '密码不能少于6位字符！'
    ];

    //验证场景
    protected $scene = [
        'register' => ['user_name' => 'require|min:6', 'user_password|min：6'],
        'edit' => ['user_name' => 'require|min:6'],
    ];

}