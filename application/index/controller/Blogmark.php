<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir-hws
 * Date: 2019/1/17
 * Time: 9:17
 */

namespace app\index\controller;


use think\Db;
use think\Loader;

class Blogmark extends Base
{
    /**
     * 博文标签     标签列表
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
            $count = Db::name('blog_mark')->count();
            $data = Db::name('blog_mark')->where('user_id', '=', $user_id)->limit($limit)->page($page)->select();
            $result = [
                'count' => $count,
                'data' => $data
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }


    }


    /**
     * 博文标签    添加标签
     * @access    public
     * @param     string $user_id 用户id
     * @return    json
     */
    public function add($user_id = '', $blog_mark_name = '')
    {

        $param = [
            'user_id' => $user_id,
            'blog_mark_name' => $blog_mark_name,
        ];
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            //validate
            $validate = Loader::validate('Blogmark');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('blog_mark')->insert($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => '博文标签标签添加成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '博文标签标签添加失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 博文标签    修改标签
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_name 标签名称
     * @return    json
     */
    public function edit($user_id = '', $blog_mark_name = '', $blog_mark_id = '')
    {
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {

            $param = [
                'blog_mark_id' => $blog_mark_id,
                'blog_mark_name' => $blog_mark_name,
            ];

            //validate
            $validate = Loader::validate('Blogmark');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('blog_mark')->update($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => '博文标签标签修改成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '博文标签标签修改失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 博文标签    删除标签
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_id 标签id
     * @return    json
     */
    public function del($user_id = '', $blog_mark_id = '')
    {

        $user = Db::name('user')->where('user_id', '=', $user_id)->find();

        if ($user) {
            $result = Db::name('blog_mark')->delete($blog_mark_id);
            if ($result) {
                $return = ['num' => 102, 'msg' => '博文标签标签删除成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '博文标签标签删除失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * 博文标签    搜索标签
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $keywords 关键字
     * @return    json
     */
    public function search($keywords = '', $user_id = '')
    {
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        $where['blog_mark_name'] = array('like', '%' . $keywords . '%');
        if ($user) {
            $list = Db::name('blog_mark')->where($where)->field('blog_mark_id,blog_mark_name,user_id')->select();
            $count = Db::name('blog_mark')->where($where)->count();
            $result = [
                'count' => $count,
                'data' => $list
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }


}