<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/*
 * @Author: Jin
 * @Date: 2020-03-11 12:19:36
 * @LastEditors: Jin
 * @LastEditTime: 2020-03-12 21:54:05
 * @FilePath: /diaspora/functions.php
 */
require_once("lib/Const.php");
require_once("lib/Diaspora.php");
require_once("lib/Settings.php");
require_once("lib/Title.php");
require_once("lib/Content.php");

function themeInit(Widget_Archive $archive) {
    Diaspora::init();

    if ($archive->is('archive', 404)) {
        $path_info = trim($archive->request->getPathinfo(), '/');
        if ($path_info == 'action/like') {
            header("HTTP/1.1 200 OK");
            $cid = $archive->request->filter('int')->cid;
            Content::likeUp($cid);
            $archive->response->goBack();
            exit();
        }
    }
}

function themeConfig ($form) {       
    echo Diaspora::welcome();
         
    $form->addInput(new Title('imageTitle', NULL, NULL, _t('配图及图像管理'), NULL));
    $defaultBg = new Typecho_Widget_Helper_Form_Element_Textarea('defaultBg', NULL, NULL, _t('站点背景大图地址'), _t('在这里填入图片的URL地址, 以在网站首页显示一个背景大图。每行填写一个链接（自动换行的视为同一行），多行则随机选一张进行展示，留空则不显示。'));
    $form->addInput($defaultBg);
    $defaultThumbnails = new Typecho_Widget_Helper_Form_Element_Textarea('defaultThumbnails', NULL, NULL, _t('默认背景图列表'), _t('在这里填入图片的URL地址, 每行填写一个链接（自动换行的视为同一行），在文章没有配置文章主图的时候，将会从这里挑选一张图片进行显示。'));
    $form->addInput($defaultThumbnails);
    
    $form->addInput(new Title('extendsTitle', NULL, NULL, _t('扩展功能'), NULL));
    $GoogleAnalytics = new Typecho_Widget_Helper_Form_Element_Text('GoogleAnalytics', NULL, NULL, _t('Google 统计代码'));
    $form->addInput($GoogleAnalytics);
    
    $form->addInput(new Title('customExtendsTitle', NULL, NULL, _t('主题自定义扩展')));
    $customHTMLInHeadTitle = new Typecho_Widget_Helper_Form_Element_Textarea('customHTMLInHeadTitle', NULL, NULL, _t('自定义 HTML 元素拓展 - 标签: head 头部 (meta 元素后)'), _t('在 head 标签头部(meta 元素后)添加你自己的 HTML 元素<br>你可以在这里拓展一些 meta 信息, 或一些其他信息。<br>某些统计代码可能要求被加入到尽可能靠前的位置, 那么你可以将其加入到这里。<br>不建议在这里添加 css'));
    $form->addInput($customHTMLInHeadTitle);
    $customHTMLInHeadBottom = new Typecho_Widget_Helper_Form_Element_Textarea('customHTMLInHeadBottom', NULL, NULL, _t('自定义 HTML 元素拓展 - 标签: head 尾部 (head 标签结束前)'), _t('在 head 尾部 (head 标签结束前)添加你自己的 HTML 元素<br>你可以在这里使用 link 标签引入你自己的 CSS 代码文件, 或直接使用 style 标签输出 css 代码, 或一些其他信息。<br>某些统计代码可能要求被加入到 head 标签中(如百度统计), 那么你可以将其加入到这里。'));
    $form->addInput($customHTMLInHeadBottom);
    $beforeBodyClose = new Typecho_Widget_Helper_Form_Element_Textarea('beforeBodyClose', NULL, NULL, _t('自定义 HTML 元素拓展 - 在 body 标签结束前'), _t('在 body 标签结束前添加你自己的 HTML 元素<br>你可以在这里使用 script 标签引入你自己的 js 代码文件, 或直接使用 script 标签输出 js 代码, 或一些其他信息。'));
    $form->addInput($beforeBodyClose);
}

function themeFields ($layout) {
    echo '
        <style>.typecho-post-option .text, textarea { width:100% } textarea { height: 10em }</style>
        <script>
            window.addEventListener("keydown", function(e) {
                if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                    e.preventDefault();
                    document.getElementById("btn-submit").click();
                    return true;
                }
            }, false);
        </script>
    ';
    $coverList = new Typecho_Widget_Helper_Form_Element_Textarea('coverList', NULL, NULL, _t('背景图列表'), _t('输入图片URL，如有多个则一行一个，随机选择展示。'));
    $layout->addItem($coverList);
    $bgMusicList = new Typecho_Widget_Helper_Form_Element_Textarea('bgMusicList', NULL, NULL, _t('音乐列表'), _t('输入音乐URL，如有多个则一行一个，随机选择播放。'));
    $layout->addItem($bgMusicList);
}
?>