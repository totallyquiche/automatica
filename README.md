# Automática
Automática is a PSR-4 compliant autoloader.

## Usage

Load `Autoloader.php`, create a new instance of `Autoloader`, and call the `register()`
method.

```php
require_once('Autoloader.php');

(new TotallyQuiche\Automatica\Autoloader)->register();
```

You can provide a mapping of vendor namespace prefixes to the corresponding file
paths relative to Automática's base directory.

```php
// Look for Vendor\Namespace\Prefix class files in ./Library/

$autoloader = new Autoloader(
    ['Vendor\Namespace\Prefix' => 'Library']
);

$autoloader->register();
```

The base directory is location of `Autoloader.php` by default, but this can also
be changed.

```php
// Look for Vendor\Namespace\Prefix class files in ./vendor/Library/

$autoloader = new Autoloader(
    ['Vendor\Namespace\Prefix' => 'Library'],
    './vendor/'
);

$autoloader->register();
```

## Example

Filesystem:

```
./index.php
./Autoloader.php
./Vendor/
     Utility.php
```
`Utility.php`

```php
<?php declare(strict_types=1);

namespace Some\Vendor;

final class Utility
{
    //
}
```

`index.php`:

```php
<?php declare(strict_types=1);

require_once('Autoloader.php');

(new TotallyQuiche\Automatica\Autoloader(
    ['Some\Vendor' => 'Vendor']
))->register();

new Some\Vendor\Utility;
```