# PhEnum

An enum implementation in PHP (with namespace support)

## Example

Declare an enum:

```php
<?php
require 'path/to/PhEnum/Enum.php';

// Note: You have to escape the namespace delimiters
PhEnum\define('Things\\To\\Do', array('Think', 'Code'));

?>
```

Then use it:

```php
<?php
namespace Things\To;

require 'your/path/Do.php';

$activity = Do::Think();
$another = Do::Code();

var_dump($activity === Do::Think());	// bool(true)
var_dump($another !== Do::Code());		// bool(false)

var_dump(Do::Think()->name());			// string(5) "Think"
var_dump(Do::Code()->ordinal());		// int(1)

// Save the ordinal number
$ord = $another->ordinal();

// And look it up afterwards
$todo = Do($ord);
var_dump($todo === Do::Code());			// bool(true)

?>
```