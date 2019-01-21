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

class Blogfolder extends Base
{
    /**
     * 博文系列     分类列表
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
            $count = Db::name('blog_folder')->count();
            $data = Db::name('blog_folder')->where('user_id', '=', $user_id)->limit($limit)->page($page)->select();
            $result = [
                'count' => $count,
                'data' => $data
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }


    }


    /**
     * 博文系列    添加分类
     * @access    public
     * @param     string $user_id 用户id
     * @return    json
     */
    public function add($user_id = '', $blog_folder_name = '')
    {

        $param = [
            'user_id' => $user_id,
            'blog_folder_name' => $blog_folder_name,
            'blog_folder_time' => time(),
        ];
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            //validate
            $validate = Loader::validate('Blogfolder');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('blog_folder')->insert($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => '博文系列分类添加成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '博文系列分类添加失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 博文系列    修改分类
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_name 分类名称
     * @return    json
     */
    public function edit($user_id = '', $blog_folder_name = '', $blog_folder_id = '')
    {
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {

            $param = [
                'blog_folder_id' => $blog_folder_id,
                'blog_folder_name' => $blog_folder_name,
            ];


            //validate
            $validate = Loader::validate('Blogfolder');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('blog_folder')->update($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => '博文系列分类修改成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '博文系列分类修改失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 博文系列    删除分类
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_id 分类id
     * @return    json
     */
    public function del($user_id = '', $blog_folder_id = '')
    {

        $user = Db::name('user')->where('user_id', '=', $user_id)->find();

        if ($user) {
            $result = Db::name('blog_folder')->delete($blog_folder_id);
            if ($result) {
                $return = ['num' => 102, 'msg' => '博文系列分类删除成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '博文系列分类删除失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * 博文系列    搜索分类
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $keywords 关键字
     * @return    json
     */
    public function search($keywords = '', $user_id = '')
    {
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        $where['blog_folder_name'] = array('like', '%' . $keywords . '%');
        if ($user) {
            $list = Db::name('blog_folder')->where($where)->field('blog_folder_id,blog_folder_name,user_id')->select();
            $count = Db::name('blog_folder')->where($where)->count();
            $result = [
                'count' => $count,
                'data' => $list
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }


}