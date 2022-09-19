<?php

namespace MetisFW\Vimeo\DI;

use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

class VimeoExtension extends CompilerExtension {

  public function getConfigSchema(): Schema {
    return Expect::structure([
      'clientId' => Expect::string(),
      'clientSecret' => Expect::string(),
      'accessToken' => Expect::string()->required(false)
    ]);
  }

  public function loadConfiguration() {
    $config = $this->getConfig();
    $builder = $this->getContainerBuilder();

    $builder->addDefinition($this->prefix('vimeoFactory'))
      ->setFactory('MetisFW\Vimeo\VimeoFactory');

    $builder->addDefinition($this->prefix('vimeo'))
      ->setFactory('MetisFW\Vimeo\VimeoContext', array((array)$config, $this->prefix('@vimeoFactory')));
  }

}