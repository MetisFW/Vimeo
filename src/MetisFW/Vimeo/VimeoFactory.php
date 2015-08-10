<?php

namespace MetisFW\Vimeo;

use MetisFW\Vimeo\Utils\Arrays;
use Vimeo\Vimeo;

class VimeoFactory {

  /**
   * @var array
   */
  private $requiredConfig = [
    'clientId',
    'clientSecret'
  ];

  /**
   * @var array
   */
  private $optionalConfig = [
    'accessToken'
  ];

  /**
   * Make a new Vimeo client.
   *
   * @param array $config
   *
   * @return \Vimeo\Vimeo
   */
  public function create(array $config) {
    $config = $this->checkConfig($config);
    return $this->createClient($config);
  }

  /**
   * Get the configuration data.
   *
   * @param array $config
   *
   * @throws InvalidArgumentException
   *
   * @return array
   */
  private function checkConfig(array $config) {
    foreach($this->requiredConfig as $key) {
      if(!array_key_exists($key, $config)) {
        throw new InvalidArgumentException("Required key '$key' is missing in configuration.");
      }
    }
    return Arrays::only($config, array_merge($this->requiredConfig, $this->optionalConfig));
  }

  /**
   * Get the Vimeo client.
   *
   * @param array $auth
   *
   * @return \Vimeo\Vimeo
   */
  private function createClient(array $auth) {
    return new Vimeo(
      $auth['clientId'],
      $auth['clientSecret'],
      $auth['accessToken']
    );
  }

}