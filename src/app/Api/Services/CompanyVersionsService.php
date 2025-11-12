<?php

namespace App\Api\Services;

use App\Api\Repositories\Contracts\CompanyRepositoryInterface;
use App\Api\Services\Contracts\CompanyVersionsServiceInterface;

class CompanyVersionsService implements CompanyVersionsServiceInterface
{
    public function __construct(
        protected CompanyRepositoryInterface $companies
    ) {}

    /**
     * @param string $edrpou
     * @return array|null
     */
    public function handle(string $edrpou): ?array
    {
        $company = $this->companies->findByEdrpou($edrpou, true);

        if (!$company) {
            return null;
        }

        return [
            'company' => [
                'id' => $company->id,
                'name' => $company->name,
                'edrpou' => $company->edrpou,
                'address' => $company->address,
            ],
            'versions' => $company->versions,
        ];
    }
}
