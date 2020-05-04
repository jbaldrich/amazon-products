<?php declare (strict_types = 1);

namespace JacoBaldrich\BasePlugin\Domain;

use stdClass;

interface View
{
    public function render(stdClass $context): string;
}
