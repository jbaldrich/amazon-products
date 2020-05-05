<?php declare (strict_types = 1);

namespace JacoBaldrich\AmazonProducts\Domain;

interface ViewFactory
{
    public function create(Path $path): View;
}
