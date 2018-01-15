<?php $__env->startSection('content-header'); ?>
    <h1>
        用户管理
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo e(url('/dashboard')); ?>"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li>角色管理 </li>

        <li class="active"> <a href="<?php echo e(url('login')); ?>">登录</a></li>
    </ol>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <h2 class="page-header">角色列表</h2>
    <a href="<?php echo e(url('admin/role/create')); ?>" class="btn btn-sm btn-success">添加角色</a>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">列表页</h3>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-hover table-bordered">
                <tbody>
                <!--tr-th start-->
                <tr>
                    <th>ID</th>
                    <th>角色名</th>
                    <th>付费等级</th>
                    <th>机构id</th>
                    <th>操作</th>
                </tr>
                <!--tr-th end-->
                <?php if(count($roles)): ?>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-muted"><?php echo e($role->id); ?></td>
                        <td class="text-muted"><?php echo e($role->role_name); ?></td>
                        <td class="text-muted"><?php echo e($role->vip_level); ?></td>
                        <td class="text-navy"><?php echo e($role->organ_id); ?></td>
                        <td>
                            <a style="font-size: 16px;padding: 4px;" href="<?php echo e(url('/admin/role/edit').'/'.$role->id); ?>" class="ui button"><i class="fa fa-fw fa-pencil" title="修改"></i></a>
                            <a style="font-size: 16px;padding: 4px;" href="<?php echo e(url('/admin/role/del').'/'.$role->id); ?>" class="ui button"><i class="fa fa-fw fa-trash-o" title="删除"></i></a>
                            
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <tr>
                    <td colspan="6" style="color:red;">暂无数据</td>
                </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>