<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir-hws
 * Date: 2019/1/15
 * Time: 16:40
 */

namespace app\index\validate;


use think\Validate;

class Footprint extends Validate
{

    protected $rule = [
        'difficult_content_question' => 'require',
        'difficult_cate_id' => 'require',
        'difficult_content_answer' => 'require',
    ];

    protected $message = [
        'difficult_content_question' => '疑难剖析 问题必须填写!',
        'difficult_content_answer' => '疑难剖析 答案必须填写!',
        'difficult_cate_id' => '必须选择一个分类!',
    ];

    //验证场景
    protected $scene = [
        'add' => ['difficult_content_question' => 'require', 'difficult_content_answer' => 'require', 'difficult_cate_id' => 'require']
    ];

}