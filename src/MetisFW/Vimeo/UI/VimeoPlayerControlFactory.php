<?php

namespace MetisFW\Vimeo\UI;

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
