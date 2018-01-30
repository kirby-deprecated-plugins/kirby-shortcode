<?php
use Thunder\Shortcode\ShortcodeFacade;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class shortcode {
    public static function parse($field) {
        $facade = new ShortcodeFacade();
        $data = c::get('plugin.shortcode.create');
        $text = (string)$field;

        foreach($data as $item) {
            $key = $item['name'];
            $callback = $item['text'];

            if(is_callable($callback)) {
                $facade->addHandler($key, function(ShortcodeInterface $shortcode) use ($callback, $field) {
                    return call_user_func_array($callback, [$shortcode, $field]);
                });
            }
        }

        return kirbytext($facade->process($text));
    }
}