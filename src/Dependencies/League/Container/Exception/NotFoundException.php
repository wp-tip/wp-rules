<?php

namespace WP_Rules\Dependencies\League\Container\Exception;

use WP_Rules\Dependencies\Psr\Container\NotFoundExceptionInterface;
use InvalidArgumentException;

class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}
