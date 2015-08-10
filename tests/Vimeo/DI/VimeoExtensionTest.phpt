<?php

namespace Tests\Vimeo\DI;

use MetisFW\Vimeo\VimeoContext;
use Nette\ComponentModel\Container;
use Nette\Configurator;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__.'/../../bootstrap.php';

class VimeoExtensionTest extends TestCase {

  /** @var VimeoContext */
  private $vimeoContext;

  /** @var Container */
  private $container;

  /** @var array */
  private $testConfig = [
    'clientId' => 'a',
    'clientSecret' => 'b',
    'accessToken' => 'c'
  ];

  public function setUp() {
    $this->container = $this->generateContainer();
    $this->vimeoContext = $this->container->getService('vimeo.vimeo');
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

  public function testExtensionCreated() {
    Assert::notEqual(null, $this->vimeoContext);
  }

  public function testServiceType() {
    Assert::type('MetisFW\Vimeo\VimeoContext', $this->vimeoContext);
  }

  public function testGetConnection() {
    Assert::type('Vimeo\Vimeo', $this->vimeoContext->createConnection());
  }

}

\run(new VimeoExtensionTest());
