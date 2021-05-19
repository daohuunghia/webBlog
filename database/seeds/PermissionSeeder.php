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
            ['name' => 'List role', 'code' => 'list-role'],
            ['name' => 'Create role', 'code' => 'create-role'],
            ['name' => 'Update role', 'code' => 'update-role'],
            ['name' => 'Delete role', 'code' => 'delete-role'],
            ['name' => 'List category', 'code' => 'list-category'],
            ['name' => 'Create category', 'code' => 'create-category'],
            ['name' => 'Update category', 'code' => 'update-category'],
            ['name' => 'Delete category', 'code' => 'delete-category'],
            ['name' => 'List product', 'code' => 'list-product'],
            ['name' => 'Create product', 'code' => 'create-product'],
            ['name' => 'Update product', 'code' => 'update-product'],
            ['name' => 'Delete product', 'code' => 'delete-product'],
            ['name' => 'List post', 'code' => 'list-post'],
            ['name' => 'Create post', 'code' => 'create-post'],
            ['name' => 'Update post', 'code' => 'update-post'],
            ['name' => 'Delete post', 'code' => 'delete-post'],
        ]);
    }
}
