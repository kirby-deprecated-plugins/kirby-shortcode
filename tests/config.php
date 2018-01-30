<?php
c::set('plugin.shortcode.create', [
    [
        'name' => 'hello',
        'text' => function() {
            return 'Hello world!';
        }
    ],
    [
        'name' => 'greetings',
        'text' => function($shortcode) {
            return sprintf(
                '**Greetings** %s %s!<br>%s',
                $shortcode->getParameter('firstname'),
                $shortcode->getParameter('lastname'),
                $shortcode->getContent()
            );
        }
    ],
    [
        'name' => 'field-data',
        'text' => function($shortcode, $field) {
            return sprintf(
                '**Field key:** %s
                **Page title:** %s',
                $field->key,
                $field->page->title()
            );
        }
    ]
]);