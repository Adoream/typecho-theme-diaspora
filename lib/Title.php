<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * Title.php
 * Author     : Hran
 * Date       : 2016/12/10
 * Version    :
 * Description:
 */
class Title extends Typecho_Widget_Helper_Form_Element {

    public function label($value)
    {
        /** 创建标题元素 */
        if (empty($this->label)) {
            $this->label = new Typecho_Widget_Helper_Layout('label', array('class' => 'typecho-label settings-title'));
            $this->container($this->label);
        }

        $this->label->html($value);
        return $this;
    }

    public function input($name = NULL, array $options = NULL)
    {
        $input = new Typecho_Widget_Helper_Layout('p', array());
        $this->container($input);
        $this->inputs[] = $input;
        return $input;
    }

    protected function _value($value) {}

}