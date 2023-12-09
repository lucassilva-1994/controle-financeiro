<?php

namespace Database\Seeders;

use App\Models\HelperModel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class UsersSeeder extends Seeder
{
    public function run()
    {
        for($i=0;$i<100;$i++){
            $name = fake()->unique()->name();
            $email = self::generateEmail($name);
            $user = self::generateUserName($name);
            $emailVerify = User::whereEmail($email)->first();
            $userVerify = User::whereUser($user)->first();
            if(!$emailVerify && !$userVerify){
                HelperModel::setData([
                    'name' => $name,
                    'email' => $email,
                    'user' => $user,
                    'password' => '12345678910',
                    'is_active' => 1    
                ], User::class);
            }
        }
    }

    private static function generateUserName($name)
    {
        $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $name =  preg_replace('/[^a-zA-Z0-9]/', '', strtolower(str_replace([' ', 'Dr.', 'Sr.', 'Srta.', 'Sra.'], '', $name)));
        return $name;
    }

    private static function generateEmail($name)
    {
        $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $name =  preg_replace('/[^a-zA-Z0-9]/', '', strtolower(str_replace([' ', 'Dr.', 'Sr.', 'Srta.', 'Sra.'], '', $name)));
        return $name . '@' . Arr::random([fake()->freeEmailDomain()]);
    }
}
