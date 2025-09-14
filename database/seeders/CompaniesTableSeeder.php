<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompaniesTableSeeder extends Seeder
{
    public function run(): void
    {
        Company::insert([
            ['company_name' => 'コカ・コーラ'],
            ['company_name' => 'サントリー'],
            ['company_name' => 'キリン'],
            ['company_name' => 'アサヒ'],
            ['company_name' => 'ダイドー'],
            ['company_name' => 'ポッカサッポロ'],
            ['company_name' => '伊藤園'],
            ['company_name' => '雪印メグミルク'],
            ['company_name' => '森永'],
            ['company_name' => 'UCC'],
            ['company_name' => 'ネスレ'],
        ]);
    }
}
