<?php $__env->startSection('other-css'); ?>
    <link rel="stylesheet" href="/dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content-header'); ?>
    <h1>
        用户管理
        <small>新增用户</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo e(url('/admin')); ?>"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="<?php echo e(url('/admin/users')); ?>">用户管理</a></li>
        <li class="active">用户信息</li>
    </ol>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h2 class="page-header">填写用户信息</h2>
    <div class="box box-primary">
        <form method="post" action="<?php echo e(url('admin/user/store')); ?>">
           
            <?php echo csrf_field(); ?>

            <div class="nav-tabs-custom">
                <div class="tab-content">

                    <div class="tab-pane active">
                        <div class="form-group" id="msg" style="color:red;">
                        <?php echo e($errors->first()); ?>

						            </div>
                        <div class="form-group">
                            <label>账号
                                <small class="text-red">*</small>
                            </label>
                            <input required="required" type="text" class="form-control" name="account" autocomplete="off"
                                   placeholder="账号" minlength="3"  maxlength="80"  id="account" onblur="check()">
                        </div>
                        <div class="form-group">
                            <label>用户名
                                <small class="text-red">*</small>
                            </label>
                            <input required="required" type="text" class="form-control" name="name" autocomplete="off"
                                   placeholder="用户名" maxlength="80"  minlength="3">
                        </div>
                        <div class="form-group">
                            <label>角色
                                <small class="text-red">*</small>
                            </label>
                            <input required="required" type="text" class="form-control" name="name" autocomplete="off"
                                   placeholder="用户名" maxlength="80"  minlength="3">
                        </div>
                        <button type="submit" class="btn btn-primary">新增用户</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
    
  
   var check = function(){
    console.log(account.value)
       // 创建XMLHttpRequest对象
       var xhr = new XMLHttpRequest()
       // 增加onreadystatechange事件,以监听所属状态
       xhr.onreadystatechange = function(){
         // readyState等于4,加载完成并且状态码200加载成功或者状态码304未修改
         if(xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 304)){
          //将得到的JSON字符串转为JS能处理的数据
          var friends = JSON.parse(xhr.responseText)
            msg.innerHTML = friends.msg;
         }
       }
      // 设置get请求,请求路径及异步
      xhr.open('get', 'find/' + account.value)
      // 发送请求
      xhr.send()
    }
  </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>