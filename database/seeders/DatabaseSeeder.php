<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Seat;
use App\Models\Permission;
use App\Models\Surname;
use App\Models\UserPermission;
use App\Models\Group; 
use App\Models\Invitation; 
use App\Models\InvitationSeat;
use Carbon\Carbon;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'username' => 'Admin username',
            'password' => bcrypt('password')
        ]);
        UserPermission::insert([
            ['user_id'=> 1 , 'permission_id' => 1 ],
            ['user_id'=> 1 , 'permission_id' => 2 ],
            ['user_id'=> 1 , 'permission_id' => 3 ],
            ['user_id'=> 1 , 'permission_id' => 4 ],
            ['user_id'=> 1 , 'permission_id' => 5 ],
            ['user_id'=> 1 , 'permission_id' => 6 ],
            ['user_id'=> 1 , 'permission_id' => 7 ],
            ['user_id'=> 1 , 'permission_id' => 8 ],
        ]);
        for($i = 0 ;$i < 10 ;$i++){
            $name = Str::random(5);
            $user = User::create([
                'name' => $name ,
                'email' => $name . '@example.com',
                'username' => $name . '-username',
                'password' => bcrypt('password')
            ]);
            // User permissions 

        }
        
        // Seats 
        $chars  = ['A' , 'B' , 'C' , 'D' , 'E'];
        foreach($chars as $char ){
            for($i =0  ;$i < 10 ; $i++){
                // echo $char . $i ;
                if($char == 'A' || $char == 'B'){
                    Seat::create([
                        'type' => 'vip',
                        'code' =>  $char . $i 
                    ]);
                }
                else{
                    Seat::create([
                        'type'=>'normal',
                        'code'=> $char . $i
                    ]);
                }
            }
        }
        // Permissions
        Permission::insert([
            ['name' => 'send_invitations'], // إرسال الدعوات
            ['name' => 'public_invitations'], // الدعوات العامة
            ['name' => 'accepted_invitations_festival_day'], // الدعوات المقبولة يوم الحفل
            ['name' => 'qr_code'], // 
            ['name' => 'assign_seats'], // تعيين الكراسي
            ['name' => 'dashboard'], // الإطلاع على الداشبور
            ['name' => 'users_managment'], // إدارة الموظفين
            ['name' => 'show_history'], // الإطلاع على سجل التغييرات
        ]);
        
        // Groups 
        Group::insert([
            ['title'=> 'Direct Markets Administrator' , 'color'=>'#0e254d'],
            ['title'=> 'Chief Response Executive' , 'color'=>'#523028'],
            ['title'=> 'National Configuration Developer' , 'color'=>'#523028'],
            ['title'=> 'Dynamic Optimization Associate' , 'color'=>'#20646f'],
            ['title'=> 'Customer Mobility Facilitator' , 'color'=>'#550d4f'],
            ['title'=>  "Regional Division Coordinator" , 'color'=>'#767b47'],
            
        ]);
        // Surnames
        Surname::insert([
            ["title"=> "Planner", "lang" => "english",],
            ["title"=> "Administrator", "lang" => "english",],
            ["title"=> "Producer", "lang" => "english",],
            ["title"=> "Designer", "lang" => "english",],
            ["title"=> "Assistant", "lang" => "english",],
            ["title"=> "Agent", "lang" => "english",]
        ]);
        for($i =0 ; $i < 10 ;$i++){
            Invitation::insert([
                [
                    "surname_id"=> 1,
                    "full_name"=> "Philip Hoppe",
                    "phone_number"=> "+96699321323"  ,
                    "email"=> Str::random(5)."@gmail.com",
                    "party"=> Str::random(8),
                    "position" => "Internal Configuration Engineer",
                    "status"=> "processing" ,
                    "type"=>"public",
                    'created_at' => new Carbon()
                ]
    
            ]);
        }
        for($i =0 ; $i < 10 ;$i++){
            Invitation::insert([
                [
                    "formal_title" => "Mr",
                    "surname_id" => 1,
                    "group_id" => 1,
                    "full_name" => "Lewis Weissnat",
                    "email" => Str::random(5). "@yahoo.com",
                    "additional_email" => Str::random(6). "@gmail.com",
                    "party" => "Kris - Hodkiewicz",
                    "whatsapp_number" => "+96613432322",
                    "position" => "Future Accounts Associate",
                    "invitation_lang" => "arabic",
                    "send_email" => 1,
                    "send_whatsapp" => 0,
                    "confirmed_at" => "2024-01-01",
                    "type" => "private",
                    'created_at' => new Carbon()
                ]
    
            ]);
        }

        // Invitation Seats
        for($i = 0 ;$i < 10 ;$i++){
            $seat_id = rand(1,48) ;
            $invitation_id = rand(1,20);
            $inv = InvitationSeat::where('seat_id' , $seat_id)->first();
            $inv_2 = InvitationSeat::where('invitation_id' , $invitation_id)->where('status','active')->count();
            if(($inv && $inv->status == 'active') || $inv_2 > 0){
                continue ;
            }
            $status = rand(0,1);
            InvitationSeat::create([
                'seat_id' => $seat_id,
                'invitation_id'=> $invitation_id,
                'user_id' => 1,
                'status'=> $status ? 'active' : 'inactive'
            ]);
        }
        
    
    }
}
