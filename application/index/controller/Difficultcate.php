<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir-hws
 * Date: 2019/1/14
 * Time: 14:23
 */

namespace app\index\controller;


use think\Db;
use think\Loader;

class Difficultcate extends Base
{
    /**
     * 疑难剖析     分类列表
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
            $count = Db::name('difficult_cate')->count();
            $data = Db::name('difficult_cate')->where('user_id', '=', $user_id)->limit($limit)->page($page)->select();
            $result = [
                'count' => $count,
                'data' => $data
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }


    }


    /**
     * 疑难剖析    添加分类
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_name 分类名称
     * @return    json
     */
    public function add($user_id = '', $difficult_cate_name = '')
    {
        $param = [
            'user_id' => $user_id,
            'difficult_cate_name' => $difficult_cate_name,
        ];

        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            //validate
            $validate = Loader::validate('Difficultcate');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('difficult_cate')->insert($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => '疑难剖析分类添加成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '疑难剖析分类添加失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 疑难剖析    修改分类
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_name 分类名称
     * @return    json
     */
    public function edit($user_id = '', $difficult_cate_name = '', $difficult_cate_id = '')
    {
        $param = [
            'user_id' => $user_id,
            'difficult_cate_name' => $difficult_cate_name,
            'difficult_cate_id' => $difficult_cate_id,
        ];

        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            //validate
            $validate = Loader::validate('Difficultcate');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('difficult_cate')->update($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => '疑难剖析分类修改成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '疑难剖析分类修改失败！'];
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
    public function del($user_id = '', $difficult_cate_id = '')
    {

        $user = Db::name('user')->where('user_id', '=', $user_id)->find();

        if ($user) {
            $result = Db::name('difficult_cate')->delete($difficult_cate_id);
            if ($result) {
                $return = ['num' => 102, 'msg' => '疑难剖析分类删除成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '疑难剖析分类删除失败!'];
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