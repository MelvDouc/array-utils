<?php

use MelvDouc\ArrayUtils\ArrayUtils;
use PHPUnit\Framework\TestCase;


class ArrayUtilsTest extends TestCase
{
  private const LOTTERY_NUMBERS = [4, 8, 15, 16, 23, 42];

  public function testEvery_true()
  {
    $test = ArrayUtils::every(self::LOTTERY_NUMBERS, fn ($num) => $num <= 42);
    $this->assertTrue($test);
  }

  public function testEvery_false()
  {
    $test = ArrayUtils::every(self::LOTTERY_NUMBERS, fn ($num) => $num % 2 === 0);
    $this->assertFalse($test);
  }

  public function testSome_true()
  {
    function isEven(int $num)
    {
      return $num % 2 === 0;
    }
    $test = ArrayUtils::some(self::LOTTERY_NUMBERS, "isEven");
    $this->assertTrue($test);
  }

  public function testSome_false()
  {
    $test = ArrayUtils::some(self::LOTTERY_NUMBERS, fn ($num) => is_float($num));
    $this->assertFalse($test);
  }

  public function testFind()
  {
    $test = ArrayUtils::find(self::LOTTERY_NUMBERS, fn ($num) => $num > 16);
    $this->assertEquals($test, 23);
  }

  public function testFlattenDepth1()
  {
    $sampleArray = [4, [8, 15, 16], 23, 42];
    $test = ArrayUtils::flatten($sampleArray);
    $this->assertEquals(json_encode($test), json_encode(self::LOTTERY_NUMBERS));
  }

  public function testFlattenDepth2()
  {
    $sampleArray = [4, [8, [15, [16]]], 23, 42];
    $test = ArrayUtils::flatten($sampleArray, 2);
    $this->assertFalse(is_array($test[2]));
    $this->assertTrue(is_array($test[3]));
    $this->assertFalse(is_array($test[4]));
  }

  public function testFlattenDepthInfinity()
  {
    $sampleArray = [4, [8, [15, 16]], [23], 42];
    $test = ArrayUtils::flatten($sampleArray, INF);
    $this->assertEquals(json_encode($test), json_encode(self::LOTTERY_NUMBERS));
  }

  public function testFrom()
  {
    $test = ArrayUtils::from(3, fn ($i) => $i + 1);

    $this->assertEquals(count($test), 3);
    foreach ($test as $i => $num) {
      if ($num !== $i + 1) {
        $this->assertTrue(false);
        return;
      }
    }
    $this->assertTrue(true);
  }

  public function testGroupBy()
  {
    $test = ArrayUtils::groupBy(
      self::LOTTERY_NUMBERS,
      fn ($num) => $num % 2 === 0 ? "even" : "odd"
    );
    $this->assertTrue(array_key_exists("even", $test));
    $this->assertTrue(array_key_exists("odd", $test));
    $this->assertEquals(json_encode($test["even"]), json_encode([4, 8, 16, 42]));
    $this->assertEquals(json_encode($test["odd"]), json_encode([15, 23]));
  }

  public function testBubbleSort()
  {
    $test = ArrayUtils::bubbleSort([...self::LOTTERY_NUMBERS], fn ($a, $b) => $b - $a);
    $this->assertEquals(json_encode($test), json_encode(array_reverse(self::LOTTERY_NUMBERS)));
  }
}
