<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir-hws
 * Date: 2019/1/14
 * Time: 15:09
 */


namespace app\index\validate;


use think\Validate;

class Difficultcate extends Validate
{

    protected $rule = [
        'difficult_cate_name' => 'require',
    ];

    protected $message = [
        'difficult_cate_name' => '分类名称必须填写!',
    ];

    //验证场景
    protected $scene = [
        'add' => ['difficult_cate_name' => 'require']
    ];

}