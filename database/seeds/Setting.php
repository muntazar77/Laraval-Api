<?php

use App\Model\Setting as ModelSetting;
use Illuminate\Database\Seeder;

class Setting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelSetting::create([

            'log_name'=> 'مهد الحضارات',
            'phone'=> '078 435 262 86',
            'email' => 'ataarataar77@gmail.com',
            'about'=> 'موقع مختص بالتاريخ العراقي ',
            'instegrm' => 'instegrm.com',
            'facebook' => 'facebook.com',
            'twitter' =>'twitter.com',
            'addres'=>'وصف الموقع',
            // 'description'=>'description ',


       ]);
    }
}
