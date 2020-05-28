<?php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         $array = array(         
            array(
                'name'=>'admin',
                //'adress'=>'Bharatpur',
                'email'=>'admin@myblog.com',
                'role'=>'admin',
                'password'=>Hash::make('meroblog2076')
            ),
            array(
                'name'=>'blogger1',
                //'adress'=>'Kathmandu',
                'email'=>'blogger@meroblog.com',
                'role'=>'blogger',
                'password'=>Hash::make('blogger2076')
            )
        );
        foreach($array as $key=>$value){
            $user = User::where('email', $value['email'])->first();
            if(!$user){
                $user = new User();
            }
            $user->fill($value);
            $user->save();
        }
    }
}
