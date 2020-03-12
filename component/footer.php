<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/*
 * @Author: Jin
 * @Date: 2020-03-11 12:21:11
 * @LastEditors: Jin
 * @LastEditTime: 2020-03-12 13:43:32
 * @FilePath: /diaspora/component/footer.php
 */
?>
    <script src="<?php $this->options->themeUrl('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('assets/js/plugin.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('assets/js/Diaspora.js'); ?>"></script>
    <?php $this->footer(); ?>
</body>
</html>
