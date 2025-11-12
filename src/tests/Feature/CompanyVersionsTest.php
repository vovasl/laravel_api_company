<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\CompanyVersion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyVersionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
    }

    public function test_it_returns_company_with_all_versions()
    {
        $company = Company::factory()->create([
            'edrpou' => '37027819',
            'name' => 'ТОВ Українська енергетична біржа',
            'address' => 'м. Київ, вул. Хрещатик, 44',
        ]);

        CompanyVersion::factory()->create([
            'company_id' => $company->id,
            'version' => 1,
            'name' => $company->name,
            'edrpou' => $company->edrpou,
            'address' => $company->address,
        ]);

        CompanyVersion::factory()->create([
            'company_id' => $company->id,
            'version' => 2,
            'name' => 'ТОВ Українська енергетична біржа (оновлена)',
            'edrpou' => $company->edrpou,
            'address' => 'м. Київ, вул. Хрещатик, 50',
        ]);

        $response = $this->getJson("/api/company/{$company->edrpou}/versions");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'company' => ['id', 'name', 'edrpou', 'address'],
                'versions' => [
                    ['id', 'version', 'name', 'edrpou', 'address']
                ]
            ])
            ->assertJsonFragment([
                'edrpou' => '37027819',
            ]);

        $this->assertCount(2, $response->json('versions'));
    }

    public function test_it_returns_404_if_company_not_found()
    {
        $response = $this->getJson('/api/company/00000000/versions');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Company not found',
            ]);
    }
}
