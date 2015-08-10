MetisFW/Vimeo
=============

[![Build Status](https://travis-ci.org/MetisFW/Vimeo.svg?branch=master)](https://travis-ci.org/MetisFW/Vimeo)
[![Downloads this Month](https://img.shields.io/packagist/dm/metisfw/vimeo.svg)](https://packagist.org/packages/metisfw/vimeo)
[![Latest stable](https://img.shields.io/packagist/v/metisfw/vimeo.svg)](https://packagist.org/packages/metisfw/vimeo)

This package gives you an easy way to handle [Vimeo](https://developer.vimeo.com/apps) configuration keys like client identifier and secret.

Requirements
------------

MetisFW/Vimeo requires PHP 5.3.0 or higher with curl, json extensions.

- [Nette Framework](https://github.com/nette/nette)

Installation
------------
1) The best way to install MetisFW/Vimeo is using [Composer](http://getcomposer.org/):

```sh
$ composer require metisfw/vimeo
```

2) Register extension
```
extensions:
  vimeo: MetisFW\Vimeo\DI\VimeoExtension
```

3) Set up extension parameters

``` neon
vimeo:
  clientId:
  clientSecret:
  accessToken:    # [ OPTIONAL ]
```

Usage
------------
##### Sample usage of `VimeoContext`

```php
use Nette\Application\UI\Presenter;
use MetisWF\Vimeo\VimeoContext;

class MyPresenter extends Presenter {

  /** @var VimeoContext @inject */
  public $vimeo;

  public function foo() {
    // you obtain instance of `/Vimeo/Vimeo` so you can call all methods though API
    try {
      $connection = $this->vimeo->createConnection();
      ...
    } catch(\Exception $exception) {
      ...
    }
  }
}
```

##### Sample usage of `VimeoPlayerControl`

###### In Presenter

```php
use MetisFW\Vimeo\UI\VimeoPlayerControl;
use Nette\Application\UI\Presenter;

class MyPresenter extends Presenter {

  public function createComponentVimeoPlayerControl(VimeoPlayerControlFactory $factory) {
    $control = $factory->create(666555);
    // autowired is possible but you have to register service - MetisFW\Vimeo\UI\VimeoPlayerControlFactory or
    $control = new VimeoPlayerControl(666555);

    // set different template if u want
    $control->setTemplateFilePath(__DIR__ . './myVimeoPlayerTemplate.latte');

    return $control;
  }
}
```

###### In latte
```latte
{control vimeoPlayerControl}
```

## Documentation
There are other classes in this package that are not documented here. This is because the package is a Nette wrapper of [the official Vimeo package](https://github.com/vimeo/vimeo.php).
