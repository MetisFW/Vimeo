<?php

namespace MetisFW\Vimeo\Utils;

class VimeoPlayerUrl {

  /**
   * Generate link of Vimeo video.
   *
   * @param $videoId
   * @param array $parameters
   * @return string
   */
  public static function getUrl($videoId, array $parameters) {
    $url = 'https://player.vimeo.com/video/' . $videoId . '?';

    foreach($parameters as $key => $value) {
      $url .= '&'.$key.'='.$value;
    }
    return $url;
  }

}