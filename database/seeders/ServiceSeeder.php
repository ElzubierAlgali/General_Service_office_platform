<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();
        if ($organizations->isEmpty()) {
            $this->call(OrganizationSeeder::class);
            $organizations = Organization::all();
        }

        $services = [
            [
                'name' => 'ترخيص تجاري',
                'code' => 'business_license',
                'description' => 'خدمة الحصول على الترخيص التجاري لممارسة النشاط التجاري',
                'price' => 5000.00,
                'estimated_duration_days' => 30,
            ],
            [
                'name' => 'رخصة بناء',
                'code' => 'building_permit',
                'description' => 'خدمة الحصول على رخصة البناء للمشاريع العقارية',
                'price' => 10000.00,
                'estimated_duration_days' => 45,
            ],
            [
                'name' => 'تسجيل علامة تجارية',
                'code' => 'trademark_registration',
                'description' => 'خدمة تسجيل العلامة التجارية وحماية الملكية الفكرية',
                'price' => 3000.00,
                'estimated_duration_days' => 60,
            ],
            [
                'name' => 'استشارة قانونية',
                'code' => 'legal_consultation',
                'description' => 'خدمة الاستشارة القانونية في مختلف المجالات',
                'price' => 1500.00,
                'estimated_duration_days' => 7,
            ],
            [
                'name' => 'فحص فني',
                'code' => 'technical_inspection',
                'description' => 'خدمة الفحص الفني للمركبات والمعدات',
                'price' => 500.00,
                'estimated_duration_days' => 3,
            ],
            [
                'name' => 'شهادة صحية',
                'code' => 'health_certificate',
                'description' => 'خدمة الحصول على الشهادة الصحية للمؤسسات الغذائية',
                'price' => 2000.00,
                'estimated_duration_days' => 14,
            ],
            [
                'name' => 'تصريح عمل',
                'code' => 'work_permit',
                'description' => 'خدمة الحصول على تصريح العمل للعمالة الوافدة',
                'price' => 2500.00,
                'estimated_duration_days' => 21,
            ],
            [
                'name' => 'شهادة منشأ',
                'code' => 'certificate_of_origin',
                'description' => 'خدمة الحصول على شهادة المنشأ للصادرات',
                'price' => 800.00,
                'estimated_duration_days' => 5,
            ],
        ];

        foreach ($organizations as $org) {
            foreach ($services as $serviceData) {
                Service::firstOrCreate(
                    [
                        'code' => $serviceData['code'],
                        'organization_id' => $org->id,
                    ],
                    array_merge($serviceData, [
                        'organization_id' => $org->id,
                        'active' => true,
                    ])
                );
            }
        }
    }
}

