<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/*
 * @Author: Jin
 * @Date: 2020-03-12 13:43:06
 * @LastEditors: Jin
 * @LastEditTime: 2020-08-14 13:44:30
 * @FilePath: /Diaspora/component/pagination.php
 */
?>
<?php
if (ceil($this->getTotal() / $this->parameter->pageSize) > $this->_currentPage) {
?>
<<<<<<< HEAD
    <div id="pager">
        <a href="<?php echo (($this->options->rewrite) ? $this->options->siteUrl : $this->options->siteUrl . 'index.php'); ?>/page/<?php echo (int)($this->_currentPage) + 1 ?>/" data-url="<?php $this->options->siteUrl(); ?>/page/<?php echo (int)($this->_currentPage) + 1 ?>/" class="more">加载更多</a>
    </div>
<?php
}
?>
=======
<div id="pager">
    <a href="<?php echo (($this->options->rewrite) ? $this->options->siteUrl : $this->options->siteUrl . 'index.php'); ?>/page/<?php echo (int)($this->_currentPage)+1 ?>/" data-url="<?php $this->options->siteUrl(); ?>/page/<?php echo (int)($this->_currentPage)+1 ?>/" class="more">加载更多</a>
</div>
<?php 
    }
?>
>>>>>>> c6bd7e7062600aeea042fcef845a650fa90c18eb
