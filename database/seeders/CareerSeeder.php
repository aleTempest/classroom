<?php

namespace Database\Seeders;

use App\Models\Career;
use Illuminate\Database\Seeder;

class CareerSeeder extends Seeder
{
    public function run()
    {
        $careers = [
            'Computer Science',
            'Business Administration',
            'Electrical Engineering',
            'Mechanical Engineering',
            'Medicine',
            'Law',
            'Architecture',
            'Psychology',
            'Nursing',
            'Education',
            'Graphic Design',
            'Marketing',
            'Accounting',
            'Civil Engineering',
            'Biology',
        ];

        foreach ($careers as $career) {
            Career::create([
                'name' => $career,
            ]);
        }
    }
}
