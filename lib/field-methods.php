<?php
if(c::get('plugin.shortcode.field.method', true)) {
    field::$methods['kirbytext'] = field::$methods['kt'] = function($field) {
        $field->value = shortcode::parse($field);
        return $field;
    };
}