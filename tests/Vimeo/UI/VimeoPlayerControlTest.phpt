<?php

namespace Tests\Vimeo\UI;

use MetisFW\Vimeo\UI\VimeoPlayerControl;
use Nette\Configurator;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__.'/../../bootstrap.php';

class VimeoPlayerControlTest extends TestCase {

  /** @var int */
  private $videoId = 42;

  /** @var VimeoPlayerControl */
  private $videoPlayerControl;

  /** @var array */
  private $testParameters = array(
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

  /** @var Container */
  private $container;

  public function setUp() {
    $this->videoPlayerControl = new VimeoPlayerControl($this->videoId);
    $this->container = $this->generateContainer();
  }

  public function generateContainer() {
    $configurator = new Configurator();
    $configurator->setTempDirectory(TEMP_DIR);
    $configurator->addParameters(array('container' => array('class' => 'SystemContainer_'.md5(TEMP_DIR))));
    $configurator->addConfig(__DIR__.'/../../config.neon');
    $configurator->createRobotLoader()
      ->addDirectory(__DIR__ . '/../../../src')
      ->register();
    $container = $configurator->createContainer();
    return $container;
  }

  public function testSetParameters() {
    $this->videoPlayerControl->setPlayerParameters($this->testParameters);

    Assert::equal($this->testParameters, $this->videoPlayerControl->getPlayerParameters());
  }

  public function testSetParameter() {
    $newBadgeValue = 0;

    $this->videoPlayerControl->setPlayerParameters($this->testParameters);
    $this->videoPlayerControl->setPlayerParameter('badge', $newBadgeValue);

    Assert::notEqual($this->testParameters, $this->videoPlayerControl->getPlayerParameters());
    Assert::equal($newBadgeValue, $this->videoPlayerControl->getPlayerParameter('badge'));
  }

  /**
   * @throws \MetisFW\Vimeo\InvalidPlayerParameterException
   */
  public function testSetWrongParameter() {
    $this->videoPlayerControl->setPlayerParameter('doestNotExist', 1);
  }

  /**
   * @throws \MetisFW\Vimeo\InvalidPlayerParameterException
   */
  public function testGetWrongParameter() {
    $this->videoPlayerControl->getPlayerParameter('doestNotExist');
  }

  /**
   * @throws \MetisFW\Vimeo\InvalidPlayerParameterException
   */
  public function testSetWrongParameters() {
    $wrongParameters = array(
      'foo',
      'bar'
    );

    $this->videoPlayerControl->setPlayerParameters($wrongParameters);
  }

}

run(new VimeoPlayerControlTest());

