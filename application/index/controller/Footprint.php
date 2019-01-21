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

class Footprint extends Base
{
    /**
     * 生活旅程     列表
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
            $count = Db::name('footprint')->where('user_id', '=', $user_id)->count();
            $data = Db::name('footprint')->where('user_id', '=', $user_id)->limit($limit)->page($page)->select();
            $result = [
                'count' => $count,
                'data' => $data
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }


    }


    /**
     * 生活旅程     删除
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_id 分类id
     * @return    json
     */
    public function del($user_id = '', $footprint_id = '', $footprint_photo = '')
    {

        $num = count($footprint_photo);


        $user = Db::name('user')->where('user_id', '=', $user_id)->find();

        if ($user) {
            $result = Db::name('footprint')->delete($footprint_id);
            for ($i = 0; $i < $num; $i++) {
                unlink( $footprint_photo[$i]);
            }
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


    /**
     *  添加
     * [将Base64图片转换为本地图片并保存]
     * @param  [Base64] $base64_image_content [要保存的Base64]
     * @param  [目录] $path [要保存的路径]
     */

    private function hasUser($user_id = '')
    {
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if (!$user) {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function add($user_id = '', $footprint_title = '', $footprint_address = '', $footprint_photo = '')
    {
        $imgSrc = $footprint_photo;
        $path = '../public/static/upload';
        $url = array();
        $num = count($imgSrc);
        for ($i = 0; $i < $num; $i++) {
            //匹配出图片的格式去除字符串首位字符
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $imgSrc[$i], $result)) {
                $type = $result[2];
                $new_file = $path . "/" . date('Ymd', time()) . "/";
                $fileUrl = './static/upload/' . date('Ymd', time()) . '/' . time() . ".{$type}";
                if (!file_exists($new_file)) {
                    //检查是否有该文件夹，如果没有就创建，并给予最高权限
                    mkdir($new_file, 0700);
                }

                $new_file = $new_file . time() . ".{$type}";

                if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $imgSrc[$i])))) {
                    array_push($url, $fileUrl);
//                    return '/' . $new_file;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        $url = implode("", $url);
        $param = [
            'user_id' => $user_id,
            'footprint_title' => $footprint_title,
            'footprint_address' => $footprint_address,
            'footprint_photo' => $url,
            'footprint_time' => time()

        ];


        $this->hasUser();
        $result = Db::name('footprint')->insert($param);
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