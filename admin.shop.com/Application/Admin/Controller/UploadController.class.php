<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/12
 * Time: 21:31
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Upload;

class UploadController extends Controller
{
    public function index()
    {
          //获取到文件存放的文件夹
        $dir = I('post.dir');

        $config = array(
//            'rootPath'     => './Uploads/', //保存根路径
            'rootPath'     => './', //保存到upyun的根路径
           'savePath'     => $dir.'/', //保存路径
            'driver'       => 'Upyun', // 文件上传驱动
            'driverConfig' => array(
                'host'     => 'v0.api.upyun.com', //又拍云服务器
                'username' => 'itsource', //又拍操作员用户
                'password' => 'itsource', //又拍云操作员密码
                'bucket'   => $dir, //空间名称
                'timeout'  => 90, //超时时间
            ), // 上传驱动配置
        );
        $uploader = new Upload($config);
        $result = $uploader->uploadOne($_FILES['Filedata']);
        if($result!==false){
            //将上传后的路径发送给浏览器
            echo $result['savepath'].$result['savename']; //保存到upyun上的地址
        }else{
            echo $uploader->getError();
        }
       }
}