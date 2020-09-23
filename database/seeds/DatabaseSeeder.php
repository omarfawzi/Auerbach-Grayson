<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Register the user seeder
        //$this->call(UsersTableSeeder::class);
        factory(App\Models\User::class, 5)->create();
        Model::reguard();
    }
}
