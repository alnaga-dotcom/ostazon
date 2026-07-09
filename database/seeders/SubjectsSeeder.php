<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectsSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            'Academic Writing', 'Accountancy', 'Adobe Photoshop', 'Algorithm & Data Structures',
            'Analog Electronics', 'Art and Craft', 'AutoCAD', 'Basic Electronics',
            'BioChemistry', 'Biology', 'Biotechnology', 'Business Management',
            'C/C++', 'C#', 'Chemistry', 'Civil Engineering', 'Commerce',
            'Communication Skills', 'Company Law', 'Computer networking',
            'Computer Science', 'Control Systems', 'DBMS', 'Digital Electronics',
            '.net', 'Economics', 'Electrical Engineering', 'Engineering Mechanics',
            'English', 'Environmental Science', 'Financial Management',
            'Fluid Mechanics', 'French', 'Geography', 'German', 'History',
            'HTML', 'IELTS', 'Income Tax', 'JAVA', 'Jquery and JavaScript',
            'Law', 'Maths', 'Mechanical', 'Microbiology', 'Music', 'PHP',
            'Physics', 'Political Science', 'Programming', 'Psychology',
            'Python', 'R', 'Science', 'Selenium Webdriver', 'Sociology',
            'Statistics', 'Strength of Materials', 'Thermodynamics', 'Zoology',
        ];

        $count = 0;
        foreach ($subjects as $name) {
            Subject::firstOrCreate(['name' => $name]);
            $count++;
        }

        $this->command->info("Inserted {$count} subjects.");
    }
}
