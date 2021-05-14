<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role;
        $role->code = 'admin';
        $role->translateOrNew('vi')->name = 'Người quản trị';
        $role->translateOrNew('en')->name = 'admin';
        $role->save();
    }
}
