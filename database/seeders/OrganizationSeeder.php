<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = [
            [
                'name' => 'شركة التقنية المتقدمة',
                'subdomain' => 'tech-adv',
                'slug' => 'tech-advanced',
                'description' => 'شركة متخصصة في خدمات التكنولوجيا والاستشارات التقنية',
                'plan' => 'premium',
                'status' => 'active',
                'timezone' => 'Asia/Riyadh',
                'locale' => 'ar',
                'settings' => [
                    'theme' => 'light',
                    'notifications' => true,
                ],
            ],
            [
                'name' => 'مؤسسة الخدمات العامة',
                'subdomain' => 'public-services',
                'slug' => 'public-services',
                'description' => 'مؤسسة تقدم خدمات عامة متنوعة للعملاء',
                'plan' => 'standard',
                'status' => 'active',
                'timezone' => 'Asia/Riyadh',
                'locale' => 'ar',
                'settings' => [
                    'theme' => 'light',
                    'notifications' => true,
                ],
            ],
            [
                'name' => 'شركة المطورين السريعين',
                'subdomain' => 'fast-dev',
                'slug' => 'fast-developers',
                'description' => 'شركة تطوير برمجيات وخدمات تقنية',
                'plan' => 'basic',
                'status' => 'active',
                'timezone' => 'UTC',
                'locale' => 'en',
                'settings' => [
                    'theme' => 'dark',
                    'notifications' => false,
                ],
            ],
        ];

        foreach ($organizations as $orgData) {
            // Organizations don't have organization_id, so we use withoutGlobalScopes
            Organization::withoutGlobalScopes()->firstOrCreate(
                ['slug' => $orgData['slug']],
                $orgData
            );
        }
    }
}

