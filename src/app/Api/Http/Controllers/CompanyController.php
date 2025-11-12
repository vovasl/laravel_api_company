<?php

namespace App\Api\Http\Controllers;

use App\Api\Services\Contracts\CompanyVersionsServiceInterface;
use App\Api\Services\Contracts\StoreCompanyServiceInterface;
use Illuminate\Http\JsonResponse;
use App\Api\Http\Requests\StoreCompanyRequest;

class CompanyController extends ApiController
{
    public function __construct(
        protected StoreCompanyServiceInterface $service,
        protected CompanyVersionsServiceInterface $versionsService
    ) {}

    public function store(StoreCompanyRequest $request): JsonResponse
    {
        $result = $this->service->handle($request->validated());
        return response()->json($result);
    }


    public function versions(string $edrpou): JsonResponse
    {
        $result = $this->versionsService->handle($edrpou);

        if (!$result) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        return response()->json($result);
    }

}
