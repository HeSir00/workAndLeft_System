<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir-hws
 * Date: 2019/1/14
 * Time: 15:09
 */


namespace app\index\validate;


use think\Validate;

class Blogfolder extends Validate
{

    protected $rule = [
        'blog_folder_name' => 'require',
    ];

    protected $message = [
        'blog_folder_name' => '系列名称必须填写!',
    ];

    //验证场景
    protected $scene = [
        'add' => ['blog_folder_name' => 'require']
    ];

}