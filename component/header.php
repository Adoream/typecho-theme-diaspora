<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/*
 * @Author: Jin
 * @Date: 2020-03-11 12:20:51
 * @LastEditors: Jin
 * @LastEditTime: 2020-03-13 09:29:29
 * @FilePath: /Diaspora/component/header.php
 */
?>

<?php if (!Diaspora::isAjax()) { ?>
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
    <script>
        window['LocalConst'] = {
            MAX_PAGES: <?php echo Diaspora::getPageSize() ?>
        };
    </script>
    <style>
        .image-logo{background-image:url(<?php $this->options->themeUrl('assets/images/smoe.svg'); ?>)}body.mu .image-logo{background-image:url(<?php $this->options->themeUrl('assets/images/smoe.svg'); ?>)}.image-icon{background-image:url(<?php $this->options->themeUrl('assets/images/logo_min.svg'); ?>)}
    </style>

    <?php $this->header(); ?>
</head>
<body class="loading">
    <div id="loader"></div>

    <div class="nav">
        <ul id="menu-menu" class="menu">
            <?php $this->need('component/navigation.php'); ?>
        </ul>
        <p>&copy; <?php echo date("Y") ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>. Proudly published with <a rel="external nofollow" href="https://typecho.org">Typecho</a>. Theme <a href="https://github.com/LoeiFy/Diaspora">Diaspora</a> Modified by <a href="https://jcl.moe">Jin</a>.</p>
    </div>

<?php }?>