<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class rolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert(
            [
                [
                    'id'=>1,
                'name'=>"clt",
                "created_at"=>now()
                 ],
            [
                'id'=>2,
                'name'=>"vdr",
                "created_at"=>now()
            ],
            [
                'id'=>3,
                'name'=>"admin",
                "created_at"=>now()
            ]

            ]
            
    );
    }
}
