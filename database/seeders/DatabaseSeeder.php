<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JobPosting;
use App\Models\Application;
use App\Models\Report;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@jobportal.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create HR Users
        $hr1 = User::create([
            'name' => 'John HR Manager',
            'email' => 'hr1@company.com',
            'password' => Hash::make('password'),
            'role' => 'hr',
        ]);

        $hr2 = User::create([
            'name' => 'Sarah Recruiter',
            'email' => 'hr2@company.com',
            'password' => Hash::make('password'),
            'role' => 'hr',
        ]);

        // Create Job Seekers
        $users = [];
        for ($i = 1; $i <= 5; $i++) {
            $users[] = User::create([
                'name' => "Job Seeker $i",
                'email' => "seeker$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }

        // Create Job Postings
        $job1 = JobPosting::create([
            'title' => 'Senior Software Engineer',
            'company_name' => 'Tech Corp',
            'location' => 'San Francisco, CA',
            'employment_type' => 'full-time',
            'salary_range' => '$120,000 - $180,000',
            'description' => 'We are looking for an experienced software engineer to join our team. You will work on cutting-edge technologies and help build scalable systems.',
            'requirements' => "- 5+ years of experience in software development\n- Strong knowledge of Laravel and PHP\n- Experience with Vue.js or React\n- Excellent problem-solving skills",
            'posted_by' => $hr1->id,
            'status' => 'active',
        ]);

        $job2 = JobPosting::create([
            'title' => 'Frontend Developer',
            'company_name' => 'Design Studio',
            'location' => 'New York, NY',
            'employment_type' => 'full-time',
            'salary_range' => '$80,000 - $120,000',
            'description' => 'Join our creative team to build beautiful and responsive web applications.',
            'requirements' => "- 3+ years of frontend development experience\n- Expert in HTML, CSS, JavaScript\n- Experience with Tailwind CSS\n- Portfolio required",
            'posted_by' => $hr1->id,
            'status' => 'active',
        ]);

        $job3 = JobPosting::create([
            'title' => 'Marketing Intern',
            'company_name' => 'Marketing Agency',
            'location' => 'Remote',
            'employment_type' => 'internship',
            'salary_range' => '$15 - $20/hour',
            'description' => 'Great opportunity for students to learn digital marketing and social media management.',
            'requirements' => "- Currently enrolled in Marketing or related field\n- Strong communication skills\n- Knowledge of social media platforms\n- Eager to learn",
            'posted_by' => $hr2->id,
            'status' => 'active',
        ]);

        $job4 = JobPosting::create([
            'title' => 'DevOps Engineer',
            'company_name' => 'Cloud Solutions Inc',
            'location' => 'Austin, TX',
            'employment_type' => 'full-time',
            'salary_range' => '$100,000 - $150,000',
            'description' => 'Help us build and maintain cloud infrastructure for our growing platform.',
            'requirements' => "- Experience with AWS or Azure\n- Knowledge of Docker and Kubernetes\n- Strong scripting skills (Python, Bash)\n- CI/CD pipeline experience",
            'posted_by' => $hr2->id,
            'status' => 'active',
        ]);

        $job5 = JobPosting::create([
            'title' => 'UI/UX Designer',
            'company_name' => 'Creative Labs',
            'location' => 'Los Angeles, CA',
            'employment_type' => 'contract',
            'salary_range' => '$60 - $80/hour',
            'description' => 'We need a talented designer to help redesign our product interface.',
            'requirements' => "- 4+ years of UI/UX design experience\n- Proficient in Figma and Adobe XD\n- Strong portfolio demonstrating user-centered design\n- Understanding of accessibility standards",
            'posted_by' => $hr1->id,
            'status' => 'active',
        ]);

        $job6 = JobPosting::create([
            'title' => 'Junior Developer',
            'company_name' => 'Startup Inc',
            'location' => 'Boston, MA',
            'employment_type' => 'full-time',
            'salary_range' => '$60,000 - $80,000',
            'description' => 'Perfect for recent graduates looking to start their career in software development.',
            'requirements' => "- Bachelor's degree in Computer Science or related field\n- Knowledge of programming fundamentals\n- Familiarity with web technologies\n- Enthusiastic about learning",
            'posted_by' => $hr2->id,
            'status' => 'closed',
        ]);

        // Create Applications
        Application::create([
            'job_id' => $job1->id,
            'user_id' => $users[0]->id,
            'cover_letter' => 'I am very interested in this position and believe my 6 years of experience in software development make me a great fit.',
            'status' => 'submitted',
        ]);

        Application::create([
            'job_id' => $job1->id,
            'user_id' => $users[1]->id,
            'cover_letter' => 'With my extensive background in Laravel and Vue.js, I would love to contribute to your team.',
            'status' => 'in_review',
        ]);

        Application::create([
            'job_id' => $job2->id,
            'user_id' => $users[0]->id,
            'cover_letter' => 'As a passionate frontend developer, I am excited about the opportunity to work on creative projects.',
            'status' => 'shortlisted',
        ]);

        Application::create([
            'job_id' => $job3->id,
            'user_id' => $users[2]->id,
            'cover_letter' => 'I am a marketing student looking for hands-on experience in digital marketing.',
            'status' => 'submitted',
        ]);

        Application::create([
            'job_id' => $job4->id,
            'user_id' => $users[3]->id,
            'cover_letter' => 'With 3 years of experience in cloud infrastructure, I am confident I can help your team.',
            'status' => 'accepted',
        ]);

        Application::create([
            'job_id' => $job5->id,
            'user_id' => $users[4]->id,
            'cover_letter' => null,
            'status' => 'rejected',
        ]);

        // Create Reports
        Report::create([
            'job_id' => $job1->id,
            'user_id' => $users[2]->id,
            'reason' => 'The salary range seems significantly lower than market rate for this position.',
            'status' => 'new',
        ]);

        Report::create([
            'job_id' => $job3->id,
            'user_id' => $users[3]->id,
            'reason' => 'Job description does not match the actual requirements listed.',
            'status' => 'reviewed',
        ]);
    }
}
