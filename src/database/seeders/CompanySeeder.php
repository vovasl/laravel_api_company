<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyVersion;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'name' => 'ТОВ Українська енергетична біржа',
                'edrpou' => '37027819',
                'address' => '01001, Україна, м. Київ, вул. Хрещатик, 44',
            ],
            [
                'name' => 'ТОВ ЕнергоСервіс Україна',
                'edrpou' => '12345678',
                'address' => '02000, Україна, м. Київ, вул. Січових Стрільців, 10',
            ],
        ];

        foreach ($companies as $data) {
            $company = Company::create($data);

            CompanyVersion::create([
                'company_id' => $company->id,
                'version' => 1,
                'name' => $company->name,
                'edrpou' => $company->edrpou,
                'address' => $company->address,
            ]);

            CompanyVersion::create([
                'company_id' => $company->id,
                'version' => 2,
                'name' => $company->name . ' (оновлена)',
                'edrpou' => $company->edrpou,
                'address' => $company->address . ', офіс 4',
            ]);
        }
    }
}
