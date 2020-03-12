<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/*
 * @Author: Jin
 * @Date: 2020-03-11 12:20:51
 * @LastEditors: Jin
 * @LastEditTime: 2020-03-12 13:14:16
 * @FilePath: /diaspora/component/header.php
 */
?>
<!DOCTYPE html>
<html class="loading">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="google" content="notranslate" />
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/Diaspora.css'); ?>">

    <style>
        .image-logo{background-image:url(<?php $this->options->themeUrl('assets/images/logo.png'); ?>)}body.mu .image-logo{background-image:url(<?php $this->options->themeUrl('assets/images/logo_black.png'); ?>)}.image-icon{background-image:url(<?php $this->options->themeUrl('assets/images/logo_min.png'); ?>)}
    </style>

    <script>
        window['Page'] = {
            SITEURL: '{{@blog.url}}',
            MAXPAGES: parseInt ('{{#if pagination.pages}}{{pagination.pages}}{{else}}0{{/if}}'),
            DISQUS_SHORT_NAME: 'zuimoe'
        }
    </script>

    <?php $this->header(); ?>
</head>
<body class="loading">
    <div id="loader"></div>

    <div class="nav">
        <ul id="menu-menu" class="menu">
            <?php $this->need('component/navigation.php'); ?>
        </ul>
        <p>&copy; <?php echo date("Y") ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>. Proudly published with <a href="https://typecho.org">Typecho</a></p>
    </div>

