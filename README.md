# Hylian Shield

The Hylian Shield between your application and input data.

## The Hylian Shield in action

```php
<?php
use \HylianShield\Validator;

// Check if a file exists.
$fileExists = new Validator\File\Exists;
var_dump("{$fileExists}", __FILE__, $fileExists(__FILE__));
// 'file_exists:0,0', README.md, true

// Check if a data type is a string of at least 5 characters and at most 12 characters.
$checkString = new Validator\String(5, 12);
var_dump(
  $checkString('Heya'),
  $checkString(120000),
  $checkString(11),
  $checkString('HylianShield'),
  $checkString('Shield')
);
// false, false, false, true, true

var_dump($checkString->validate('HylianShield'));
// true

var_dump("{$checkString}");
// string:5,12

var_dump($checkString->type());
// string

$url = new Validator\Url;
var_dump($url('https://github.com/johmanx10/hylianshield'));
// true
```

![Hylian Shield](http://fc00.deviantart.net/fs70/f/2011/258/3/9/hylian_shield_vector_by_reptiletc-d49y46o.png)
