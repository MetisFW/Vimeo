<?php

namespace MetisFW\Vimeo\UI;

use MetisFW\Vimeo\InvalidPlayerParameterException;
use MetisFW\Vimeo\Utils\VimeoPlayerUrl;
use Nette\Application\UI\Control;

/**
 * @return VimeoPlayerControl
 */
interface VimeoPlayerControlFactory {

  /**
   * @param $videoId
   * @param array $playerParameters
   * @return VimeoPlayerControl
   */
  function create($videoId, array $playerParameters = array());

}

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
    parent::__construct();
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
   * @param int $width
   * @param int $height
   * @param array $parameters
   */
  public function render($width = 630, $height = 354, $parameters = array()) {
    $template = $this->template;

    $this->setPlayerParameters($parameters);

    $urlParameters = $this->playerParameters;
    unset($urlParameters['player_id']);
    $template->videoUrl = VimeoPlayerUrl::getUrl($this->videoId, $urlParameters);

    $template->playerId = $this->getParameter('player_id');
    $template->playerWidth = $width;
    $template->playerHeight = $height;
    $templateFilePath = ($this->templateFilePath ? $this->templateFilePath : $this->getDefaultTemplateFilePath());
    $template->setFile($templateFilePath);
    $template->render();
  }

  protected function getDefaultTemplateFilePath() {
    return __DIR__.'/templates/VimeoPlayerControl.latte';
  }

}
