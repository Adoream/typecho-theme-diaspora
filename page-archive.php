<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 归档
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
        <div class="images">
        </div>
        <div class="article">
            <div>
                <div class="content">
                    <?php
                    $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($archives);

                    $year = 0;
                    $mon = 0;
                    $i = 0;
                    $j = 0;

                    while ($archives->next()) {
                        $year_tmp = date('Y', $archives->created);
                        $mon_tmp = date('m', $archives->created);
                        $y = $year;
                        $m = $mon;
                        if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></li>';
                        if ($year != $year_tmp && $year > 0) $output .= '</ul>';
                        if ($year != $year_tmp) {
                            $year = $year_tmp;
                            $output .= '<h2><strong>' . $year . ' 年 <strong></h2><ul>'; //输出年份
                        }
                        if ($mon != $mon_tmp) {
                            $mon = $mon_tmp;
                            $output .= '<li><span>' . $mon . ' 月</span><ul>'; //输出月份
                        }
                        $output .= '<li>' . date('d日: ', $archives->created) . '<a href="' . $archives->permalink . '">' . $archives->title . '</a> </li>'; //输出文章日期和标题
                    }
                    $output .= '</ul></li></ul>';

                    echo $output;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->need('component/footer.php'); ?>