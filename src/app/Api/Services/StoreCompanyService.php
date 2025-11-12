<?php

namespace App\Api\Services;

use App\Api\Repositories\Contracts\CompanyRepositoryInterface;
use App\Api\Services\Contracts\StoreCompanyServiceInterface;
use Illuminate\Support\Facades\DB;
use Throwable;

class StoreCompanyService implements StoreCompanyServiceInterface
{
    public function __construct(protected CompanyRepositoryInterface $company)
    {
    }

    /**
     * @param array $data
     * @return array
     * @throws Throwable
     */
    public function handle(array $data): array
    {
        $company = $this->company->findByEdrpou($data['edrpou']);

        if (!$company) {
            $company = $this->company->create($data);
            $this->company->createVersion($company, $data, 1);

            return [
                'status'     => 'created',
                'company_id' => $company->id,
                'version'    => 1,
            ];
        }

        if (
            $company->name === $data['name'] &&
            $company->address === $data['address']
        ) {
            return [
                'status'     => 'duplicate',
                'company_id' => $company->id,
                'version'    => $this->company->getLastVersionNumber($company),
            ];
        }

        $version = DB::transaction(function () use ($company, $data) {
            $this->company->update($company, $data);
            return $this->company->createVersion($company, $data);
        });

        return [
            'status'     => 'updated',
            'company_id' => $company->id,
            'version'    => $version->version,
        ];
    }
}
