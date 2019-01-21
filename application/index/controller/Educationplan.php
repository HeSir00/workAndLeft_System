<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir-hws
 * Date: 2019/1/15
 * Time: 16:40
 */

namespace app\index\controller;

use think\Db;
use think\Loader;

class Educationplan extends Base
{


    /**
     * 教育有方     列表
     * @access    public
     * @param     string $user_id 用户id
     * @return    json
     */
    public function lis($user_id = '', $limit = '', $page = '')
    {

        if (!$limit) {
            $limit = 10;
        }
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            $count = Db::name('education_plan')->where('user_id', '=', $user_id)->count();
            $data = Db::name('education_plan')->where('user_id', '=', $user_id)->limit($limit)->page($page)->select();
            $result = [
                'count' => $count,
                'data' => $data
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }


    }


    /**
     * 教育有方     删除
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_id 分类id
     * @return    json
     */
    public function del($user_id = '', $education_plan_id = '')
    {
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();

        if ($user) {
            $result = Db::name('education_plan')->delete($education_plan_id);
            if ($result) {
                $return = ['num' => 102, 'msg' => '删除成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '删除失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     *    搜索
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $keywords 关键字
     * @return    json
     */
    public function search($keywords = '', $user_id = '')
    {
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        $where['education_plan_question'] = array('like', '%' . $keywords . '%');
        if ($user) {
            $list = Db::name('education_plan')->where($where)->field('education_plan_id,education_plan_answer,user_id')->select();
            $count = Db::name('education_plan')->where($where)->count();
            $result = [
                'count' => $count,
                'data' => $list
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     *  添加
     */


    public function add($user_id = '',
                        $education_plan_question = '',
                        $education_plan_answer = '',
                        $education_plan_state = '',
                        $education_plan_address = ''
    )
    {

        $param = [
            'user_id' => $user_id,
            'education_plan_question' => $education_plan_question,
            'education_plan_answer' => $education_plan_answer,
            'education_plan_state' => $education_plan_state,
            'education_plan_address' => $education_plan_address,
            'education_plan_time' => time()
        ];


        $result = Db::name('education_plan')->insert($param);
        if ($result) {
            $return = ['num' => 102, 'msg' => '添加成功！'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        } else {
            $return = ['num' => 103, 'msg' => '添加失败！'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }


        return json_encode($url, JSON_UNESCAPED_UNICODE);


    }


}