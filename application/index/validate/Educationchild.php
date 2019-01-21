<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir-hws
 * Date: 2019/1/14
 * Time: 15:09
 */


namespace app\index\validate;


use think\Validate;

class Educationchild extends Validate
{

    protected $rule = [
        'education_child_name' => 'require',
    ];

    protected $message = [
        'education_child_name' => '名称必须填写!',
    ];

    //验证场景
    protected $scene = [
        'add' => ['education_child_name' => 'require']
    ];

}