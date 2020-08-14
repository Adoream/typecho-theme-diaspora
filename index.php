<?php
/**
 * 一款基于WP移植的 Typecho 主题，适合喜欢摄影，影评，乐评和玩弄文字的你，干净，清新； 响应式，Ajax，更多好玩的等你来发现。
 * 
 * @package Diaspora
 * @author Jin
 * @version 1.0.0
 * @link https://jcl.moe
 */
?>
<?php $this->need('component/header.php'); ?>
<?php 
    $article = [];
    while($this->next()) {
        $article[] = [
            'cid' => $this->cid,
            'title' => $this->title,
            'permalink' => $this->permalink,
            'author' => [
                'name' =>  $this->author->name,
                'permalink' => $this->author->permalink
            ],
            'timeStamp' => $this->date->timeStamp,
            'category' => $this->category,
            'commentNum' => $this->commentsNum,
            'content' => $this->content,
            'excerpt' => Content::substring($this->content, 100, '...'),
            'cover' => Content::getPostCover($this->cid, $this->fields->coverList),
            'views' => Content::postViews($this),
            'strLen' => Content::utf8Strlen($this->content),
            'likeNum' => COntent::likeNum($this->cid)
        ];
    }
?>
<div id="container">
    <div id="screen">
        <div id="mark">
            <div class="layer" data-depth="0.4">
                <img id="cover" crossorigin="anonymous" src="<?php echo $article[0]['cover'] ?>" width="2500" height="1637"/>
            </div>
        </div>

        <div id="vibrant">
            <svg viewBox="0 0 2880 1620" height="100%" preserveAspectRatio="xMaxYMax slice">
                <polygon opacity="0.7" points="2000,1620 0,1620 0,0 600,0 "/>
            </svg>
            <div></div>
        </div>

        <div id="header">
            <div>
                <a class="image-logo" href="/"></a>
                <div class="icon-menu switchmenu"></div>
            </div>
        </div>

        <div id="post0">
            <p><?php echo Content::cnDate(date('m', $article[0]['timeStamp'])) . ' ' . date("d, Y", $article[0]['timeStamp']) ?></p>
            <h2><a data-id="<?php echo $article[0]['cid'] ?>" class="posttitle" href="<?php echo $article[0]['permalink'] ?>"><?php echo $article[0]['title'] ?></a></h2>
            <div class="summary"><?php echo $article[0]['excerpt'] ?></div>
        </div>
    </div>

    <div id="primary">
        <?php for ($i = (Diaspora::isAjax() ? 0 : 1); $i < count($article); $i++) { ?>
            <div class="post">
                <a data-id="<?php echo $article[$i]['cid'] ?>" href="<?php echo $article[$i]['permalink'] ?>" title="<?php echo $article[$i]['title'] ?>">
                    <img width="680" height="440" src="<?php echo $article[$i]['cover'] ?>" class="cover">
                </a>
                <div class="else">
                    <p><?php echo Content::cnDate(date('m', $article[$i]['timeStamp'])) . ' ' . date("d, Y", $article[$i]['timeStamp']) ?></p>
                    <h3><a data-id="<?php echo $article[$i]['cid'] ?>" class="posttitle" href="<?php echo $article[$i]['permalink'] ?>"><?php echo $article[$i]['title'] ?></a></h3>
                    <div><?php echo $article[$i]['excerpt'] ?></div>
                    <p class="here">
                        <span class="icon-letter"><?php echo $article[$i]['strLen'] ?></span>
                        <span class="icon-view"><?php echo $article[$i]['views'] ?></span>
                        <a href="javascript:;" class="likeThis" data-cid="<?php echo $article[$i]['cid'] ?>">
                            <span class="icon-like"></span>
                            <span class="count"><?php echo $article[$i]['likeNum'] ?></span>
                        </a>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php $this->need('component/pagination.php'); ?>
</div>
<div id="preview" class="trans"></div>

<?php $this->need('component/footer.php'); ?>