<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/*
 * @Author: Jin
 * @Date: 2020-03-11 12:19:13
 * @LastEditors: Jin
 * @LastEditTime: 2020-03-12 22:12:27
 * @FilePath: /diaspora/page.php
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
                    <div id="comments" class="comments-area">
                        <h2>评论列表</h2>

                        <ol class="comment-list">
                            <?php $this->comments()->to($comments); ?>
                            <?php while($comments->next()): ?>
                                <li id="comment <?php $comments->theId(); ?>">
                                    <div class="comment-body">
                                            <?php echo $comments->sequence(); ?>. 
                                            <strong><?php $comments->author(); ?></strong>
                                            on <?php $comments->date('F jS, Y'); ?> at <?php $comments->date('h:i a'); ?>
                                        </div>
                                    <p><?php $comments->content(); ?></p>
                                </li>
                            <?php endwhile; ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>