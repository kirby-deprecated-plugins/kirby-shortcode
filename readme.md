# Kirby Shortcode

![Version](https://img.shields.io/badge/version-0.1-blue.svg) ![License](https://img.shields.io/badge/license-MIT-green.svg) [![Donate](https://img.shields.io/badge/give-donation-yellow.svg)](https://www.paypal.me/DevoneraAB)

*Version 0.1*

Kirby Shortcode is a powerful alternative to [Kirbytags](https://getkirby.com/docs/developer-guide/kirbytext/tags), but it's more similar to [WordPress Shortcode API](https://codex.wordpress.org/Shortcode_API).

All this is possible because of [thunderer/Shortcode](https://github.com/thunderer/Shortcode) library by [Tomasz Kowalczyk](https://github.com/thunderer).

**Example**

```text
[hello]

Some text.

[greetings firstname="Peter" lastname="Parker"]
    [hello] This is a tag inside a tag.
    Kirby *markdown* can be used inside a tag.
    Html can be <strong>used as well</strong>!
    Even Kirbytags like (email: hello@example.com) works.
[/greetings]

Some more text.

[field-data]
```

**[Installation instructions](docs/install.md)**

## 1. Create shortcodes

The most simple ways to create shortcodes is in your `config.php`.

### Example

Below we have 3 shortcodes.

```php
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
```

- All of them have a `name` and a `text`.
- The shortcode will only work if you register it with a name that matches your shortcode.
- The `text` function should return the output text of the shortcode.
- To use parameters you need to include the `$shortcode` variable.
- To use `$field` and `$page`, you also need to include the `$field` variable.

### getParameter and getContent

- The `$shortcode->getParameter('my-param')` will get a parameter from the shortcode.
- The `$shortcode->getContent()` will get the content inside the shortcode, between the start and ending tags.

## 2. Add shortcodes to your content

The examples below will be based on the example above.

### Example 1 - Hello

Add the code below to your content and it will output `Hello world!`.

```text
[hello]
```

### Example 2 - Greetings

This example includes parameters and content. See [getParameter and getContent](#getParameter and getContent) for more info.

```text
[greetings firstname="Peter" lastname="Parker"]
    [hello] That is a tag inside a tag.
    Kirby *markdown* can be used inside a tag.
    Html can be <strong>used as well</strong>!
[/greetings]
```

### Example 3 - Field key

This example will use the second argument `$field` to get the `$field->key` and the page title with `$field->page->title()`.

```text
[field-data]
```

## 3. Add support to templates and snippets

By default, `kt` and `kirbytext` is replaced to also include shortcodes. Out of the box you can just to this:

```php
echo $page->text()->kt();
echo $page->text()->kirbytext();
```

If you prefer to separate them, you can disable the field method and then do this instead:

```php
echo shortcode::parse($page->text());
```

## Options

The following options can be set in your `/site/config/config.php` file:

```php
c::set('plugin.shortcode.field.method', true);
```

### field.method

By default this plugin will override `kt` or `kirbytext` [field methods](https://getkirby.com/docs/developer-guide/objects/fields). They will work just like before but also parse shortcodes created for this plugin.

To disable it, set it to `false`. You can then still use `shortcode::parse($text)` to parse the text that has shortcodes.

## Requirements

- [**Kirby**](https://getkirby.com/) 2.5+

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you find any issues, please [create a new issue](https://github.com/jenstornell/kirby-shortcode/issues/new).

## License

[MIT](https://opensource.org/licenses/MIT)

It is discouraged to use this plugin in any project that promotes racism, sexism, homophobia, animal abuse, violence or any other form of hate speech.

## Donate

If you want to make a donation, you can do that by sending any amount https://www.paypal.me/DevoneraAB

## Credits

- [Jens Törnell](https://github.com/jenstornell)
- [Tomasz Kowalczyk](https://github.com/thunderer)