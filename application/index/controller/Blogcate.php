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

class Blogcate extends Base
{
    /**
     * 博文     分类列表
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
            $count = Db::name('blog_cate')->count();
            $data = Db::name('blog_cate')->where('user_id', '=', $user_id)->limit($limit)->page($page)->select();
            $result = [
                'count' => $count,
                'data' => $data
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }


    }


    /**
     * 博文    添加分类
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_name 分类名称
     * @return    json
     */
    public function add($user_id = '', $blog_cate_name = '', $blog_cate_icon = '')
    {

        $path = '../public/static/upload';

        $url = array();
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $blog_cate_icon, $result)) {
            $type = $result[2];
            $new_file = $path . "/" . date('Ymd', time()) . "/";
            $fileUrl = './static/upload/' . date('Ymd', time()) . '/' . time() . ".{$type}";
            if (!file_exists($new_file)) {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $new_file = $new_file . time() . ".{$type}";

            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $blog_cate_icon)))) {
                array_push($url, $fileUrl);
            } else {
                return false;
            }
        } else {
            return false;
        }

        $url = implode("", $url);
        $param = [
            'user_id' => $user_id,
            'blog_cate_name' => $blog_cate_name,
            'blog_cate_icon' => $url,
        ];
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            //validate
            $validate = Loader::validate('Blogcate');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('blog_cate')->insert($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => '博文分类添加成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '博文分类添加失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 博文    修改分类
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_name 分类名称
     * @return    json
     */
    public function edit($user_id = '', $blog_cate_name = '', $blog_cate_icon = '', $blog_cate_id = '')
    {
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            $icon = Db::name('blog_cate')->where('blog_cate_id', '=', $blog_cate_id)->field('blog_cate_icon')->select();
           $icon = implode(":", $icon[0]);
            if ($icon) {
                unlink($icon);
            }
            $path = '../public/static/upload';

            $url = array();
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $blog_cate_icon, $result)) {
                $type = $result[2];
                $new_file = $path . "/" . date('Ymd', time()) . "/";
                $fileUrl = './static/upload/' . date('Ymd', time()) . '/' . time() . ".{$type}";
                if (!file_exists($new_file)) {
                    //检查是否有该文件夹，如果没有就创建，并给予最高权限
                    mkdir($new_file, 0700);
                }
                $new_file = $new_file . time() . ".{$type}";

                if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $blog_cate_icon)))) {
                    array_push($url, $fileUrl);
                } else {
                    return false;
                }
            } else {
                return false;
            }

            $url = implode("", $url);
            $param = [
                'blog_cate_id' => $blog_cate_id,
                'blog_cate_name' => $blog_cate_name,
                'blog_cate_icon' => $url,
            ];


            //validate
            $validate = Loader::validate('Blogcate');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('blog_cate')->update($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => '博文分类修改成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '博文分类修改失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 博文    删除分类
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_id 分类id
     * @return    json
     */
    public function del($user_id = '', $blog_cate_id = '', $blog_cate_icon = '')
    {

        $user = Db::name('user')->where('user_id', '=', $user_id)->find();

        if ($user) {
            $result = Db::name('blog_cate')->delete($blog_cate_id);

            unlink($blog_cate_icon);
            if ($result) {
                $return = ['num' => 102, 'msg' => '博文分类删除成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '博文分类删除失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * 博文    搜索分类
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $keywords 关键字
     * @return    json
     */
    public function search($keywords = '', $user_id = '')
    {
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        $where['blog_cate_name'] = array('like', '%' . $keywords . '%');
        if ($user) {
            $list = Db::name('blog_cate')->where($where)->field('blog_cate_id,blog_cate_name,user_id')->select();
            $count = Db::name('blog_cate')->where($where)->count();
            $result = [
                'count' => $count,
                'data' => $list
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }


}