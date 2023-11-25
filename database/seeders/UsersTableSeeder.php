<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            
            array (
                'id' => 600940761822611,
                'name' => 'Valery Cruz',
                'email' => 'vale@email.com',
                'sessionStartedAt' => NULL,
                'password' => '$2y$10$bBX0jfMJy0tufuQBIjs/n.E1IFH41K7Lb5evLMKnw2OEZCzR70jpu',
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}