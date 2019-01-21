<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir-hws
 * Date: 2019/1/15
 * Time: 11:50
 */

namespace app\index\controller;


use think\Db;
use think\Loader;

class Difficultcontent extends Base
{
    /**
     * 疑难剖析     内容列表
     * @access    public
     * @param     string $user_id 用户id
     * @return    json
     */
    public function lis($user_id = '', $limit = '', $page = '')
    {
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if (!$limit) {
            $limit = 10;
        }
        if ($user) {
            $count = Db::name('difficult_content')->where('user_id', '=', $user_id)->count();

            $data = Db::name('difficult_content')
                ->alias('d')->join('difficult_cate c', 'c.difficult_cate_id = d.difficult_cate_id')
                ->where('d.user_id', '=', $user_id)
                ->order('d.difficult_content_id desc')
                ->limit($limit)->page($page)
                ->field('d.difficult_content_id,d.difficult_content_answer,d.difficult_content_question,d.difficult_content_time,d.difficult_content_degree,c.difficult_cate_name,c.difficult_cate_id')
                ->select();
            $result = [
                'count' => $count,
                'data' => $data
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }


    }


    /**
     * 疑难剖析    添加内容
     * @access    public
     * @param     string $user_id 用户id
     * @return    json
     */
    public function add(
        $user_id = '',
        $difficult_content_question = '',
        $difficult_content_answer = '',
        $difficult_content_degree = '',
        $difficult_cate_id = ''
    )
    {
        $param = [
            'user_id' => $user_id,
            'difficult_content_question' => $difficult_content_question,
            'difficult_content_answer' => $difficult_content_answer,
            'difficult_content_degree' => $difficult_content_degree,
            'difficult_cate_id' => $difficult_cate_id,
            'difficult_content_time' => time(),
        ];

        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            //validate
            $validate = Loader::validate('Difficultcontent');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('difficult_content')->insert($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => '疑难剖析内容添加成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '疑难剖析内容添加失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 疑难剖析    修改内容
     * @access    public
     * @param     string $user_id 用户id
     * @return    json
     */
    public function edit(
        $user_id = '',
        $difficult_content_question = '',
        $difficult_content_answer = '',
        $difficult_content_degree = '',
        $difficult_cate_id = ''
    )
    {
        $param = [
            'user_id' => $user_id,
            'difficult_content_question' => $difficult_content_question,
            'difficult_content_answer' => $difficult_content_answer,
            'difficult_content_degree' => $difficult_content_degree,
            'difficult_cate_id' => $difficult_cate_id,
        ];

        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            //validate
            $validate = Loader::validate('Difficultcontent');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('difficult_content')->update($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => '疑难剖析内容修改成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '疑难剖析内容修改失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 疑难剖析    删除分类
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_id 分类id
     * @return    json
     */
    public function del($user_id = '', $difficult_content_id = '')
    {

        $user = Db::name('user')->where('user_id', '=', $user_id)->find();

        if ($user) {
            $result = Db::name('difficult_content')->delete($difficult_content_id);
            if ($result) {
                $return = ['num' => 102, 'msg' => '疑难剖析内容 删除成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '疑难剖析内容 删除失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * 疑难剖析    搜索分类
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $keywords 关键字
     * @return    json
     */
    public function search($keywords = '', $user_id = '')
    {
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        $where['difficult_cate_name'] = array('like', '%' . $keywords . '%');
        if ($user) {
            $list = Db::name('difficult_cate')->where($where)->field('difficult_cate_id,difficult_cate_name,user_id')->select();
            $count = Db::name('difficult_cate')->where($where)->count();
            $result = [
                'count' => $count,
                'data' => $list
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }


}