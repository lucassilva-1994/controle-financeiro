<?php

namespace Database\Seeders;

use App\Helpers\Model;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class UsersSeeder extends Seeder
{
    use Model;
    public function run()
    {
        for($i=0;$i<10;$i++){
            $name = fake()->unique()->name();
            $email = self::generateEmail($name);
            $user = self::generateUserName($name);
            $emailVerify = User::whereEmail($email)->first();
            $usernameVerify = User::where('username',$user)->first();
            if(!$emailVerify && !$usernameVerify){
               self::setData([
                    'name' => $name,
                    'email' => $email,
                    'username' => $user,
                    'password' => '12345678910',
                    'active' => 1    
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
