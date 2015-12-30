# Colorium Array Dot Notation

Using an instance :

```php
use Colorium\Tools\ArrayDot;

$array = new ArrayDot([
    'foo' => [
        'bar' => 'baz'
    ]
]);

echo $array['foo.bar']; // 'baz'
```

Using static methods :

```php
use Colorium\Tools\ArrayDot;

$array = [
    'foo' => [
        'bar' => 'baz'
    ]
]

echo ArrayDot::get($array, 'foo.bar'); // 'baz'
```