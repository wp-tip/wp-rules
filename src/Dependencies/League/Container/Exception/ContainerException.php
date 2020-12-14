<?php

namespace WP_Rules\Dependencies\League\Container\Exception;

use WP_Rules\Dependencies\Psr\Container\ContainerExceptionInterface;
use RuntimeException;

class ContainerException extends RuntimeException implements ContainerExceptionInterface
{
}
