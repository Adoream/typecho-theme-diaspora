<?php 
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 友情链接
 * 
 * @package custom
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
                    <?php $this->content(); ?>
                </div>

                <ul class="friend">
                    
                </ul>

                <div class="comment-wrap">
                    <?php $this->need('component/comments.php'); ?>                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->need('component/footer.php'); ?>