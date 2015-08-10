<?php

namespace MetisFW\Vimeo\Utils;

class Arrays {

  /**
   * Get a subset of the items from the given array.
   *
   * @param  array  $array
   * @param  array|string  $keys
   * @return array
   */
  public static function only($array, $keys) {
    return array_intersect_key($array, array_flip((array) $keys));
  }

}