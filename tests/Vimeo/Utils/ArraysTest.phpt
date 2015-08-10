<?php

namespace Tests\Vimeo\Utils;

use MetisFW\Vimeo\Utils\Arrays;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__.'/../../bootstrap.php';

class ArraysTest extends TestCase {

  public function testArrayOnly() {
    $array = [
      'a' => 1,
      'b' => 2,
      'c' => 3
    ];

    $keys = [
      'a',
      'c'
    ];

    $result = [
      'a' => 1,
      'c' => 3
    ];

    Assert::equal($result, Arrays::only($array, $keys));
  }

}

run(new ArraysTest());