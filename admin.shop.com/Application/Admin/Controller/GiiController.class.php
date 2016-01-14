<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/10
 * Time: 18:39
 */

namespace Admin\Controller;


use Think\Controller;

class GiiController extends Controller
{
      public function index(){
          if(IS_POST){
              //>>1. 获取表单中用户输入的名字
              $table_name=I('post.name');
              //>>2. 将用户输入的名字 转换为ThinkPhp规范的名字
              $name=parse_name($table_name,1);
              //>>3. 获取到当前表的表注释 作为meta_title的值
              $sql="SELECT TABLE_COMMENT FROM information_schema.`TABLES` WHERE table_name='{$table_name}' AND TABLE_SCHEMA='".C('DB_NAME')." '";
              $model=M();
              $result=$model->query($sql);
              $meta_title=$result[0]['table_comment'];

                //获取不能为空的字段
              $sql="SHOW FULL COLUMNS FROM ".$table_name;
              $fields=$model->query($sql);
              foreach($fields as $k=>&$field){
                  if($field['field']=='id'){
                      //删除id所在的元素
                      unset($fields[$k]);
                  }
                  $comment=$field['comment'];
                  if(strpos($comment,'@')!==false){
                      $reg="/(.*)@([a-z]+)\|?(.*)/";
                      preg_match($reg,$comment,$res);
                      $field['comment']=$res[1];
                      $field['field_type']=$res[2];
                      if(!empty($res[3])){
                          parse_str($res[3],$data);
                          $field['option_values']=$data;
                      }
                  }
              }
              unset($field);
//              dump($fields);
//              exit;
              //>>4. 引入控制器模板文件
                  //定义模板路径
              defined('TPL_PATH') or define('TPL_PATH',ROOT_PATH.'Template/');
              require TPL_PATH."Controller.tpl";
              //>>5. 获取缓存内容 并且清楚缓存区的内容
              $controller_Contents="<?php\r\n".ob_get_clean();

              //>>6.  将获取的内容 放到指定路径的文件中
              $controllerPath=APP_PATH."Admin/Controller/".$name."Controller.class.php";
              file_put_contents($controllerPath,$controller_Contents);
              //>>7. 因为上面执行了ob_get_clean()这个命令后会自动关闭ob缓存 所有这次要再次开启ob缓存
              ob_start();
              //>>8. 引入模型模板
              require TPL_PATH."Model.tpl";
              //>>8. 获取缓存区的缓g存内容 并且情况
              $model_Contents="<?php\r\n".ob_get_clean();
              //>>6.  将获取的内容 放到指定路径的文件中
              $modelPath=APP_PATH."Admin/Model/".$name."Model.class.php";
              file_put_contents($modelPath,$model_Contents);

              //>>7. 因为上面执行了ob_get_clean()这个命令后会自动关闭ob缓存 所有这次要再次开启ob缓存
              ob_start();
              //>>8. 引入模型模板
              require TPL_PATH."edit.tpl";
              //>>8. 获取缓存区的缓g存内容 并且情况
              $edit_Contents=ob_get_clean();

              //>>6.  将获取的内容 放到指定路径的文件中
              $editPath=APP_PATH."Admin/View/".$name.'/';
              if(!is_dir($editPath)){
                  mkdir($editPath,0777,true);
              }
              file_put_contents($editPath.'edit.html',$edit_Contents);

              //>>7. 因为上面执行了ob_get_clean()这个命令后会自动关闭ob缓存 所有这次要再次开启ob缓存
              ob_start();
              //>>8. 引入模型模板
              require TPL_PATH."index.tpl";
              //>>8. 获取缓存区的缓g存内容 并且情况
              $index_Contents=ob_get_clean();

              //>>6.  将获取的内容 放到指定路径的文件中
              $indexPath=APP_PATH."Admin/View/".$name."/index.html";
              if(!is_dir($editPath)){
                  mkdir($editPath,0777,true);
              }
              file_put_contents($indexPath,$index_Contents);

          }else{
              //展示表单页面 用于输入控制器 模型的名字
              $this->assign('meta_title','代码生成器');
              $this->display('index');
          }
      }
}