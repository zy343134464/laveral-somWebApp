	<!--  **************************start************************   -->
   
<?php $__env->startSection('title', '会员管理'); ?>
<?php $__env->startSection('other_css'); ?>
    <link rel="stylesheet" href="<?php echo e(url('css/admin/user/user.css')); ?>">
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('body'); ?>
    <!-- 头部 -->
    <section class="content-header">
        <div class="row">
            <div class="col-xs-3 timefiltrate">
                <div class="dropdown">
                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        全部角色
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#">查看所有</a></li>
                        <li><a href="#">管理员</a></li>
                        <li><a href="#">评委</a></li>
                        <li><a style="color:#ccc;">摄影人</a></li>
                        <li><a style="color:#ccc;">策展人</a></li>
                        <li><a href="#">注册用户</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-3 statefiltrate" style="margin-left:-190px;">
                <div class="dropdown">
                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        角色等级
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <li><a href="<?php echo e(url('admin/user')); ?>">查看所有</a></li>
                        <li><a href="<?php echo e(url('admin/user?vip_level=1')); ?>">超级管理员</a></li>
                        <li><a href="<?php echo e(url('admin/user?vip_level=2')); ?>">二级管理员</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </section>
    <!--内容-->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!--搜索框-->
                <form action="<?php echo e(url('/admin/user')); ?>" >
                    <div class="search-form">
                        <button class="btn btn-sm btn-default fa fa-search" style="margin-left:-10px;border:none;"></button>
                        <input type="text" name="kw" placeholder="请输入手机或用户名">
                    </div>
                </form>
                <!--批量导出-->
                <div class="batch-export">
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle toggle-vis" type="button">
                            导出
                        </button>
                    </div>
                </div>
                <div class="batch-enter">
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle toggle-vis" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            导入
                            <i class="fa fa-sort-down"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                            <li><a href="<?php echo e(url('admin/user/getfeild')); ?>">下载模板</a></li>
                            <li role="presentation" class="divider"></li>
                            <li><a href="#">上传模板</a></li>
                        </ul>
                    </div>
                </div>
                <div class="hand-users">
                    <div class="dropdown">
                        <a class="btn btn-success dropdown-toggle toggle-vis" href="<?php echo e(url('admin/user/create')); ?>">
                            新建用户
                        </a>
                    </div>
                </div>
                <div class="tab-title">
                    <ul class="nav nav-tabs" role="tablist">
                        <!-- <li role="presentation" class="<?php echo e($type ? 'active' : ''); ?> "><a href="<?php echo e(url('admin/user?type=1')); ?>">机构用户</li></a>
                        <li role="presentation" class="<?php echo e($type ?  '':'active'); ?>"><a href="<?php echo e(url('admin/user?type=0')); ?>">普通用户</a></li> -->
                        <li role="presentation" class="active"><a href="<?php echo e(url('admin/user?type=1')); ?>">我的会员</li></a>
                        <li role="presentation" class=""><a href="<?php echo e(url('admin/user?type=0')); ?>">普通用户</a></li>

                    </ul>
                </div>
                <div class="box">
                    <div class="box-body">
                        <table id="example1" class="table text-center" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>用户名</th>
                                <th>手机</th>
                                <th>角色</th>
                                <th>注册时间</th>
                                <th>编辑</th>
                                <!-- <th>站内信</th> -->
                            </tr>
                            </thead>
                            <tbody class="panel panel-default">
							<!--   foreach start -->
							<?php if( count($users) ): ?>
							<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="checkbox">
                                </td>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->phone); ?></td>
                                <td><?php echo e($user->role($user->id,0)); ?></td>
                                <td><?php echo e(date('Y-m-d', $user->reg_time)); ?></td>
                                <td>
                                    <a href="<?php echo e(url('admin/user/edit').'/'.$user->id); ?>"><i class="fa fa-edit"></i></a>
                                </td>
                                <!-- <td>
                                    <a href="#"><i class="fa fa-envelope-o"></i></a>
                                </td> -->
                            </tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?>
							<tr>
								<td style="color:red;">暂无数据</td>
							</tr>
                            <?php endif; ?>
                           <!--   foreach end -->
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="paging text-center">
                    <?php echo e($users->appends(['kw' => $kw])->links()); ?>

                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
<!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('other_js'); ?>
    <script src="<?php echo e(url('js/admin/user/user.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>