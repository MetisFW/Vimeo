<?php

namespace Tests\Vimeo\Utils;

use MetisFW\Vimeo\Utils\VimeoPlayerUrl;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__.'/../../bootstrap.php';

class VimeoPlayerUrlTest extends TestCase {

  /** @var int */
  private $videoId = 1;

  /** @var array */
  private $parameters = array(
    'autopause' => 1,
    'autoplay' => 0,
    'badge' => 1,
    'byline' => 1,
    'color' => '00adef',
    'loop' => 0,
    'player_id' => 'vimeoPlayer1',
    'portrait' => 1,
    'title' => 1
  );

  public function testGenerateVideoLink() {
    $link = 'https://player.vimeo.com/video/1?&autopause=1&autoplay=0&badge=1&byline=1&color=00adef&loop=0&player_id=vimeoPlayer1&portrait=1&title=1';

    Assert::equal($link, VimeoPlayerUrl::getUrl($this->videoId, $this->parameters));
  }

}

run(new VimeoPlayerUrlTest());