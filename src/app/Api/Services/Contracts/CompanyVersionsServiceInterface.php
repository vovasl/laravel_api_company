<?php

namespace App\Api\Services\Contracts;

interface CompanyVersionsServiceInterface
{
    public function handle(string $edrpou): ?array;
}
