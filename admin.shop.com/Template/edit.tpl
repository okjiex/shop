<extend name="Common/edit"/>
<block name="list">
    <div class="main-div">
        <form method="post" action="{: U()}" >
            <table cellspacing="1" cellpadding="3" width="100%">
                <input type="hidden" value="{\$id}"/>
                <?php foreach($fields as $field):?>
                <tr>
                    <td class="label" ><?php echo $field['comment'] ?></td>

                    <td>
                        <?php
                    if(!isset($field['field_type'])){
                       if($field['field']=='sort'){
                       echo "<input type='text' name='sort' maxlength='60' value='{\$sort|default='20'}' /><span class='require-field'>*</span>";
                       }else{
                        echo "<input type='text' name='{$field['field']}' maxlength='60' value='{\${$field['field']}}' /><span class='require-field'>*</span>";
                        }
                      }elseif($field['field_type']=='textarea'){
                        echo "<textarea  name='{$field['field']}' cols='60' rows='4'  >{\${$field['field']}}</textarea>";
                        }elseif($field['field_type']=='radio'){
                           foreach($field['option_values'] as $k=>$v){
                             echo "<input type='radio' class='{$field['field']}' name='{$field['field']}' value='{$k}'  /> {$v}";
                          }
                       }elseif($field['field_type']=='file'){
                         echo "<input type='file' name='{$field['field']}' maxlength='40' size='15' />";
                        }
                        ?>
                    </td>

                </tr>
                <?php endforeach;?>
                <tr>
                    <td colspan="2" align="center"><br />
                        <input type="hidden" name="id" value="{$id}" />
                        <input type="submit" class="button ajax-post" value=" 确定 " />
                        <input type="reset" class="button" value=" 重置 " />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</block>