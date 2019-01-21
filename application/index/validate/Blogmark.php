<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir-hws
 * Date: 2019/1/14
 * Time: 15:09
 */


namespace app\index\validate;


use think\Validate;

class Blogmark extends Validate
{

    protected $rule = [
        'blog_mark_name' => 'require',
    ];

    protected $message = [
        'blog_mark_name' => '标签名称必须填写!',
    ];

    //验证场景
    protected $scene = [
        'add' => ['blog_mark_name' => 'require']
    ];

}