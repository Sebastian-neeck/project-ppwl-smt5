<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Listing;
use App\Models\Application; // ✅ TAMBAH INI
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat Admin 1 - farahsyaz2105@gmail.com
        $admin1 = User::where('email', 'farahsyaz2105@gmail.com')->first();
        
        if (!$admin1) {
            $admin1 = User::factory()->create([
                'name' => 'Farah Syaz',
                'email' => 'farahsyaz2105@gmail.com',
                'password' => Hash::make('12345678'),
                'is_admin' => true
            ]);
            $this->command->info('Admin 1 created: farahsyaz2105@gmail.com / 12345678');
        } else {
            $this->command->info('Admin 1 already exists: farahsyaz2105@gmail.com');
        }

        // Buat Admin 2 - babas@gmail.com
        $admin2 = User::where('email', 'babas@gmail.com')->first();
        
        if (!$admin2) {
            $admin2 = User::factory()->create([
                'name' => 'Babas Admin',
                'email' => 'babas@gmail.com',
                'password' => Hash::make('12345678'),
                'is_admin' => true
            ]);
            $this->command->info('Admin 2 created: babas@gmail.com / 12345678');
        } else {
            $this->command->info('Admin 2 already exists: babas@gmail.com');
        }

        // Buat user regular untuk testing (TANPA applications)
        $regularUser = User::where('email', 'user@example.com')->first();
        
        if (!$regularUser) {
            $regularUser = User::factory()->create([
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false
            ]);
            $this->command->info('Regular user created: user@example.com / password');
        } else {
            $this->command->info('Regular user already exists: user@example.com');
        }

        // Buat sample listings hanya jika belum ada
        if (Listing::count() === 0) {
            $listings = [
                [
                    'user_id' => $admin1->id,
                    'title' => 'Senior Laravel Developer',
                    'tags' => 'laravel,php,mysql',
                    'company' => 'Tech Solutions Inc',
                    'logo' => null,
                    'location' => 'Jakarta, Indonesia',
                    'email' => 'careers@techsolutions.com',
                    'website' => 'https://techsolutions.com',
                    'description' => 'We are looking for an experienced Laravel developer to join our dynamic team. Must have strong knowledge of PHP, MySQL, and modern web development practices.',
                    'status' => 'approved'
                ],
                [
                    'user_id' => $admin1->id,
                    'title' => 'Frontend Vue.js Developer',
                    'tags' => 'vue,javascript,frontend',
                    'company' => 'Digital Creative Agency',
                    'logo' => null,
                    'location' => 'Bandung, Indonesia',
                    'email' => 'hr@digitalcreative.com',
                    'website' => 'https://digitalcreative.com',
                    'description' => 'Join our frontend team to build amazing user experiences using Vue.js and modern JavaScript frameworks. Experience with responsive design required.',
                    'status' => 'approved'
                ],
                [
                    'user_id' => $admin2->id,
                    'title' => 'Full Stack Developer',
                    'tags' => 'nodejs,react,mongodb',
                    'company' => 'Startup XYZ',
                    'logo' => null,
                    'location' => 'Surabaya, Indonesia',
                    'email' => 'jobs@startupxyz.com',
                    'website' => 'https://startupxyz.com',
                    'description' => 'We need a full stack developer who can work with both frontend and backend technologies. Experience with MERN stack is a plus.',
                    'status' => 'pending'
                ],
                [
                    'user_id' => $admin2->id,
                    'title' => 'DevOps Engineer',
                    'tags' => 'aws,docker,kubernetes',
                    'company' => 'Cloud Services Co',
                    'logo' => null,
                    'location' => 'Bali, Indonesia',
                    'email' => 'recruitment@cloudservices.com',
                    'website' => 'https://cloudservices.com',
                    'description' => 'Looking for DevOps engineer with experience in AWS, Docker, and Kubernetes. Must have CI/CD pipeline experience.',
                    'status' => 'pending'
                ],
                [
                    'user_id' => $admin1->id,
                    'title' => 'Mobile App Developer',
                    'tags' => 'flutter,dart,firebase',
                    'company' => 'App Innovations',
                    'logo' => null,
                    'location' => 'Yogyakarta, Indonesia',
                    'email' => 'careers@appinnovations.com',
                    'website' => 'https://appinnovations.com',
                    'description' => 'Seeking Flutter developer to build cross-platform mobile applications. Experience with Firebase and state management required.',
                    'status' => 'approved'
                ],
                [
                    'user_id' => $admin2->id,
                    'title' => 'UI/UX Designer',
                    'tags' => 'figma,sketch,adobe-xd',
                    'company' => 'Creative Design Studio',
                    'logo' => null,
                    'location' => 'Medan, Indonesia',
                    'email' => 'hello@creativedesign.com',
                    'website' => 'https://creativedesign.com',
                    'description' => 'Looking for creative UI/UX designer with strong portfolio. Proficiency in Figma and design thinking process required.',
                    'status' => 'pending'
                ]
            ];

            foreach ($listings as $listingData) {
                Listing::create($listingData);
            }

            $this->command->info('Sample listings created successfully!');
        } else {
            $this->command->info('Listings already exist in database.');
        }

        $this->command->info('=== DATABASE SEEDING COMPLETED ===');
        $this->command->info('Total users: ' . User::count());
        $this->command->info('Total listings: ' . Listing::count());
        $this->command->info('Total applications: ' . \App\Models\Application::count()); // ✅ PAKAI FULL NAMESPACE
        $this->command->info('Approved listings: ' . Listing::where('status', 'approved')->count());
        $this->command->info('Pending listings: ' . Listing::where('status', 'pending')->count());
        
        $this->command->info('');
        $this->command->info('=== LOGIN CREDENTIALS ===');
        $this->command->info('Admin 1: farahsyaz2105@gmail.com / 12345678');
        $this->command->info('Admin 2: babas@gmail.com / 12345678');
        $this->command->info('User: user@example.com / password');
        $this->command->info('');
        $this->command->info('=== NOTE ===');
        $this->command->info('No sample applications created. Applications will appear when real users apply to jobs.');
    }
}