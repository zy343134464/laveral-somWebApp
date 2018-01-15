<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta property="wb:webmaster" content="b1217e0e46e1e300"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta id="token" name="token" value="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $__env->startSection('header-css'); ?>
    <link href="//cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(url('css/source/semantic.min.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo e(url('dist/css/AdminLTE.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('dist/css/_all-skins.min.css')); ?>">
    <?php echo $__env->yieldSection(); ?>

    <?php $__env->startSection('other-css'); ?>
    <?php echo $__env->yieldSection(); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    
    <?php $__env->startSection('main-header'); ?>
    <?php echo $__env->yieldSection(); ?>

    
    <?php $__env->startSection('main-sidebar'); ?>

    
    <?php echo $__env->yieldSection(); ?>

    
    <div class="content-wrapper">
        <section class="content-header">
            <?php $__env->startSection('content-header'); ?>
            <?php echo $__env->yieldSection(); ?>
        </section>
        <section class="content">
            <?php $__env->startSection('content'); ?>
            <?php echo $__env->yieldSection(); ?>
        </section>
    </div>

    
    <?php $__env->startSection('main-footer'); ?>
    <?php echo $__env->yieldSection(); ?>

    
    <?php $__env->startSection('control-sidebar'); ?>
    <?php echo $__env->yieldSection(); ?>

    <?php $__env->startSection('head-js'); ?>
        <script src="//cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//cdn.bootcss.com/vue/2.0.0-rc.5/vue.min.js"></script>
        <script src="https://cdn.jsdelivr.net/vue.resource/1.0.2/vue-resource.min.js"></script>
        <script src="<?php echo e(url('dist/js/app.min.js')); ?>"></script>
        <script src="<?php echo e(url('dist/js/demo.js')); ?>"></script>
    <?php echo $__env->yieldSection(); ?>

    
    <?php $__env->startSection('other-js'); ?>
    <?php echo $__env->yieldSection(); ?>

    <script type="text/javascript">
        $(document).ready(function () {
            var path_array = window.location.pathname.split('/');
            var scheme_less_url = '//' + window.location.host + window.location.pathname;
            if (path_array[1] == 'dashboard') {
                scheme_less_url = window.location.protocol + '//' + window.location.host + '/' + path_array[1];
            } else {
                scheme_less_url = window.location.protocol + '//' + window.location.host + '/' + path_array[1] + '/' + path_array[2] + '/' + 'index';
            }
            $('ul.treeview-menu>li').find('a[href="' + scheme_less_url + '"]').closest('li').addClass('active');  //二级链接高亮
            $('ul.treeview-menu>li').find('a[href="' + scheme_less_url + '"]').closest('li.treeview').addClass('active');  //一级栏目[含二级链接]高亮
            $('.sidebar-menu>li').find('a[href="' + scheme_less_url + '"]').closest('li').addClass('active');  //一级栏目[不含二级链接]高亮
        });
    </script>
</div>
</body>
</html>