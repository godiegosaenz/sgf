<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        $this->call(ProvinciasTableSeeder::class);
        $this->call(CantonesTableSeeder::class);
        $this->call(PersonasTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EspecialidadesSeeder::class);
        $this->call(TypeLiquidationSeeder::class);
        $this->call(RubroSeeder::class);
    }
}
