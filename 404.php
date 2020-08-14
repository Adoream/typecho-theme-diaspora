<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/*
 * @Author: Jin
 * @Date: 2020-03-11 12:19:25
 * @LastEditors: Jin
 * @LastEditTime: 2020-08-14 13:26:11
 * @FilePath: /Diaspora/404.php
 */
?>
<?php $this->need('component/header.php'); ?>

<div id="single" class="page">
    <div id="top">
        <a class="image-icon" href="javascript:history.back()"></a>
    </div>

    <div class="section">
        <div class="images"></div>
        <div class="article">
            <div>

                <div class="content">
                    <h1>404 Not Found</h1>
                    <p>The page you were looking for is no longer available.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->need('component/footer.php'); ?>