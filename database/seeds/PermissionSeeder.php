<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['name' => 'List user', 'code' => 'list-user'],
            ['name' => 'Create user', 'code' => 'create-user'],
            ['name' => 'Update user', 'code' => 'update-user'],
            ['name' => 'Delete user', 'code' => 'delete-user'],
            ['name' => 'List category', 'code' => 'list-category'],
            ['name' => 'Create category', 'code' => 'create-category'],
            ['name' => 'Update category', 'code' => 'update-category'],
            ['name' => 'Delete category', 'code' => 'delete-category'],
        ]);
    }
}
