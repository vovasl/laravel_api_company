<?php

namespace App\Api\Services\Contracts;

interface StoreCompanyServiceInterface
{
    public function handle(array $data): array;
}
