# PhEnum

An enum implementation in PHP (with namespace support)

## Example

Declare an enum:

```php
<?php
require 'path/to/PhEnum/Enum.php';

// Note: You have to escape the namespace delimiters
PhEnum::define('Things\\To\\Do', array('Think', 'Code'));

?>
```

Then use your enum

```php
<?php
namespace Things\To;

require 'your/path/Do.php';

$activity = Do::Think();
$another = Do::Code();

var_dump($activity === Do::Think());	// bool(true)
var_dump($another !== Do::Code());		// bool(false)

var_dump($activity->name());			// string(5) "Think"
var_dump($another->ordinal());			// int(1)

// Save the ordinal
$i = Do::Code()->ordinal();

// And look it up afterwards
$todo = Do($i);

?>
```