# doctrine-type-tinyint

Doctrine custom type for MySQL tinyint. Support length.

## Usage

for symfony
```yaml:config/packages/doctrine.yaml
doctrine:
  dbal:
    types:
      tinyint: Kalibora\DoctrineType\TinyintType
```

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class Foo
{
    /**
     * @ORM\Column(type="tinyint", length=3)
     */
    private $status;
}
```
