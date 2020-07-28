<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 时间线独立页面模板
 * @Date: 2020-04-29 20:06:36
 * @Author: Bapi
 * @package custom
 * @FilePath: /diaspora/page-timeline.php
 */
?>
<head>
	<meta charset="<?php $this->options->charset(); ?>">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="google" content="notranslate" />
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), ''); ?></title>
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/Diaspora.css'); ?>">
    <script>
        window['LocalConst'] = {
            MAX_PAGES: <?php echo Diaspora::getPageSize() ?>
        };
    </script>
    
<div id="single" class="page">
    <div id="top">
        <a class="image-icon" href="javascript:history.back()"></a>
    </div>
    


    <div class="section" style="left: 0;">
	    <div class="article">
            <div>
            <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($archives);
    $year=0; $mon=0; $i=0; $j=0;
    $output = '<div class="content">';
    while($archives->next()):
        $year_tmp = date('Y',$archives->created);
        $mon_tmp = date('m',$archives->created);
        $y=$year; $m=$mon;
        if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></li>';
        if ($year != $year_tmp && $year > 0) $output .= '</ul>';
        if ($year != $year_tmp) {
            $year = $year_tmp;
            $output .= '<h2><strong>'. $year .' 年 <strong></h2><ul>'; //输出年份
        }
        if ($mon != $mon_tmp) {
            $mon = $mon_tmp;
            $output .= '<li><span>'. $mon .' 月</span><ul>'; //输出月份
        }
        $output .= '<li>'.date('d日: ',$archives->created).'<a href="'.$archives->permalink .'">'. $archives->title .'</a> </li>'; //输出文章日期和标题
    endwhile;
    $output .= '</ul></li></ul></div>';
    echo $output;
?>
        		    <?php $this->content(); ?>
                </div>
                
                <div class="comment-wrap">
                    <?php $this->need('component/comments.php'); ?>                    
                </div>
            </div>
        </div>
    </div>
</div>
<head>



<div id="top" style="display: block;">
	<a href= "/"> <!-- 单独打开跳转主页而不是javascript:history.back这样返回上一页 -->
<img border="0" src="/usr/themes/Diaspora-Typecho-master/assets/images/logo_min.svg"width="24" height="24" style="position:relative;top:14px;left:14px;"></a>   </div>