# Automática
Automática is a PSR-4 compliant autoloader.

## Usage

In your `index.php` or bootstrap file, create a new instance of `Autoloader` and
call the `register()` method.

```php
<?php declare(strict_types=1);

use TotallyQuiche\Automatica\Autoloader;

require_once('Autoloader.php');

(new Autoloader)->register();
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