
namespace Admin\Model;


use Think\Model;
use Think\Page;

class <?php echo $name ?>Model extends BaseModel
{

    //开启自动验证

    protected $_validate = array(
<?php  foreach($fields as $field){
       if($field['null']=='yes'){
            continue;
        }
        echo "array('{$field['field']}','require','{$field['comment']}不能为空!'),\r\n";
} ?>
    );



}