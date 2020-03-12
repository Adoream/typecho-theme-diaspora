<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/*
 * @Author: Jin
 * @Date: 2020-03-11 12:38:27
 * @LastEditors: Jin
 * @LastEditTime: 2020-03-12 13:13:46
 * @FilePath: /diaspora/component/navigation.php
 */
?>
<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
<?php while ($pages->next()) { ?>
<li class="pview menu-item menu-item-type-post_type menu-item-object-page <?php $pages->slug(); ?><?php if($this->is('page', $pages->slug)): ?> nav-current<?php endif; ?>">
    <a href="<?php $pages->permalink(); ?>" class="pviewa"><?php $pages->title(); ?></a>
</li>
<?php } ?>