<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class ComprehensiveSubjectsSeeder extends Seeder
{
    public function run()
    {
        // ---- Egyptian Primary School ----
        $primary = [
            'Social Studies',
            'Islamic Education',
            'Christian Education',
            'Art Education',
            'Music Education',
            'Physical Education',
            'Educational Activities',
            'Information and Communications Technology',
            'Professional Skills',
            'Values and Respect for Others',
        ];

        // ---- Egyptian Preparatory School ----
        $preparatory = [
            'Social Studies',
            'Islamic Education',
            'Christian Education',
            'Information and Communications Technology',
        ];

        // ---- Egyptian Secondary School ----
        $secondary = [
            'Integrated Science',
            'Philosophy and Logic',
            'National Education',
            'Philosophy',
            'Algebra',
            'Geometry',
            'Calculus',
            'Statics',
            'Dynamics',
            'Psychology and Sociology',
        ];

        // ---- Engineering ----
        $engineering = [
            'Structural Engineering',
            'Geotechnical Engineering',
            'Transportation Engineering',
            'Materials Science',
            'Signal Processing',
            'Embedded Systems',
            'Power Systems',
            'Machine Design',
            'Robotics',
            'Mechatronics',
            'Chemical Engineering',
            'Software Engineering',
            'Architecture',
            'Biomedical Engineering',
            'Industrial Engineering',
            'Computer Engineering',
            'Aerospace Engineering',
            'Petroleum Engineering',
            'Nuclear Engineering',
            'Engineering Physics',
            'Engineering Chemistry',
            'Surveying',
            'Construction Management',
            'Architectural Engineering',
            'Environmental Engineering',
            'Marine Engineering',
            'Textile Engineering',
            'Metallurgical Engineering',
            'Geological Engineering',
            'Ceramic Engineering',
            'Agricultural Engineering',
        ];

        // ---- Medicine & Health ----
        $medicine = [
            'Anatomy',
            'Physiology',
            'Pathology',
            'Pharmacology',
            'Histology',
            'Immunology',
            'Genetics',
            'Molecular Biology',
            'Neuroscience',
            'Cardiology',
            'Dermatology',
            'Pediatrics',
            'Internal Medicine',
            'Surgery',
            'Obstetrics and Gynecology',
            'Ophthalmology',
            'Orthopedics',
            'Psychiatry',
            'Radiology',
            'Anesthesiology',
            'Emergency Medicine',
            'Public Health',
            'Epidemiology',
            'Nursing',
            'Pharmacy',
            'Dentistry',
            'Veterinary Medicine',
            'Nutrition',
            'Dietetics',
            'Speech Therapy',
            'Occupational Therapy',
            'Physical Therapy',
            'Medical Laboratory Science',
            'Health Administration',
        ];

        // ---- Business ----
        $business = [
            'Marketing',
            'Human Resources',
            'Entrepreneurship',
            'Supply Chain Management',
            'International Business',
            'Business Ethics',
            'Corporate Finance',
            'Investment Management',
            'Auditing',
            'Business Law',
            'Organizational Behavior',
            'Strategic Management',
            'Operations Management',
            'E-Commerce',
            'Real Estate',
            'Insurance',
            'Banking and Finance',
        ];

        // ---- Arts & Humanities ----
        $arts = [
            'Fine Arts',
            'Graphic Design',
            'Interior Design',
            'Fashion Design',
            'Photography',
            'Film Studies',
            'Theater Arts',
            'Dance',
            'Literature',
            'Creative Writing',
            'Linguistics',
            'Cultural Studies',
            'Media Studies',
            'Journalism',
            'Digital Media',
            'Arabic Literature',
            'English Literature',
            'Comparative Literature',
            'Translation',
            'Archaeology',
            'Anthropology',
            'Library Science',
        ];

        // ---- Sciences (advanced) ----
        $sciences = [
            'Organic Chemistry',
            'Inorganic Chemistry',
            'Physical Chemistry',
            'Analytical Chemistry',
            'Astrophysics',
            'Quantum Mechanics',
            'Cell Biology',
            'Ecology',
            'Marine Biology',
            'Geology',
            'Astronomy',
            'Meteorology',
            'Oceanography',
            'Botany',
            'Virology',
            'Paleontology',
            'Seismology',
            'Hydrology',
        ];

        // ---- Computer Science & IT ----
        $cs = [
            'Data Science',
            'Artificial Intelligence',
            'Machine Learning',
            'Deep Learning',
            'Network Security',
            'Cybersecurity',
            'Information Technology',
            'Database Management',
            'Operating Systems',
            'Computer Graphics',
            'Animation',
            'Game Design',
            'Web Development',
            'Mobile App Development',
            'Cloud Computing',
            'DevOps',
            'Blockchain',
            'Data Mining',
            'Natural Language Processing',
            'Computer Vision',
            'Big Data',
            'Internet of Things',
            'Virtual Reality',
            'Augmented Reality',
        ];

        // ---- Education ----
        $education = [
            'Early Childhood Education',
            'Special Education',
            'Educational Psychology',
            'Curriculum Development',
            'Teaching Methods',
            'Education Technology',
            'Educational Administration',
        ];

        // ---- Social Sciences ----
        $social = [
            'Social Work',
            'Criminology',
            'International Relations',
            'Diplomacy',
            'Development Studies',
            'Gender Studies',
            'Peace and Conflict Studies',
            'Urban Planning',
            'Demography',
        ];

        // ---- Law ----
        $law = [
            'Constitutional Law',
            'Criminal Law',
            'Civil Law',
            'International Law',
            'Human Rights Law',
            'Environmental Law',
            'Tax Law',
            'Intellectual Property Law',
        ];

        // ---- Military & Security ----
        $military = [
            'Military Science',
            'Security Studies',
            'Forensic Science',
            'Fire Safety Engineering',
        ];

        // ---- Sports ----
        $sports = [
            'Sports Science',
            'Coaching',
            'Sports Management',
        ];

        // ---- Merge all, deduplicate against existing subjects ----
        $allNew = array_unique(array_merge(
            $primary, $preparatory, $secondary,
            $engineering, $medicine, $business, $arts, $sciences,
            $cs, $education, $social, $law, $military, $sports
        ));

        $count = 0;
        foreach ($allNew as $name) {
            Subject::firstOrCreate(['name' => $name]);
            $count++;
        }

        $total = Subject::count();
        $this->command->info("Added {$count} new subjects (total: {$total}).");

        // ---- Map Level → Subject names for reference (not stored, just informational) ----
        $levels = Level::orderBy('display_order')->get();
        $levelMap = [
            'Primary School'   => $primary,
            'Preparatory School' => $preparatory,
            'Secondary School'  => $secondary,
            'College / University' => array_merge(
                $engineering, $medicine, $business, $arts, $sciences,
                $cs, $education, $social, $law, $military, $sports
            ),
        ];

        $this->command->info('Subject organization by level (for reference):');
        foreach ($levels as $level) {
            $subjects = $levelMap[$level->name] ?? [];
            $this->command->line("  {$level->name}: " . count($subjects) . ' subjects');
        }
    }
}
