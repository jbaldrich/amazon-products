<?php declare (strict_types = 1);

namespace JacoBaldrich\AmazonProducts\Domain;

use stdClass;

interface View
{
    public function render(stdClass $context): string;
}
