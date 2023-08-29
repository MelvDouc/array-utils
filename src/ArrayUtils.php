<?php

namespace MelvDouc\ArrayUtils;

class ArrayUtils
{
  /**
   * Check if every element in the array match a given condition.
   * @param array $arr The input array.
   * @param callable $predicate Whether a given element matches a condition.
   */
  public static function every(array $arr, callable $predicate): bool
  {
    foreach ($arr as $key => $value)
      if (!$predicate($value, $key, $arr))
        return false;

    return true;
  }

  /**
   * Check if at least one element in the array matches a given condition.
   * @param array $arr The input array.
   * @param callable $predicate Whether a given element matches a condition.
   */
  public static function some(array $arr, callable $predicate): bool
  {
    foreach ($arr as $key => $value)
      if ($predicate($value, $key, $arr))
        return true;

    return false;
  }

  /**
   * Find an element in an array.
   * @param array $arr The input array.
   * @param callable $predicate Whether a given element matches the search.
   * @return mixed The searched element or `null` if nothing was found.
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
   * @param int $depth 1 means the array elements within the array argument, 2 the doubly nested elements, etc.
   * `INF` can be used to flatten the array completely.
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
   * Create an array of the given length and fill it with a callback function.
   * @param int $length The desired length.
   * @param callable $callbackFn A function that returns the value of the array at a given index.
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
   * @param callable $callbackFn A function which takes in the current element, current key and the input array,
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

  /**
   * Sort an array in place using the bubble sort algorithm.
   * @param array $arr The input array.
   * @param callable $sortFn A function that takes in two arguments representing two elements in the array.
   * It should return a positive number when the elements are to be swapped.
   * @return array
   */
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
