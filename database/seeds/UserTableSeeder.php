<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**ini untuk membuat name faker untuk nama user yang banyak di table user*/
        factory(App\Models\User::class,200)->create();
    }
}
