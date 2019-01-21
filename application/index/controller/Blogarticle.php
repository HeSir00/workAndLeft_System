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

class Blogarticle extends Base
{
    /**
     * 博文     文章列表
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
            $count = Db::name('blog_article')->where('user_id', '=', $user_id)->count();
            $data = Db::name('blog_article')
                ->alias('a')
                ->join('blog_cate c', 'c.blog_cate_id = a.blog_cate_id')
                ->join('blog_folder f', 'f.blog_folder_id = a.blog_folder_id')
                ->where('a.user_id', '=', $user_id)->limit($limit)->page($page)
                ->field('a.blog_article_id,a.blog_article_title,a.blog_article_time,a.blog_article_md, a.blog_article_html, a.blog_article_view,a.blog_article_state,c.blog_cate_name,a.blog_cate_id,f.blog_folder_name,a.blog_folder_id,a.blog_mark_id')
                ->select();

            foreach ($data as $key => $value) {
                $markId = explode(",", $value['blog_mark_id']);
                $num = count($markId);
                $data[$key]['blog_mark_name'] = array();
                for ($i = 0; $i < $num; ++$i) {
                    $markName = Db::name('blog_mark')->where('blog_mark_id', '=', $markId[$i])
                        ->field('blog_mark_name,blog_mark_id')->select();
                    array_push($data[$key]['blog_mark_name'], $markName);
                }


            }
            $result = [
                'count' => $count,
                'data' => $data
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }


    }


    /**
     * 博文    添加文章
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_name 文章名称
     * @return    json
     */
    public function add(
        $user_id = '',
        $blog_article_title = '',
        $blog_mark_id = '',
        $blog_cate_id = '',
        $blog_folder_id = '',
        $blog_article_md = '',
        $blog_article_html = '',
        $blog_article_state = ''
    )
    {
        $param = [
            'user_id' => $user_id,
            'blog_article_title' => $blog_article_title,
            'blog_mark_id' => $blog_mark_id,
            'blog_cate_id' => $blog_cate_id,
            'blog_folder_id' => $blog_folder_id,
            'blog_article_md' => $blog_article_md,
            'blog_article_html' => $blog_article_html,
            'blog_article_state' => $blog_article_state,
            'blog_article_time' => time(),
        ];

//        return json_encode($param, JSON_UNESCAPED_UNICODE);
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            //validate
            $validate = Loader::validate('Blogarticle');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('blog_article')->insert($param);
            if ($result) {
                $return = ['num' => 102, 'msg' => '博文文章添加成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '博文文章添加失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 博文    修改文章
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_name 文章名称
     * @return    json
     */
    public function edit(
        $user_id = '',
        $blog_article_title = '',
        $blog_mark_id = '',
        $blog_cate_id = '',
        $blog_folder_id = '',
        $blog_article_md = '',
        $blog_article_html = '',
        $blog_article_id = '',
        $blog_article_state = ''
    )
    {
        $param = [
            'user_id' => $user_id,
            'blog_article_title' => $blog_article_title,
            'blog_mark_id' => $blog_mark_id,
            'blog_cate_id' => $blog_cate_id,
            'blog_folder_id' => $blog_folder_id,
            'blog_article_md' => $blog_article_md,
            'blog_article_html' => $blog_article_html,
            'blog_article_id' => $blog_article_id,
            'blog_article_state' => $blog_article_state,
        ];
//        return json_encode($param, JSON_UNESCAPED_UNICODE);
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        if ($user) {
            //validate
            $validate = Loader::validate('Blogarticle');
            if (!$validate->scene('add')->check($param)) {
                $return = ['num' => 104, 'msg' => $validate->getError()];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
                die;
            };
            $result = Db::name('blog_article')->update($param);

            if ($result) {
                $return = ['num' => 102, 'msg' => '博文文章修改成功！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '博文文章修改失败！'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户信息出错，请重新登录再做操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 博文    删除文章
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $cate_id 文章id
     * @return    json
     */
    public function del($user_id = '', $blog_article_id = '', $blog_article_icon = '')
    {

        $user = Db::name('user')->where('user_id', '=', $user_id)->find();

        if ($user) {
            $result = Db::name('blog_article')->delete($blog_article_id);

            unlink($blog_article_icon);
            if ($result) {
                $return = ['num' => 102, 'msg' => '博文文章删除成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 103, 'msg' => '博文文章删除失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 101, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * 博文    搜索文章
     * @access    public
     * @param     string $user_id 用户id
     * @param     string $keywords 关键字
     * @return    json
     */
    public function search($keywords = '', $user_id = '')
    {
        $user = Db::name('user')->where('user_id', '=', $user_id)->find();
        $where['blog_article_name'] = array('like', '%' . $keywords . '%');
        if ($user) {
            $list = Db::name('blog_article')->where($where)->field('blog_article_id,blog_article_name,user_id')->select();
            $count = Db::name('blog_article')->where($where)->count();
            $result = [
                'count' => $count,
                'data' => $list
            ];
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }


}