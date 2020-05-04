<?php

namespace JacoBaldrich\BasePlugin\Domain;

interface Api
{
    public function ask(Request $request): Response;
}