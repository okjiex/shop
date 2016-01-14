<?php

namespace Admin\Controller;


use Think\Controller;

class GoodsCategoryController extends BaseController
{
       protected $meta_title="商品分类";

       public function index()
       {

              $rows=$this->model->getTreeList();
              $this->assign('rows',$rows);
              $this->assign('meta_title', $this->meta_title);
              $this->display('index');
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
}