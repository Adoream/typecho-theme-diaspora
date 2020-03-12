<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/*
 * @Author: Jin
 * @Date: 2020-03-11 13:09:33
 * @LastEditors: Jin
 * @LastEditTime: 2020-03-12 23:17:56
 * @FilePath: /diaspora/Users/sora/Developer/Theme/Typecho/Diaspora/lib/Diaspora.php
 */
class Diaspora {
    public static $version = "2.0.0";

    public static $options = NULL;
    
    public static function init() {
        if (self::$options != NULL) {
            return;
        }
        self::$options = Diaspora_Settings::instance();
    }

    public static function isPjax () {
        if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
            return true;
        }
        return false;
    }

     public static function isAjax () {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if ('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                return true;
            }
        }
        return false;
    }
    
    public static function welcome () {
        return '<p style="font-size:16px;">'. _t('感谢您使用 Diaspora') . <<<EOF
<style type="text/css">
    textarea {
        -webkit-overflow-scrolling: touch;
    }
    .settings-title {
        font-size: 2em;
        border-bottom: 1px #ddd solid;
        padding-top:1em;
    }
    .typecho-option:first-of-type {
        margin-top: -2em;
    }
    ul.typecho-option.typecho-option-submit {
        position:fixed;
        bottom:0;
        width:100%;
        background: rgba(255, 255, 255, 0.7);
        height:50px;
        margin-bottom:0;
        left:0;
        text-align:center;
    }
    @supports (-webkit-backdrop-filter: brightness(150%) blur(30px)) or (backdrop-filter:blur(20px)) {
        ul.typecho-option.typecho-option-submit {
            background:rgba(117,117,117,.3);
            -webkit-backdrop-filter:blur(20px);
            backdrop-filter:blur(20px);
        }
    }
    ul.typecho-option.typecho-option-submit li {
        padding-top: 9px;
    }
    ul.typecho-option.typecho-option-submit li button {
        width: 300px;
        max-width: 85%;
        border-radius: 3px;
        -webkit-box-shadow: 5px 6px 14px rgba(255,182,193,0.4);
        box-shadow: 5px 6px 14px rgba(255,182,193,0.4);
        -webkit-transition-property: background-color,-webkit-box-shadow;
        transition-property: background-color,-webkit-box-shadow;
        transition-property: box-shadow,background-color;
        transition-property: box-shadow,background-color,-webkit-box-shadow;
        -webkit-transition-duration: .2s;
        transition-duration: .2s;
        background-color: #ffb6c1;
        font-weight: 600;
        padding: 10px 40px;
        line-height: 0;
    }
    ul.typecho-option.typecho-option-submit li button:hover {
        background-color: #ffb6c1;
        -webkit-box-shadow: 4px 6px 24px 0 #ffb6c1;
        box-shadow: 4px 6px 24px 0 #ffb6c1;
        text-decoration: none
    }
</style>
EOF;
    }
}
