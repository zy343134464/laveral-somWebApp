<?php $__env->startSection('other-css'); ?>
    <link rel="stylesheet" href="/dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content-header'); ?>
    <h1>
        用户管理
        <small>用户<?php echo e($user->name); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo e(url('/admin')); ?>"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="<?php echo e(url('/admin/users')); ?>">用户管理</a></li>
        <li class="active">编辑用户信息</li>
    </ol>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h2 class="page-header">编辑用户信息</h2>
    <div class="box box-primary">
        <form method="post" action="<?php echo e(url('admin/user/update')); ?>" enctype="multipart/form-data">
           
            <?php echo csrf_field(); ?>

            <div class="nav-tabs-custom">
                <div class="tab-content">

                    <div class="tab-pane active">
                        <div class="form-group">
                        <?php echo e($errors->first()); ?>

						</div>
                        <div class="form-group">
                            <label>用户名
                                <small class="text-red">*</small>
                            </label>
                            <input required="required" type="text" class="form-control" name="name" autocomplete="off"
                                   placeholder="用户名" maxlength="80" value="<?php echo e($user->name); ?>">
                        </div>
                        <div class="form-group">
                            <label>账号
                                <small class="text-red">*</small>
                            </label>
                            <input required="required" type="text" class="form-control" name="account" autocomplete="off"
                                   placeholder="账号" maxlength="80" value="<?php echo e($user->account); ?>">
                        </div>

                        <div class="form-group">
                            <label>邮箱
                                <small class="text-red">*</small>
                            </label>
                            <input required="required" type="text" class="form-control" name="email" autocomplete="off"
                                   placeholder="用户邮箱" maxlength="80" value="<?php echo e($user->email); ?>">
                                   <input type="hidden" name='id'   value="<?php echo e($user->id); ?>">

                        </div><div class="form-group">
                            <label>头像
                                <small class="text-red">*</small>
                            </label>
                            <input required="required" type="file" class="form-control" name="pic" autocomplete="off"
                                   >
                                   

                        </div>
                        

                        <button type="submit" class="btn btn-primary">更新用户信息</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('other-js'); ?>
    <script>
        $(function () {
            var  tags = document.getElementById('user-active');
            if (<?php echo e($user->is_active); ?>) {
                tags[0].selected = true
            } else {
                tags[1].selected = true
            }
        })
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>