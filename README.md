# WP Routing
> Symfony style routing for WordPress.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f1144050-315f-4c30-a142-c571d42a0334/mini.png)](https://insight.sensiolabs.com/projects/f1144050-315f-4c30-a142-c571d42a0334)
[![Build Status](https://travis-ci.org/LIN3S/WPRouting.svg?branch=master)](https://travis-ci.org/LIN3S/WPRouting)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LIN3S/WPRouting/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LIN3S/WPRouting/?branch=master)
[![Total Downloads](https://poser.pugx.org/lin3s/wp-routing/downloads)](https://packagist.org/packages/lin3s/wp-routing)
&nbsp;&nbsp;&nbsp;&nbsp;
[![Latest Stable Version](https://poser.pugx.org/lin3s/wp-routing/v/stable.svg)](https://packagist.org/packages/lin3s/wp-routing)
[![Latest Unstable Version](https://poser.pugx.org/lin3s/wp-routing/v/unstable.svg)](https://packagist.org/packages/lin3s/wp-routing)

## Why?
WordPress routing system is a magical awesome but dark system. For non developers this routing just "works" but,
when you need to customize it, this process is not very intuitive. In [LIN3S][1], we are proud PHP developers that like
[Symfony][2] ecosystem so, this library is a simple but powerful approach to **Symfony Routing component** you can 
easily add to your WordPress project.

If you want to test it, we already have a functional WordPress project that includes this library ready to use,
[WordPress Standard Edition][3] :).

## Installation
The recommended and the most suitable way to install this library is through [Composer][4]. Be sure that the tool is
installed in your system and execute the following command:
```
$ composer require lin3s/wp-routing
```

## Usage
Before you start using this library we highly recommend getting familiar with [WordPress template hierarchy][5].

WP-Routing uses [YAML][6] to match routes with your methods. For example you can write the following in your 
`routing.yml`:

```yaml
-
  controller: YourTheme\Controller\DefaultController::indexAction
  type: front

-
  controller: WordpressStandard\Controller\DefaultController::notFoundAction
  type: 404

-
  controller: YourTheme\Controller\EventController::searchAction
  type: search

-
  controller: YourTheme\Controller\YourPostTypeController::singleAction
  type: single
  posttype: your-posttype

-
  controller: YourTheme\Controller\PageController::availabilityAction
  type: page
  template: your-template
```

As you can see in the example above you can use the following parameters for each route:

* `controller`: Defines with method will be called when a match for the given route exists.
* `type`: Which type of route will match the current controller. It uses WordPress standard naming conventions and you can
check the available ones in [Router][7] class.
* `template`: Can be used in pages to select a custom template. Internally it uses `get_page_template_slug()` to get the
template the page requires. We use our [*template-selector*][9] plugin to let the user select the template to be used.
* other parameters: In case you need to target a specific category, post type (archive or single), taxonomy or page you
can use extra parameters like slug, id or posttype (see variable names on [WordPress's template hierarchy][5] page).

To resolve the routes added above just include the following code in your theme's `index.php`:

```php
(new \LIN3S\WPRouting\Router())->resolve();
```

> Make sure WPRouting library is autoloaded using [composer's autoload script][8]

## To Do
- [ ] Add more specs
- [ ] Route registration wih XML
- [ ] Route registration wih annotations

## Licensing Options
[![License](https://poser.pugx.org/lin3s/wp-routing/license.svg)](https://github.com/LIN3S/WPRouting/blob/master/LICENSE)

[1]: http://lin3s.com
[2]: https://symfony.com/
[3]: https://github.com/LIN3S/WordpressStandard
[4]: https://getcomposer.org/
[5]: https://wphierarchy.com/
[6]: http://yaml.org/
[7]: https://github.com/LIN3S/WPRouting/blob/master/src/Router.php
[8]: https://getcomposer.org/doc/01-basic-usage.md#autoloading
[9]: https://github.com/LIN3S/WPTemplateSelector
