# PhEnum

An enum implementation in PHP (with namespace support)

## Example

Declare an enum:

```php
<?php
require 'Enum.php';

// Note: You have to escape the namespace delimiters
Luegg\PhEnum\define(
		'yourCompany\\awesomeApp\\Season',
		array('Spring', 'Summer', 'Fall', 'Winter')
	);

?>
```

Then use it:

```php
<?php
use yourCompany\awesomeApp\Season;

require 'exampleDeclaration.php';

$when = Season::Fall();
$before = Season::Summer();

var_dump($when === Season::Fall());		// bool(true)
var_dump($before === Season::Winter()); // bool(false)

var_dump(Season::Spring()->name());		// string(6) "Spring"
var_dump(Season::Winter()->ordinal());	// int(3)

// Save the ordinal
$ord = $before->ordinal();

// Some DB interaction

// And look it up afterwards
$after = Season::lookup($ord);
var_dump(Season::Summer() == $after);	// bool(true)

?>
```