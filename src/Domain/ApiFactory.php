<?php

namespace JacoBaldrich\BasePlugin\Domain;

interface ApiFactory
{
    public static function create(): Api;
}