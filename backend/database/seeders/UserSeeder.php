<?php

namespace Database\Seeders;

use App\Helpers\HelperModel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class UserSeeder extends Seeder
{
    use HelperModel;
    public function run(): void
    {
        for($i = 0; $i<10; $i++){
            $name = self::replaceName(fake()->name());
            $email = self::generateEmail($name);
            $username = self::generateUsername($name);
            if(!User::whereEmailOrUsername($email, $username)->exists()){
                self::createRecord(User::class,[
                    'name' => $name,
                    'email' => $email,
                    'username' => $username,
                    'password' => '12345678910'
                ]);
            }
        }
    }

    private static function generateEmail($name)
    {
        $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $name =  preg_replace('/[^a-zA-Z0-9]/', '', strtolower(str_replace([' ', 'Dr.', 'Sr.', 'Srta.', 'Sra.'], '', $name)));
        return $name . '@' . Arr::random([fake()->freeEmailDomain()]);
    }
    private static function generateUsername($name)
    {
        $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $name =  preg_replace('/[^a-zA-Z0-9]/', '', strtolower(str_replace([' ', 'Dr.', 'Sr.', 'Srta.', 'Sra.'], '', $name)));
        return $name;
    }

    private static function replaceName($name) {
        return preg_replace('/^(Dr\.|Sr\.|Srta\.|Sra\.)\s*/', '', $name);
    }
}
