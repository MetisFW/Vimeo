# MetisFW/Vimeo

## Setup

1) Register extension
```
extensions:
  vimeo: MetisFW\Vimeo\DI\VimeoExtension
```

2) Set up extension parameters

``` neon
vimeo:
  clientId:
  clientSecret:
  accessToken:    # [ OPTIONAL ]
```

## Usage

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
