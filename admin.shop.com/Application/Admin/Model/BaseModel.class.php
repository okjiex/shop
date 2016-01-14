<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/10
 * Time: 11:18
 */

namespace Admin\Model;


use Think\Model;
use Think\Page;

class BaseModel extends Model
{
    // 是否批处理验证
    protected $patchValidate = true;

    public function getList()
    {
        return $this->where(array('status' => array('gt', -1)))->select();
    }

    /**
     * array(
           * 'rows'=>查询出的状态>-1的数据
     *     'pageHtml'=> 分页条页面
     * )
     */
    public function getPageResult($wheres = array())
    {
        // 整个页面显示总条数(>-1)的状态不显示
        $wheres['status'] = array('gt', -1);
        //>>1. 分页条页面

        $totalRows = $this->where($wheres)->count();
        //每页显示的条数
        $listRows = 2;
        $page = new Page($totalRows, $listRows);
        if ($page->firstRow >= $totalRows) {
            //如果起始条数大于总条数(5>4)
            //生成最后一页的起始条数=总条数-每页显示条数
            $page->firstRow = $totalRows - $listRows;
        }
//        //将传入的解译的文字条件转为文字
//        foreach ($wheres['name'] as $key => $val) {
//            $page->parameter .= "$key=" . urldecode($val) . '&';
//        }
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $pageHtml = $page->show();
        //>>2. 查询出的状态>-1的数据
        $rows = $this->where($wheres)->limit($page->firstRow, $listRows)->select();


        return array('rows' => $rows, 'pageHtml' => $pageHtml);
    }

    public function changeStatus($id, $status = -1)
    {
        $data = array('id' => array('in', $id), 'status' => $status);
        if ($status == -1) {
            //如果传入的status值为-1 那么就将status的值改为-1 并且将id对应的name的值后面加一个_del
            $data['name'] = array('exp', "concat(name,'_del')");
        }
        return parent::save($data);
    }}