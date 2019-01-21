<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir-hws
 * Date: 2019/1/11
 * Time: 15:18
 */

namespace app\index\controller;


use think\Controller;


use think\Db;
use think\Loader;

class User extends Base
{
    public function edit(
        $user_id = '',
        $user_name = '',
        $user_email = '',
        $user_address = '',
        $user_qq = '',
        $user_sex = '',
        $user_status = '',
        $user_phone = '',
        $user_permission = ''
    )
    {
        $param = [
            'user_id' => $user_id,
            'user_name' => $user_name,
            'user_phone' => $user_phone,
            'user_sex' => $user_sex,
            'user_qq' => $user_qq,
            'user_email' => $user_email,
            'user_address' => $user_address,
            'user_status' => $user_status,
            'user_permission' => $user_permission,
        ];
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            $validate = Loader::validate('Login');
            if (!$validate->scene('edit')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            }
            $result = Db::name('user')->update($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => '用户信息修改成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '用户信息修改失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }

    }

    public function lis($userId = '')
    {

        $user = Db::name('user')->where('user_id', '=', $userId)->find();
        if ($user) {
            $count = Db::name('user')->count();
            $data = Db::name('user')->select();
            $result = [
                'count' => $count,
                'data' => $data
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }

    public function search($keywords = '', $user_id = '')
    {
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        $where['user_name|user_phone|user_qq|user_email'] = array('like', '%' . $keywords . '%');
        if ($user) {
            $list = Db::name('user')->where($where)->field('user_name,user_phone,user_sex,user_date,user_qq,user_email,user_permission,user_address')->select();
            $count = Db::name('user')->where($where)->count();
            $result = [
                'count' => $count,
                'data' => $list
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }
}