<?php

namespace App\Api\Repositories;

use App\Api\Repositories\Contracts\CompanyRepositoryInterface;
use App\Models\Company;
use App\Models\CompanyVersion;

class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @param string $edrpou
     * @param bool $withVersions
     * @return Company|null
     */
    public function findByEdrpou(string $edrpou, bool $withVersions = false): ?Company
    {
        $query = Company::where('edrpou', $edrpou);

        if ($withVersions) {
            $query->with(['versions' => function ($q) {
                $q->orderByDesc('version');
            }]);
        }

        return $query->first();
    }

    /**
     * @param array $data
     * @return Company
     */
    public function create(array $data): Company
    {
        return Company::create($data);
    }

    /**
     * @param Company $company
     * @param array $data
     * @return bool
     */
    public function update(Company $company, array $data): bool
    {
        return $company->update($data);
    }

    /**
     * @param Company $company
     * @return int
     */
    public function getLastVersionNumber(Company $company): int
    {
        return $company->versions()->max('version') ?? 0;
    }

    /**
     * @param Company $company
     * @param array $data
     * @param int|null $versionNumber
     * @return CompanyVersion
     */
    public function createVersion(Company $company, array $data, ?int $versionNumber = null): CompanyVersion
    {
        $versionNumber = $versionNumber ?? $this->getLastVersionNumber($company) + 1;

        return $company->versions()->create([
            'version' => $versionNumber,
            'name'    => $data['name'],
            'edrpou'  => $data['edrpou'],
            'address' => $data['address'],
        ]);
    }
}
