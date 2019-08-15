<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Tweet;


class TweetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tweet::create([
            'tweet_id' => '1',
            'user_id' => '14',
            'content' => 'Nemanja - prvi tvit',
        ]);

        Tweet::create([
            'tweet_id' => '2',
            'user_id' => '14',
            'content' => 'Nemanja - drugi tvit',
        ]);

        Tweet::create([
            'tweet_id' => '3',
            'user_id' => '15',
            'content' => 'Dragoljub - prvi tvit',
        ]);

        Tweet::create([
            'tweet_id' => '4',
            'user_id' => '15',
            'content' => 'Dragoljub - drugi tvit',
        ]);

    }
}