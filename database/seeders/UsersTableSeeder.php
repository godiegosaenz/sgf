<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = DB::table('users')->insert([
            'name' => 'Diego',
            'email' => 'tecnologia.informacion@sanvicente.gob.ec',
            'password' => bcrypt('123456'),
            'idpersona' => 1
        ]);

        $User = User::find(1);
        $User->assignRole('Super Admin');

    }
}
