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
        config(['app.events_enabled' => false]);
        $count = 0;
        for($i=0;$i<100;$i++){
            $name = fake()->name();
            $email = self::generateEmail($name);
            $username = self::generateUserName($name);
            $verify = User::whereEmailOrUsername($email,$username)->first();
            if(!$verify){
               self::setData([
                    'name' => $name,
                    'email' => $email,
                    'username' => $username,
                    'password' => '12345678910',
                    'active' => 1    
                ], User::class);
            }
            if($verify){
                $count = $count + 1;
                $created_at = date('d/m/Y H:i:s', strtotime($verify->created_at));
                $now = date('d/m/y H:i:s', strtotime(now()));
                echo "($count) $verify->sequence  - $name - $username - $email - Created:$created_at - Now:$now \n";
            }
        }
        echo "$count \n";
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
