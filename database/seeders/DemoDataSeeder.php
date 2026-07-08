<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TutorProfile;
use App\Models\StudentProfile;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create subjects (only 'name' column exists)
        $subjects = [
            'Mathematics',
            'Physics',
            'Chemistry',
            'Biology',
            'English',
            'Arabic',
            'Programming',
            'History',
            'Geography',
            'Economics',
            'French',
            'Science',
        ];

        foreach ($subjects as $subjectName) {
            Subject::firstOrCreate(['name' => $subjectName]);
        }

        // Create demo tutor - use only basic columns that likely exist
        $tutorUser = User::firstOrCreate(
            ['email' => 'tutor@demo.com'],
            [
                'name' => 'Dr. Ahmed Hassan',
                'password' => Hash::make('password'),
                'role' => 'tutor',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // Try to create tutor profile with minimal fields
        try {
            TutorProfile::firstOrCreate(
                ['user_id' => $tutorUser->id],
                [
                    'bio' => 'Experienced math tutor with 10+ years teaching experience.',
                    'hourly_rate' => 30,
                    'verification_status' => 'verified',
                    'lesson_mode' => 'online',
                    'country' => 'Egypt',
                ]
            );
        } catch (\Exception $e) {
            echo "Tutor profile creation note: " . $e->getMessage() . "\n";
        }

        // Create demo student
        $studentUser = User::firstOrCreate(
            ['email' => 'student@demo.com'],
            [
                'name' => 'Ahmed Student',
                'password' => Hash::make('password'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]
        );

        try {
            StudentProfile::firstOrCreate(
                ['user_id' => $studentUser->id],
                [
                    'grade_level' => 'University',
                ]
            );
        } catch (\Exception $e) {
            echo "Student profile creation note: " . $e->getMessage() . "\n";
        }

        // Create more demo tutors
        $demoTutors = [
            ['name' => 'Ms. Sarah Khalil', 'email' => 'sarah@demo.com', 'subject' => 'English', 'price' => 25],
            ['name' => 'Dr. Omar Farouk', 'email' => 'omar@demo.com', 'subject' => 'Physics', 'price' => 35],
            ['name' => 'Prof. Fatima Ali', 'email' => 'fatima@demo.com', 'subject' => 'Chemistry', 'price' => 28],
            ['name' => 'Mr. Karim Mahmoud', 'email' => 'karim@demo.com', 'subject' => 'Programming', 'price' => 40],
        ];

        foreach ($demoTutors as $tutor) {
            $user = User::firstOrCreate(
                ['email' => $tutor['email']],
                [
                    'name' => $tutor['name'],
                    'password' => Hash::make('password'),
                    'role' => 'tutor',
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]
            );

            try {
                TutorProfile::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'bio' => 'Professional tutor specializing in ' . $tutor['subject'] . '.',
                        'hourly_rate' => $tutor['price'],
                        'verification_status' => 'verified',
                        'lesson_mode' => 'online',
                        'country' => 'Egypt',
                    ]
                );
            } catch (\Exception $e) {
                echo "Tutor profile creation note for " . $tutor['name'] . ": " . $e->getMessage() . "\n";
            }
        }

        echo "Demo data seeded successfully!\n";
        echo "Login as tutor: tutor@demo.com / password\n";
        echo "Login as student: student@demo.com / password\n";
    }
}
