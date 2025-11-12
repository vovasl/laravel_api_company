<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyStoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
    }

    public function test_it_creates_a_new_company_and_first_version()
    {
        $response = $this->postJson('/api/company', [
            'name' => 'ТОВ Українська енергетична біржа',
            'edrpou' => '37027819',
            'address' => '01001, Україна, м. Київ, вул. Хрещатик, 44',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'created',
                'version' => 1,
            ]);

        $this->assertDatabaseHas('companies', [
            'edrpou' => '37027819',
        ]);

        $this->assertDatabaseHas('company_versions', [
            'version' => 1,
            'edrpou' => '37027819',
        ]);
    }

    public function test_it_detects_duplicate_data_and_does_not_create_new_version()
    {
        $company = Company::factory()->create([
            'name' => 'ТОВ Українська енергетична біржа',
            'edrpou' => '37027819',
            'address' => '01001, Україна, м. Київ, вул. Хрещатик, 44',
        ]);

        $company->versions()->create([
            'version' => 1,
            'name' => $company->name,
            'edrpou' => $company->edrpou,
            'address' => $company->address,
        ]);

        $this->postJson('/api/company', [
            'name' => $company->name,
            'edrpou' => $company->edrpou,
            'address' => $company->address,
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'duplicate',
            ]);

        $this->assertDatabaseCount('company_versions', 1);
    }

    public function test_it_updates_existing_company_and_creates_new_version()
    {
        $company = Company::factory()->create([
            'name' => 'ТОВ Українська енергетична біржа',
            'edrpou' => '37027819',
            'address' => 'Київ, вул. Хрещатик, 44',
        ]);

        $this->postJson('/api/company', [
            'name' => 'ТОВ Українська енергетична біржа',
            'edrpou' => '37027819',
            'address' => 'Київ, вул. Хрещатик, 50',
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'updated',
                'company_id' => $company->id,
                'version' => 1,
            ]);

        $this->assertDatabaseHas('companies', [
            'address' => 'Київ, вул. Хрещатик, 50',
        ]);

        $this->assertDatabaseHas('company_versions', [
            'version' => 1,
            'address' => 'Київ, вул. Хрещатик, 50',
        ]);
    }
}
