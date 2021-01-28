<?php

namespace MetisFW\Vimeo;

use Nette\SmartObject;

class VimeoContext {

  use SmartObject;

  /**
   * @var array
   */
  private $config;

  /**
   * @var VimeoFactory
   */
  private $factory;

  /**
   * @param array $config
   * @param VimeoFactory $factory
   */
  public function __construct(array $config, VimeoFactory $factory) {
    $this->config = $config;
    $this->factory = $factory;
  }

  public function getFactory() {
    return $this->factory;
  }

  /**
   * Create the connection instance.
   *
   * @param array $config
   *
   * @return \Vimeo\Vimeo
   */
  public function createConnection(array $config = null) {
    if($config) {
      return $this->factory->create($config);
    }
    return $this->factory->create($this->config);
  }

}
