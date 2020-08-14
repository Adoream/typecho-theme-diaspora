<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/*
 * @Author: Jin
 * @Date: 2020-03-11 12:19:13
 * @LastEditors: Jin
 * @LastEditTime: 2020-03-13 09:03:16
 * @FilePath: /Diaspora/page.php
 */
?>
<div id="single" class="page">
    <div id="top">
        <a class="image-icon" href="javascript:history.back()"></a>
    </div>

    <div class="section" style="left: 0;">
	    <div class="article">
            <div>
                <div class="content">
        		    <?php $this->content(); ?>
                </div>
                
                <div class="comment-wrap">
                    <?php $this->need('component/comments.php'); ?>                    
                </div>
            </div>
        </div>
    </div>
</div>