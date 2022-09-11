<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $config1 = 'Addable Lending Points';
        Configuration::updateOrCreate([
            'name' => $config1,
            'slug' => Str::slug($config1, '_'),
            'value' => 2
        ]);

        $config2 = 'Deductible Lending Points';
        Configuration::updateOrCreate([
            'name' => $config2,
            'slug' => Str::slug($config2, '_'),
            'value' => 1
        ]);
    }
}
