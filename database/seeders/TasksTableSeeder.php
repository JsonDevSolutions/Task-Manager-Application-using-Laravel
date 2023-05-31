<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Carbon\Carbon;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Task::truncate();

        $faker = \Faker\Factory::create();
        $currentDate = Carbon::now();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 50; $i++) {
            Task::create([
                'title' => $faker->word(10),
                'description' => $faker->text(50),
                'due_date' => $currentDate->addDays($i),
            ]);
        }
    }
}
