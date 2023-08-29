<?php

namespace MelvDouc\ArrayUtils;

class ArrayUtils
{
  /**
   * Check if every element in the array returns `true` with the given predicate.
   */
  public static function every(array $arr, callable $predicate): bool
  {
    foreach ($arr as $key => $value)
      if (!$predicate($value, $key, $arr))
        return false;

    return true;
  }

  /**
   * Check if at least one element in the array returns `true` with the given predicate.
   */
  public static function some(array $arr, callable $predicate): bool
  {
    foreach ($arr as $key => $value)
      if ($predicate($value, $key, $arr))
        return true;

    return false;
  }

  /**
   * Find the first element in the array that returns `true` with the given predicate
   * or `null` if nothing was found.
   */
  public static function find(array $arr, callable $predicate): mixed
  {
    foreach ($arr as $key => $value)
      if ($predicate($value, $key, $arr))
        return $value;

    return null;
  }

  /**
   * Spread nested arrays.
   * @param array $arr A multidimensional array.
   * @param int $depth 1 means the array elements within the array argument, 2 the doubly nested elements, etc. `INF` can be used to flatten the array completely.
   */
  public static function flatten(array $arr, $depth = 1): array
  {
    return array_reduce(
      $arr,
      function ($acc, $element) use ($depth) {
        is_array($element) && $depth >= 1
          ? array_push($acc, ...static::flatten($element, $depth - 1))
          : array_push($acc, $element);
        return $acc;
      },
      []
    );
  }

  /**
   * Create an array of the given length
   * wherein each element is the return value of `$callbackFn` with the current index as an argument.
   */
  public static function from(int $length, callable $callbackFn)
  {
    $arr = [];

    for ($i = 0; $i < $length; $i++)
      $arr[] = $callbackFn($i);

    return $arr;
  }

  /**
   * Group elements into an associative array of arrays.
   * @param array $arr An associative array is allowed.
   * @param callable $callbackFn A function which takes in the current element, current key and the array argument,
   * and returns a string or integer to use as a key in the returned array.
   * @return array An associative array.
   */
  public static function groupBy(array $arr, callable $callbackFn): array
  {
    $groups = [];

    foreach ($arr as $key => $element) {
      $k = $callbackFn($element, $key, $arr);
      $groups[$k] ??= [];
      $groups[$k][] = $element;
    }

    return $groups;
  }

  public static function bubbleSort(array $arr, callable $sortFn)
  {
    for ($i = 0; $i < count($arr) - 1; $i++) {
      for ($j = $i + 1; $j < count($arr); $j++) {
        if ($sortFn($arr[$i], $arr[$j]) <= 0)
          continue;
        $temp = $arr[$i];
        $arr[$i] = $arr[$j];
        $arr[$j] = $temp;
      }
    }

    return $arr;
  }
}
