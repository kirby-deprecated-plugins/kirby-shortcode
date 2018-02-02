# Kirby Shortcode

![Version](https://img.shields.io/badge/version-0.2-blue.svg) ![License](https://img.shields.io/badge/license-MIT-green.svg) [![Donate](https://img.shields.io/badge/give-donation-yellow.svg)](https://www.paypal.me/DevoneraAB)

Kirby Shortcode is a powerful alternative to [kirbytags](https://getkirby.com/docs/developer-guide/kirbytext/tags), but it's more similar to [WordPress Shortcode API](https://codex.wordpress.org/Shortcode_API).

*This plugin is based on the great [thunderer/Shortcode](https://github.com/thunderer/Shortcode) library by [Tomasz Kowalczyk](https://github.com/thunderer).*

|                    | Kirbytags | Shortcode
| ------------------ | --------- | ---------
| Self closing       | Yes       | Yes
| Closing            | -         | Yes
| Nesting            | -         | Yes
| Any HTML           | -         | Yes
| Access to `$field` | Yes       | Yes
| Access to `$page`  | Yes       | Yes

Kirbytags, markdown and HTML still works like before, even inside shortcodes.

**Example content text**

```text
[hello]

Some text.

[greetings firstname="Peter" lastname="Parker"]
    [hello] This is a tag inside a tag.
    Kirby *markdown* can be used inside a tag.
    Html can be <strong>used as well</strong>!
    Even kirbytags like (email: hello@example.com) works.
[/greetings]

Some more text.

[field-data]
```

**[Installation instructions](docs/install.md)**

## Table of contents

- [1. Create shortcodes](#1-create-shortcodes)
- [2. Shortcodes in content](#2-shortcodes-in-content)
- [3. Templates and snippets](#3-templates-and-snippets)
- [Options](#options)
- [Changelog](docs/changelog.md)
- [Requirements](#requirements)
- [Disclaimer](#disclaimer)
- [License](#license)
- [Donate](#donate)
- [Credits](#credits)

## 1. Create shortcodes

The most simple ways to create shortcodes is in your `config.php`.

### Example

Below we have shortcodes.

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

- The shortcode will only work when the registered `name` matches your shortcode name inside your content text.
- The `text` function returns the output text of the shortcode.
- To use parameters you need to include the `$shortcode` variable.
- To use the `$field` and the page object, you also need to include the `$field` variable.

### getParameter and getContent

- The `$shortcode->getParameter('my-param')` method allow returns a parameter from the shortcode.
- The `$shortcode->getContent()` method returns the content inside the shortcode, between the start and ending tags.

## 2. Shortcodes in content

The examples below are based on the example above.

### Example 1 - Hello

Add the code below to your content. It will output `Hello world!`.

```text
[hello]
```

### Example 2 - Greetings

This example includes parameters and content. See [getParameter and getContent](#getparameter-and-getcontent).

As you can see in the example, you can use nested shortcodes, markdown and even kirbytags in your shortcode content.

```text
[greetings firstname="Peter" lastname="Parker"]
    [hello] This is a tag inside a tag.
    Kirby *markdown* can be used inside a tag.
    Html can be <strong>used as well</strong>!
    Even kirbytags like (email: hello@example.com) works.
[/greetings]
```

### Example 3 - Field key

This example will use the second argument `$field`. Then `$field->key` can be used as well as `$field->page->title()`. They output the field key and the page title.

```text
[field-data]
```

## 3. Templates and snippets

By default, [kt](https://getkirby.com/docs/cheatsheet/field-methods/kt) and [kirbytext](https://getkirby.com/docs/cheatsheet/field-methods/kirbytext) are overwritten by this plugin to support shortcodes.

**Out of the box you can do one of the following:**

```php
echo $page->text()->kt();
echo $page->text()->kirbytext();
```

If you prefer to keep `kt` and `kirbytext` untouched, you can disable the [field method](#fieldmethod).

**Instead you can use this method:**

```php
echo shortcode::parse($page->text());
```

## Options

The following options can be set in your `/site/config/config.php` file:

```php
c::set('plugin.shortcode.create', array());
c::set('plugin.shortcode.field.method', true);
```

### create

With this option you add your shortcodes. You can read more about that in the chapter [Create shortcodes](#1-create-shortcodes).

### field.method

By default this plugin will override `kt` or `kirbytext` [field methods](https://getkirby.com/docs/developer-guide/objects/fields). These field methods will work just like before, but also parse shortcodes.

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