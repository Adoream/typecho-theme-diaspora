<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/*
 * @Author: Jin
 * @Date: 2020-03-11 12:21:11
 * @LastEditors: Jin
 * @LastEditTime: 2020-03-13 09:10:48
 * @FilePath: /Diaspora/component/footer.php
 */
?>
<?php if (!Diaspora::isAjax()) { ?>
    <script src="<?php $this->options->themeUrl('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('assets/js/plugin.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('assets/js/Diaspora.js'); ?>"></script>
    <?php if (isset($this->options->beforeBodyClose)) echo $this->options->beforeBodyClose ?>
    <?php $this->footer(); ?>
</body>
</html>
<?php } ?>