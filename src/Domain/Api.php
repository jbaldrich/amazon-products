<?php

namespace JacoBaldrich\AmazonProducts\Domain;

interface Api
{
    public function ask(Request $request): Response;
}
