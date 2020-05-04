<?php declare (strict_types = 1);

namespace JacoBaldrich\BasePlugin\Domain;

interface ViewFactory
{
    public function create(Path $path): View;
}
