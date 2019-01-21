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

class Educationchild extends Base
{
    /**
     * Child     Child列表
     * @access    public
     * @param     string $user_id 用户id
     * @return    json
     */
    public function lis($user_id = '')
    {


        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            $count = Db::name('education_child')->count();
            $data = Db::name('education_child')->where('user_id', '=', $user_id)->select();
            $result = [
                'count' => $count,
                'data' => $data
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }


    }


    /**
     * Child    添加Child
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_name Child名称
     * @return    json
     */
    public function add($user_id = '', $education_child_name = '', $education_child_photo = '', $education_child_sex = '', $education_child_birthday = '')
    {

        $path = '../public/static/upload';
        $url = array();
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $education_child_photo, $result)) {
            $type = $result[2];
            $new_file = $path . "/" . date('Ymd', time()) . "/";
            $fileUrl = './static/upload/' . date('Ymd', time()) . '/' . time() . ".{$type}";
            if (!file_exists($new_file)) {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $new_file = $new_file . time() . ".{$type}";

            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $education_child_photo)))) {


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
            'education_child_name' => $education_child_name,
            'education_child_photo' => $url,
            'education_child_sex' => $education_child_sex,
            'education_child_birthday' => $education_child_birthday,
        ];
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            //validate
            $validate = Loader::validate('Educationchild');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('education_child')->insert($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => 'Child添加成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => 'Child添加失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Child    修改Child
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_name Child名称
     * @return    json
     */
    public function edit($user_id = '', $education_child_id = '', $education_child_name = '', $education_child_photo = '', $education_child_sex = '', $education_child_birthday = '')
    {

        $icon = Db::name('education_child')->where('education_child_id', '=', $education_child_id)->field('education_child_photo')->select();

        return json_encode($icon, JSON_UNESCAPED_UNICODE);
        $icon = implode(":", $icon);


        if ($icon) {
            unlink($icon);
        }

        $path = '../public/static/upload';
        $url = array();
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $education_child_photo, $result)) {
            $type = $result[2];
            $new_file = $path . "/" . date('Ymd', time()) . "/";
            $fileUrl = './static/upload/' . date('Ymd', time()) . '/' . time() . ".{$type}";
            if (!file_exists($new_file)) {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $new_file = $new_file . time() . ".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $education_child_photo)))) {
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
            'education_child_name' => $education_child_name,
            'education_child_photo' => $url,
            'education_child_sex' => $education_child_sex,
            'education_child_birthday' => $education_child_birthday,
            'education_child_id' => $education_child_id,
        ];
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            //validate
            $validate = Loader::validate('Educationchild');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('education_child')->update($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => 'Child添加成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => 'Child添加失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Child    删除Child
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_id Childid
     * @return    json
     */
    public function del($user_id = '', $education_child_id = '', $education_child_photo = '')
    {

        $user = Db::name('user')->where('user_id', '=', $user_id)->find();

        if ($user) {
            $result = Db::name('education_child')->delete($education_child_id);

            unlink($education_child_photo);
            if ($result) {
                $return = ['num' => 102, 'msg' => 'ChildChild删除成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => 'ChildChild删除失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }

    }


}