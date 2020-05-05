<?php

namespace JacoBaldrich\AmazonProducts\Domain;

interface ApiFactory
{
    public static function create(): Api;
}
