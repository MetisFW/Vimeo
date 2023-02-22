<?php

namespace MetisFW\Vimeo\UI;

use MetisFW\Vimeo\InvalidPlayerParameterException;
use MetisFW\Vimeo\Utils\VimeoPlayerUrl;
use Nette\Application\UI\Control;

class VimeoPlayerControl extends Control {

  /**
   * @var string
   */
  private $templateFilePath;

  /**
   * @var int Id of current video https://player.vimeo.com/video/{$videoId}
   */
  private $videoId;

  /**
   * @var array Parameters that can be used with the Universal Player https://developer.vimeo.com/player/embedding
   */
  private $playerParameters = array(
    'autopause' => 1,
    'autoplay' => 0,
    'badge' => 1,
    'byline' => 1,
    'color' => '00adef',
    'loop' => 0,
    'player_id' => null,
    'portrait' => 1,
    'title' => 1
  );

  /**
   * @param int $videoId
   * @param array $playerParameters
   */
  public function __construct($videoId, array $playerParameters = array()) {
    $this->videoId = $videoId;

    if(!empty($playerParameters)) {
      $this->setPlayerParameters($playerParameters);
    }
  }

  /**
   * @param array $parameters
   * @throws InvalidPlayerParameterException
   */
  public function setPlayerParameters(array $parameters) {
    foreach($parameters as $key => $value) {
      if(!array_key_exists($key, $this->playerParameters)) {
        throw new InvalidPlayerParameterException("Key '$key' is not name of configurable Universal Player parameter.");
      }
      $this->playerParameters[$key] = $value;
    }
  }

  public function getPlayerParameters() {
    return $this->playerParameters;
  }

  /**
   * @param $name
   * @param $value
   * @throws InvalidPlayerParameterException
   */
  public function setPlayerParameter($name, $value) {
    if(!array_key_exists($name, $this->playerParameters)) {
      throw new InvalidPlayerParameterException("Key '$name' is not name of configurable Universal Player parameter.");
    }
    $this->playerParameters[$name] = $value;
  }

  /**
   * @param $name
   * @return mixed
   * @throws InvalidPlayerParameterException
   */
  public function getPlayerParameter($name) {
    if(!array_key_exists($name, $this->playerParameters)) {
      throw new InvalidPlayerParameterException("Key '$name' is not name of configurable Universal Player parameter.");
    }
    return $this->playerParameters[$name];
  }

  /**
   * @param $videoId
   */
  public function setVideoId($videoId) {
    $this->videoId = $videoId;
  }

  public function getVideoId() {
    return $this->videoId;
  }

  /**
   * @param $templateFilePath
   */
  public function setTemplateFilePath($templateFilePath) {
    $this->templateFilePath = $templateFilePath;
  }

  /**
   * @param int|string $width
   * @param int|string $height
   * @param array $parameters
   */
  public function render($width = 630, $height = 354, array $parameters = array()) {
    $template = $this->template;

    $urlParameters = $this->getMergedParameters($parameters);
    unset($urlParameters['player_id']);
    $template->videoUrl = $this->getUrl($urlParameters);

    $template->playerId = $this->getPlayerParameter('player_id');
    $template->playerWidth = $width;
    $template->playerHeight = $height;
    if($this->templateFilePath) {
      /** @phpstan-latte-ignore */
      $template->setFile($this->templateFilePath);
    } else {
      $template->setFile($this->getDefaultTemplateFilePath());
    }
    $template->render();
  }

  protected function getDefaultTemplateFilePath() {
    return __DIR__.'/templates/VimeoPlayerControl.latte';
  }

  /**
   * @param array $parameters
   * @return array
   */
  protected function getMergedParameters(array $parameters) {
    $result = $this->playerParameters;
    foreach($parameters as $key => $value) {
      if(!isset($this->playerParameters[$key]) && !array_key_exists($key, $this->playerParameters)) {
        throw new InvalidPlayerParameterException("Key '$key' is not name of configurable Universal Player parameter.");
      }
      $result[$key] = $value;
    }
    return $result;
  }

  /**
   * @param array $requestParameters
   * @return string
   */
  public function getUrl(array $requestParameters) {
    return VimeoPlayerUrl::getUrl($this->videoId, $requestParameters);
  }

}
