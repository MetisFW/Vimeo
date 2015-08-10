<?php

namespace MetisFW\Vimeo\DI;

use Nette\DI\CompilerExtension;

class VimeoExtension extends CompilerExtension {

  /**
   * @var array
   */
  private $defaults = [
    'accessToken' => null
  ];

  public function loadConfiguration() {
    $config = $this->getConfig($this->defaults);
    $builder = $this->getContainerBuilder();

    $builder->addDefinition($this->prefix('vimeoFactory'))
      ->setClass('MetisFW\Vimeo\VimeoFactory');

    $builder->addDefinition($this->prefix('vimeo'))
      ->setClass('MetisFW\Vimeo\VimeoContext', array($config, $this->prefix('@vimeoFactory')));
  }

}