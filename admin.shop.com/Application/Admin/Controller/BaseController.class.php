<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/10
 * Time: 11:00
 */

namespace Admin\Controller;


use Think\Controller;

class BaseController extends Controller
{

    protected $model;

    public function index()
    {

        //如果有搜索关键字 则在查询条件设为数组 在数组中加入name作为查询模糊查询的条件
        $keyword = I('get.keyword');
        if (!empty($keyword)) {
            //将传入的解译的文字条件转为文字
            $keyword = urldecode($keyword);
            $wheres['name'] = array('like', "%{$keyword}%");
        }
        //>>2. 查询数据 分配结果
        $PageResult = $this->model->getPageResult($wheres);
        $this->assign($PageResult);
        //>>3. 展示页面
        //将修改前的页面url地址保存到cookie中 操作成功后直接跳转到该地址
        cookie('__forward__', $_SERVER['REQUEST_URI']);
        $this->assign('meta_title', $this->meta_title);
        $this->display('index');
    }

    /**
     * 通过url地址传递的状态值 改变状态
     * @param $id
     * @param $status
     */
    public function changeStatus($id, $status = -1)
    {

        //>>2. 改变对应id的状态值
        $result = $this->model->changeStatus($id, $status);
        if ($result !== false) {
            $this->success('操作成功!', cookie('__forward__'));
        } else {
            $this->error('操作失败!' . show_model_error($this->model));
        }
    }

    public function add()
    {
        if (IS_POST) {

            //>>2. 开启自动验证
            if ($this->model->create() !== false) {
//                dump(I('post.'));
//                exit;
                if ($this->model->add() !== false) {
                    $this->success('添加成功!', U('index'));
                    return;
                }
            }
            $this->error('验证失败' . show_model_error($this->model));
        } else {
            //展示添加页面
            $this->assign('meta_title', '添加'.$this->meta_title);
            $this->display('edit');
        }
    }

    public function edit($id)
    {

        if (IS_POST) {
            // 得到对应id 去修改当前id的值
            if ($this->model->create() !== false) {
                if ($this->model->save() !== false) {
                    $this->success('修改成功!', cookie('__forward__'));
                    return;
                }
            }
            $this->error('修改失败!' . show_model_error($this->model));
        } else {
            $row = $this->model->find($id);
            //>>2.分配数据 展示到页面
            $this->assign($row);
            $this->assign('meta_title', '编辑'.$this->meta_title);
            $this->display('edit');
        }
    }





    protected function _initialize()
    {
        //>>1. 加载模型类
        $this->model = D(CONTROLLER_NAME);
    }
}