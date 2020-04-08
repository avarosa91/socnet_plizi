<?php
//namespace

use Illuminate\Database\Seeder;

use App\Models\Profile;
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
        $email1 = $this->command->ask('Enter email of first user', 'user@mail.com');
        $email2 = $this->command->ask('Enter email of admin user', 'admin@mail.com');
        $count_of_users = $this->command->ask('How many users you want to generate', 10);

        $user1 = User::where('email', $email1)->first();
        if (!$user1) {
            $user1 = User::create([
                'email' => $email1,
                'password' => bcrypt('secret'),
                'token' => bcrypt('secret'),
                'last_activity_dt' => time(),
                'created_at' => time(),
                'updated_at' => time()
            ]);
            $user1->profile()->create($this->generateProfile());
            $this->command->line("Generate user with email {$email1}");
        } else {
            $this->command->line("User with email {$email1} already exists");
        }

        $user2 = User::where('email', $email2)->first();
        if (!$user2) {
            $user2 = User::create([
                'email' => $email2,
                'password' => bcrypt('hfj4675kf'),
                'token' => bcrypt('hfj4675kf'),
                'last_activity_dt' => time(),
                'is_admin' => true,
                'created_at' => time(),
                'updated_at' => time()
            ]);
            $user2->profile()->create($this->generateProfile());
            $this->command->line("Generate user with email {$email2}");
        } else {
            $this->command->line("User with email {$email2} already exists");
        }

        $faker = Faker\Factory::create();
        for ($i = 0; $i <= $count_of_users; $i++) {
            $fakeEmail = $faker->email;
            $user = User::where('email', $fakeEmail)->first();
            if (!$user) {
                $user = User::create([
                    'email' => $faker->email,
                    'password' => bcrypt('secret'),
                    'token' => bcrypt('secret'),
                    'last_activity_dt' => time(),
                    'created_at' => time(),
                    'updated_at' => time()
                ]);
                $user->profile()->create($this->generateProfile());
                $this->command->line("Generate user with email {$user->email}");
            } else {
                $i--;
            }
        }
    }


    private function generateProfile() {
        $faker = Faker\Factory::create('ru_RU');
        return [
            'firstname' => $faker->firstName,
            'lastname' => $faker->lastName,
            'birthday' => $faker->dateTimeBetween('-70 years', '-20 years'),
            'city' => $faker->city,
            'sex' => $faker->randomElement(['n', 'm', 'f']),
            'user_pic' => $faker->imageUrl(640, 480, 'people', false),
        ];
    }
}
