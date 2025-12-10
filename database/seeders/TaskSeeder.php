<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
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

        $tasks = [
            [
                'name' => 'مراجعة المستندات',
                'code' => 'review_documents',
                'description' => 'مراجعة المستندات المطلوبة للتأكد من صحتها',
                'default_order' => 1,
                'required' => true,
                'actor_role' => 'staff',
            ],
            [
                'name' => 'التحقق من البيانات',
                'code' => 'verify_data',
                'description' => 'التحقق من صحة البيانات المقدمة',
                'default_order' => 2,
                'required' => true,
                'actor_role' => 'manager',
            ],
            [
                'name' => 'الموافقة النهائية',
                'code' => 'final_approval',
                'description' => 'الموافقة النهائية على الطلب',
                'default_order' => 3,
                'required' => true,
                'actor_role' => 'administrator',
            ],
            [
                'name' => 'إصدار الشهادة',
                'code' => 'issue_certificate',
                'description' => 'إصدار الشهادة أو الترخيص المطلوب',
                'default_order' => 4,
                'required' => true,
                'actor_role' => 'staff',
            ],
            [
                'name' => 'إشعار العميل',
                'code' => 'notify_customer',
                'description' => 'إشعار العميل بنتيجة الطلب',
                'default_order' => 5,
                'required' => false,
                'actor_role' => 'staff',
            ],
            [
                'name' => 'إرسال الوثائق',
                'code' => 'send_documents',
                'description' => 'إرسال الوثائق للعميل',
                'default_order' => 6,
                'required' => false,
                'actor_role' => 'staff',
            ],
        ];

        foreach ($organizations as $org) {
            foreach ($tasks as $taskData) {
                Task::firstOrCreate(
                    [
                        'code' => $taskData['code'],
                        'organization_id' => $org->id,
                    ],
                    array_merge($taskData, [
                        'organization_id' => $org->id,
                    ])
                );
            }
        }
    }
}

