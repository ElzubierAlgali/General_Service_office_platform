<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');

        // Super admin seeder (creates global superadmin role & user)
        $this->command->info('Creating super admin...');
        $this->call(SuperAdminSeeder::class);

        // Organizations
        $this->command->info('Creating organizations...');
        $this->call(OrganizationSeeder::class);

        // Roles and Permissions
        $this->command->info('Creating roles and permissions...');
        $this->call(RolePermissionSeeder::class);

        // Assign all permissions to superadmin user
        $this->command->info('Assigning all permissions to superadmin...');
        \Database\Seeders\SuperAdminSeeder::assignAllPermissionsToSuperAdmin();

        // Users
        $this->command->info('Creating users...');
        $this->call(UserSeeder::class);

        // Customers
        $this->command->info('Creating customers...');
        $this->call(CustomerSeeder::class);

        // Services
        $this->command->info('Creating services...');
        $this->call(ServiceSeeder::class);

        // Tasks
        $this->command->info('Creating tasks...');
        $this->call(TaskSeeder::class);

        // Transactions
        $this->command->info('Creating transactions...');
        $this->call(TransactionSeeder::class);

        // Invoices
        $this->command->info('Creating invoices...');
        $this->call(InvoiceSeeder::class);

        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('📧 Default login: admin@example.com / password');
        $this->command->info('📧 Or use organization-specific: admin@tech-advanced.com / password');
    }
}
