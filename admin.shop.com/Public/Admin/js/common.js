$(function(){
  //首页全选中复选框
  $('.selectAll').click(function(){
    //如果是为属性设置布尔类型的值 就用prop设置属性
    $('.ids').prop('checked',$(this).prop('checked'))
      });
  //给所有子选框设置点击事件
  $('.ids').click(function(){
    //如果没有选中的子选框的个数为0 即全部选中 则父选框选中
     $('.selectAll').prop('checked',$('.ids:not(:checked)').length==0)
  });
  //>>1. 通用的ajax的get请求
  $('.ajax-get').click(function(){
    //>>1.  发送ajax请求
    var url=$(this).attr('href');
    $.get(url,'',showAjaxLayer);
    //>>2. 取消默认跳转操作
    return false;
  });


    //>>2. 通用的ajax的post请求
   $('.ajax-post').click(function() {
     //执行ajax的post方法
     var form = $(this).closest('form');
     ////获取表单中传递的url值
     //var url=form.attr('action');
     ////系列化表单中的参数
     //var params=form.serialize();
     ////ajax的post方法
     //$.post(url,params,showAjaxLayer);
     /**
      * 通过jequery.ajax的方法 进行表单提交
      * 发送请求后 如果执行成功 则执行对象中的success属性的回调方法
      * 显示提示框 提示框执行完毕后 跳转到返回数据中的保存到cookie中的url地址
      */
     if (form.length !== 0) {
       form.ajaxSubmit({
         success: showAjaxLayer
       });
     } else {
       var url = $(this).attr('url');
       var params = $('.ids').serialize();
       $.post(url, params, showAjaxLayer)

     }



     //取消默认操作
     return false;
 });

  //显示提示框
  function showAjaxLayer(data){
    var icon='';
    if(data.status){
      icon=1;//成功符号
    }else{
      icon=2;//失败符号
    }
    layer.msg(data.info,{
      //执行时间
      time:1000,
      offset:0,
      shift:1,
      //提示框的样式
      icon:icon,
    },function(){
      if(data.url){
        //窗口提示完毕后 执行的代码
        location.href=data.url;
      }
    })

  }
});