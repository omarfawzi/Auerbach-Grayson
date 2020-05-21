<?php

namespace App\Contracts;

interface Hook
{
    public function before(object $request): void;

    public function after(object $model): void;
}
