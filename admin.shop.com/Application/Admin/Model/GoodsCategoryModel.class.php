<?php

namespace Admin\Model;


use Think\Model;
use Think\Page;

class GoodsCategoryModel extends BaseModel
{

    //开启自动验证

    protected $_validate = array(
    array('name','require','名称不能为空!'),
    array('parent_id','require','父分类不能为空!'),
    array('intro','require','简介不能为空!'),
    );

     public function getTreeList(){
         return $this->where(array('status'=>array('gt',-1)))->order('lft')->select();
     }

}