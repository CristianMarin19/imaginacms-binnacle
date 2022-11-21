<?php

namespace Modules\Ibinnacle\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class IbinnacleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(IbinnacleModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
