<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * @Author: Jin
 * @Date: 2020-03-11 13:15:40
 * @LastEditors: Jin
 * @LastEditTime: 2020-03-12 11:16:41
 * @FilePath: /diaspora/lib/Content.php
 */
class Content {
    public static function getPostCover ($cid, $covers = NULL) {
        if (empty($covers)) {
            $imageList = [
                Diaspora_Const::STATIC_URL . '/Background/10.jpg',
                Diaspora_Const::STATIC_URL . '/Background/14.png',
                Diaspora_Const::STATIC_URL . '/Background/18.jpg',
                Diaspora_Const::STATIC_URL . '/Background/19.jpg',
                Diaspora_Const::STATIC_URL . '/Background/25.jpg',
                Diaspora_Const::STATIC_URL . '/Background/27.png',
                Diaspora_Const::STATIC_URL . '/Background/30.jpg',
                Diaspora_Const::STATIC_URL . '/Background/36.jpg',
                Diaspora_Const::STATIC_URL . '/Background/68.png',
                Diaspora_Const::STATIC_URL . '/Background/70.jpg'
            ];
            $image = ($covers) ? mb_split("\n", $covers) : (Diaspora::$options->defaultThumbnails) ? mb_split("\n", Diaspora::$options->defaultThumbnails) : $imageList;
            $cid = intval($cid);
            $index = abs($cid) % count($image);
            $cover = $image[$index];
        }

        return $cover;
    }


    public static function rankPostMusic ($musicList = NULL) {
        if ($musicList == NULL) {
            return '';
        }
        $musicArr = mb_split("\n", $musicList);
        $music = $musicArr[rand(0, count($musicArr) - 1)];
        $music = trim($music);

        return $music;
    }

    public static function substring($string, $length, $append = false) {
        if ( $length <= 0 ) {
            return '';
        }
        
        // 检测原始字符串是否为UTF-8编码
        $is_utf8 = false;
        $str1 = @iconv("UTF-8", "GBK", $string);
        $str2 = @iconv("GBK", "UTF-8", $str1);
        if ( $string == $str2 ) {
            $is_utf8 = true;
            
            // 如果是UTF-8编码，则使用GBK编码的
            $string = $str1;
        }
        
        $newstr = '';
        for ($i = 0; $i < $length; $i ++) {
            $newstr .= ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : $string[$i];
        }
        
        if ( $is_utf8 ) {
            $newstr = @iconv("GBK", "UTF-8", $newstr);
        }
        
        if ($append && $newstr != $string) {
            $newstr .= $append;
        }
        
        return $newstr;
    }

    public static function timeAgo ($agoTime) {  
        $agoTime = (int)$agoTime;  
          
        // 计算出当前日期时间到之前的日期时间的毫秒数，以便进行下一步的计算  
        $time = time() - $agoTime;  
          
        if ($time >= 31104000) { // N年前  
            $num = (int)($time / 31104000);  
            return $num.'年前';  
        }  
        if ($time >= 2592000) { // N月前  
            $num = (int)($time / 2592000);  
            return $num.'月前';  
        }  
        if ($time >= 86400) { // N天前  
            $num = (int)($time / 86400);  
            return $num.'天前';  
        }  
        if ($time >= 3600) { // N小时前  
            $num = (int)($time / 3600);  
            return $num.'小时前';  
        }  
        if ($time > 60) { // N分钟前  
            $num = (int)($time / 60);  
            return $num.'分钟前';  
        }  
        return '1分钟前';  
    }

    public static function cnDate ($date) {
        $arr = ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'];
        return $arr[$date-1];
    }

    public static function postViews ($archive) {
        $db = Typecho_Db::get();
        $cid = $archive->cid;
        if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
            $db->query('ALTER TABLE `'.$db->getPrefix().'contents` ADD `views` INT(10) DEFAULT 0;');
        }
        $exist = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))['views'];
        if ($archive->is('single')) {
            $cookie = Typecho_Cookie::get('contents_views');
            $cookie = $cookie ? explode(',', $cookie) : array();
            if (!in_array($cid, $cookie)) {
                $db->query($db->update('table.contents')
                    ->rows(array('views' => (int)$exist+1))
                    ->where('cid = ?', $cid));
                $exist = (int)$exist+1;
                array_push($cookie, $cid);
                $cookie = implode(',', $cookie);
                Typecho_Cookie::set('contents_views', $cookie);
            }
        }
        return $exist;
    }

    public static function utf8Strlen ($string = null) {
        preg_match_all("/./us", $string, $match);
        return count($match[0]);
    }

    public static function likeNum ($cid) {
        $db = Typecho_Db::get();
        if (!array_key_exists('likes', $db->fetchRow($db->select()->from('table.contents')))) {
            $db->query('ALTER TABLE `'.$db->getPrefix().'contents` ADD `likes` INT(10) DEFAULT 0;');
        }
        $exist = $db->fetchRow($db->select('likes')->from('table.contents')->where('cid = ?', $cid))['likes'];

        return $exist;
    }

    public static function likeUp ($cid) {
        if (empty($cid)) {
            exit(json_encode(['status' => 'error', 'data' => [ 'msg' => '参数错误' ]]));
        }
        $db = Typecho_Db::get();
        $exist = self::likeNum($cid);
        $cookie = Typecho_Cookie::get('contents_likes');
        $cookie = $cookie ? explode(',', $cookie) : array();
        if (!in_array($cid, $cookie)) {
            $db->query($db->update('table.contents')
                ->rows(array('likes' => (int)$exist+1))
                ->where('cid = ?', $cid));
            $exist = (int)$exist+1;
            array_push($cookie, $cid);
            $cookie = implode(',', $cookie);
            Typecho_Cookie::set('contents_likes', $cookie);
        }
        // return $exist;
        exit(json_encode(['status' => 'success', 'data' => [ 'count' => $exist ]]));
    }
}