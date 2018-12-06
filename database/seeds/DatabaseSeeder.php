<?php

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['nume' => 'carti'],
            ['nume' => 'rechizite'],
            ['nume' => 'haine'],
            ['nume' => 'mobila'],
            ['nume' => 'casa_si_gradina'],
            ['nume' => 'electronice_electrocasnice'],
            ['nume' => 'alimente'],
            ['nume' => 'ajutor_munca_fizica'],
            ['nume' => 'automobile'],
            ['nume' => 'articole_sportive'],
            ['nume' => 'bijuterii'],
            ['nume' => 'pentru_copii'],
        ];

        $user_roles = [
            [
                'slug' => 'ordinary_user',
                'name' => 'ordinary_user'
            ],
            [
                'slug' => 'moderator',
                'name' => 'moderator'
            ],
            [
                'slug' => 'admin',
                'name' => 'admin'
            ]
        ];

        DB::table('categories')->insert($categories);

        DB::table('roles')->insert($user_roles);

        factory(App\User::class, 25)->create()->each(function ($user) {

            $faker = Faker\Factory::create();

            $role = Sentinel::findRoleBySlug($faker->boolean(85) ? 'ordinary_user' : 'moderator');

            $role->users()->attach($user);
        });

        factory(App\DonationOffer::class, 150)->create()->each(function ($donationOffer) {
           $nr_of_categories_attached_to = random_int(1, 3);

           $categories_ids = range(1, 12);

           $atached_categories = array_slice($categories_ids, 0, $nr_of_categories_attached_to);

           $donationOffer->categories()->attach($atached_categories);
        });

        factory(App\DonationRequest::class, 150)->create()->each(function ($donationRequest) {
            $nr_of_categories_attached_to = random_int(1, 3);

            $categories_ids = range(1, 12);

            $atached_categories = array_slice($categories_ids, 0, $nr_of_categories_attached_to);

            $donationRequest->categories()->attach($atached_categories);
        });

/*        $faker = Faker\Factory::create();
        $faker->image($dir = 'storage/app/public', $width = 640, $height = 480); // '/tmp/13b73edae8443990be1aa8f1a483bc27.jpg'*/

    }
}
