<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/*
 * @Author: Jin
 * @Date: 2020-03-11 12:19:25
 * @LastEditors: Jin
 * @LastEditTime: 2020-03-12 22:11:24
 * @FilePath: /diaspora/post.php
 */
?>
<?php $this->need('component/header.php'); ?>
<div id="single" data-id="<?php $this->cid(); ?>">
    <div id="top">
        <div class="bar"></div>
        <a class="image-icon" href="javascript:history.back()"></a>
        <div title="播放/暂停" data-id="<?php $this->cid(); ?>" class="icon-play"></div>
		<h3 class="subtitle"><?php $this->title(); ?></h3>
        <div class="social">
            <div class="like-icon">
                <a href="javascript:;" class="likeThis" id="like-<?php $this->cid(); ?>"><span class="icon-like"></span><span class="count likeNum">0</span>
                </a>
            </div>
            <div>
                <div class="share">
                    <a title="获取二维码" class="icon-wechat" href="javascript:;"></a>
                </div>
                <div id="qr"></div>
            </div>
        </div>
        <div class="scrollbar"></div>
    </div>
    
    <div class="section" style="left: 0;">
        <div class="images"></div>
        <div class="article">
            <div>
        		<h1 class="title"><?php $this->title(); ?></h1>
        
                <div class="stuff">
                    <span><?php echo Content::cnDate(date('m', $this->date->timeStamp)) . ' ' . date("d, Y", $this->date->timeStamp) ?></span>
                    <span>阅读 <span id="readNum"><?php echo Content::postViews($this); ?></span></span>
                    <span>字数 <span id="wordNum"><?php echo Content::utf8Strlen($this->content); ?></span></span>
                    <span>
                        喜欢 
                        <a href="javascript:;" class="likeThis" id="like-<?php $this->cid(); ?>">
                            <span class="icon-like"></span>
                            <span class="count likeNum"><?php echo Content::likeNum($this->cid); ?></span>
                        </a>
                    </span>
                </div>
        
                <div class="content">
                    <?php $this->content(); ?>
                </div>
        
                <div class="comment-wrap">
                    <?php $this->need('component/comments.php'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php if($this->fields->bgMusicList) { ?>
        <audio id="audio-<?php $this->cid(); ?>-1" loop="1" preload="auto" controls="controls">
            <source type="audio/mpeg" src="<?php echo Content::rankPostMusic($this->fields->bgMusicList) ?>">
        </audio>
    <?php } ?>
</div>

<?php $this->need('component/footer.php'); ?>