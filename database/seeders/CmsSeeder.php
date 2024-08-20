<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cms')->insert([
            'website_name' => 'maxi',
            'logo' => '...',
            'primary_color' => '#3d3d3d',
            'secondary_color' => '#e1e1e1',
            'image' => ''
        ]);
    }
}
