<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir-hws
 * Date: 2019/1/14
 * Time: 15:09
 */


namespace app\index\validate;


use think\Validate;

class Blogarticle extends Validate
{

    protected $rule = [
        'blog_article_title' => 'require',
    ];

    protected $message = [
        'blog_article_title' => '文章标题必须填写!',
    ];

    //验证场景
    protected $scene = [
        'add' => ['blog_article_title' => 'require']
    ];

}