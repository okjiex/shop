<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/6
 * Time: 19:27
 */

namespace Admin\Model;


use Think\Model;
use Think\Page;

class SupplierModel extends BaseModel
{

    //开启自动验证
    protected $_validate = array(
        array('name','require','名字不能为空!'),
        array('name','','名字已经存在,请换个名字!','','unique'),
        array('intro','require','描述不能为空!'),
    );


}