# Array Utils

Some JavaScript-inspired array utility functions for my personal use.

## Examples

### bubbleSort

```php
$lotteryNumbers = [15, 4, 16, 42, 23, 8];
ArrayUtils::bubbleSort($lotteryNumbers, function (int $a, int $b) {
  return $a - $b;
}); // [ 4, 8, 15, 16, 23, 42 ]
```

### every & some

```php
$numbers = [1, 2, 3];

function isEven(int $n)
{
  return $n % 2 === 0;
}

ArrayUtils::every($numbers, "isEven"); // false
ArrayUtils::some($numbers, "isEven"); // true
```

### find

```php
$firstEvenNumber = ArrayUtils::find($numbers, "isEven"); // 2
```

### flatten

```php
ArrayUtils::flatten([1, [2, [3], 4]]);
// ↪ [ 1, 2, [ 3 ], 4 ]
ArrayUtils::flatten([1, [2, [3], 4]], INF);
// ↪ [ 1, 2, 3, 4 ]
```

### from

```php
$squareNumbers = ArrayUtils::from(3, fn ($i) => ($i + 1) ** 2);
// ↪ [ 1, 4, 9 ]
```

### groupBy

```php
$numbersByParity = ArrayUtils::groupBy($numbers, function (int $n) {
  return ($n % 2 === 0) ? "even" : "odd";
});
// ↪ [ "odd" => [ 1, 3 ], "even" => [ 2 ] ]
```
