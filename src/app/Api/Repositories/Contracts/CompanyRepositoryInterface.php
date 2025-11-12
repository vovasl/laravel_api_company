<?php

namespace App\Api\Repositories\Contracts;

use App\Models\Company;
use App\Models\CompanyVersion;

interface CompanyRepositoryInterface
{
    public function findByEdrpou(string $edrpou, bool $withVersions = false): ?Company;

    public function create(array $data): Company;

    public function update(Company $company, array $data): bool;

    public function getLastVersionNumber(Company $company): int;

    public function createVersion(Company $company, array $data, ?int $versionNumber = null): CompanyVersion;
}
