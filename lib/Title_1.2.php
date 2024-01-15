<?php

use Typecho\Widget\Helper\Form\Element;
use Typecho\Widget\Helper\Layout;

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * Title.php
 * Author     : Hran
 * Date       : 2016/12/10
 * Version    :
 * Description:
 */
class Title extends Element
{
    public function label(string $value): Element
    {
        if (empty($this->label)) {
            $this->label = new Layout('label', array('class' => 'typecho-label settings-title'));
            $this->container($this->label);
        }

        $this->label->html($value);
        return $this;
    }

    public function input(?string $name = null, ?array $options = null): Layout
    {
        $input = new Layout('p', array());
        $this->container($input);
        $this->inputs[] = $input;
        return $input;
    }

    protected function inputValue($value) {}
}