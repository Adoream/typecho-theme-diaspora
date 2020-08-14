<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/*
 * @Author: Jin
 * @Date: 2020-03-12 14:13:39
 * @LastEditors: Jin
 * @LastEditTime: 2020-03-12 21:01:37
 * @FilePath: /diaspora/component/comments.php
 */
?>
<?php define('__TYPECHO_GRAVATAR_PREFIX__', 'https://gravatar.loli.net/avatar/'); ?>
<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';  //如果是文章作者的评论添加 .comment-by-author 样式
        } else {
            $commentClass .= ' comment-by-user';  //如果是评论作者的添加 .comment-by-user 样式
        }
    } 
    $commentLevelClass = $comments->_levels > 0 ? ' comment-child' : ' comment-parent';  //评论层数大于0为子级，否则是父级
?> 
<li class="comment<?php 
if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-even');
echo $commentClass;
?>" id="<?php $comments->theId(); ?>">
	<div id="div-<?php $comments->theId(); ?>" class="comment-body">
		<div class="comment-author vcard">
            <?php $comments->gravatar('40', ''); ?>
            <cite class="fn"><?php $comments->author(); ?></cite>
            <span class="says">说道：</span>
        </div>
		<div class="comment-meta commentmetadata">
            <a href="#comment-<?php $comments->theId(); ?>">
                <?php $comments->date('Y-m-d H:i'); ?>
            </a>
		</div>
        <div class="comment-content"><?php $comments->content(); ?></div>
        <div class="reply"><?php $comments->reply(); ?></div>
    </div>
    <?php if ($comments->children) { ?>
        <ol class="children">
            <?php $comments->threadedComments($options); ?>
        </ol>
    <?php } ?>
</li>
<?php } ?>

<?php if ($this->allow('comment')) { ?>
<?php $this->comments()->to($comments); ?>
<div id="<?php $this->respondId(); ?>" class="comment-respond">
    <h2 id="reply-title" class="comment-reply-title">
        发表评论
        <small><?php $comments->cancelReply(); ?></small>
    </h2>
    <form action="<?php $this->commentUrl() ?>" method="post" id="commentform" class="comment-form">
        <p class="comment-form-comment">
            <label for="comment">评论</label>
            <textarea id="textarea" name="text" cols="45" rows="8" maxlength="65525" required="required"></textarea>
        </p>
        <?php if($this->user->hasLogin()): ?>
            <div class="logged-in-as">
                <p>Logged in as <a href="<?php $this->options->adminUrl(); ?>"><?php $this->user->screenName(); ?></a>. 
                <a href="<?php $this->options->index('Logout.do'); ?>" title="Logout">Logout &raquo;</a></p>
            </div>
        <?php else: ?>
        <p class="comment-notes">
            <span id="email-notes">电子邮件地址不会被公开。</span>必填项已用
            <span class="required">*</span>标注
        </p>
        <p class="comment-form-author">
            <label for="author">姓名
            <span class="required">*</span></label>
            <input id="author" name="author" type="text" value="<?php $this->remember('author'); ?>" size="30" maxlength="245" required="required">
        </p>
        <p class="comment-form-email">
            <label for="email">电子邮件
            <span class="required">*</span></label>
            <input id="email" name="email" type="text" value="<?php $this->remember('mail'); ?>" size="30" maxlength="100" aria-describedby="email-notes" required="required">
        </p>
        <p class="comment-form-url">
            <label for="url">站点</label>
            <input id="url" name="url" type="text" value="<?php $this->remember('url'); ?>" size="30" maxlength="200">
        </p>
        <?php endif; ?>
        <p class="form-submit">
            <input type="submit" class="submit" data-now="刚刚" data-init="提交评论" data-posting="提交评论中..." data-posted="评论提交成功" data-empty-comment="必须填写评论内容" id="submit" value="发表评论">
        </p>
    </form>
</div>

<?php if ($comments->have()): ?>
<div id="comments" class="comments-area">
    <h2>评论列表</h2>

    <?php $comments->listComments(array('avatarSize' => 40, 'replyWord' => _t('回复'))); ?>
    <?php $comments->pageNav(_t('上一页'), _t('下一页')); ?>
</div>
<?php endif; ?>
<?php } ?>
