<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="">
    <title>RBAC{{ config('app.name') ? ' - ' . config('app.name') : '' }}</title>
    <style>
        @font-face{font-family:element-icons;src:url({{asset('/vendor/rbac/fonts/vendor/element-ui/lib/theme-chalk/element-icons.woff')}}) format("woff"),url({{asset('/vendor/rbac/fonts/vendor/element-ui/lib/theme-chalk/element-icons.ttf')}}) format("truetype");}
    </style>
</head>
<body>
<div id="app" v-cloak>
    <el-menu  class="el-menu-demo"  mode="horizontal">
        <el-menu-item @click="$router.push('/user');"  index="1">用户管理</el-menu-item>
        <el-menu-item @click="$router.push('/role');" index="2">角色管理</el-menu-item>
        <el-menu-item @click="$router.push('/menu');" index="3">菜单管理</el-menu-item>
        <el-menu-item @click="$router.push('/api');" index="4">API管理</el-menu-item>
    </el-menu>
    <router-view :key="$route.fullPath"></router-view>
</div>
<script>
    window.basePath = '<?php echo  config('rbac.path','rbac') ?>';
</script>
<script src="{{asset(mix('app.js', 'vendor/rbac'))}}"></script>
</body>
</html>
