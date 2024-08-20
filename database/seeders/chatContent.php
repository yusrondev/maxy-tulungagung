<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class chatContent extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chat_contents')->insert([
            'username_font' => '',
            'chat_font' => '',
            'username_color' => '',
            'chat_color' => '',
            'chat_sizeName' => '',
            'chat_size' => '',
        ]);
    }
}
