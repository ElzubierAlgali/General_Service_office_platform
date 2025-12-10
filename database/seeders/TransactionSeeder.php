<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Organization;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();
        if ($organizations->isEmpty()) {
            $this->call([OrganizationSeeder::class, CustomerSeeder::class, ServiceSeeder::class, UserSeeder::class]);
        }

        $statuses = ['draft', 'submitted', 'in_progress', 'completed', 'cancelled', 'on_hold'];
        $priorities = ['low', 'normal', 'high', 'urgent'];

        foreach ($organizations as $org) {
            $customers = Customer::where('organization_id', $org->id)->get();
            $services = Service::where('organization_id', $org->id)->where('active', true)->get();
            $users = User::where('organization_id', $org->id)->get();

            if ($customers->isEmpty() || $services->isEmpty() || $users->isEmpty()) {
                continue;
            }

            // Create transactions for each organization
            for ($i = 1; $i <= 15; $i++) {
                $customer = $customers->random();
                $service = $services->random();
                $submittedBy = $users->random();
                $assignedTo = $users->random();
                $status = $statuses[array_rand($statuses)];
                $priority = $priorities[array_rand($priorities)];

                $referenceNumber = 'REF-' . $org->id . '-' . str_pad($i, 6, '0', STR_PAD_LEFT) . '-' . date('Y');

                Transaction::firstOrCreate(
                    [
                        'reference_number' => $referenceNumber,
                        'organization_id' => $org->id,
                    ],
                    [
                        'customer_id' => $customer->id,
                        'service_id' => $service->id,
                        'status' => $status,
                        'priority' => $priority,
                        'submitted_by' => $submittedBy->id,
                        'assigned_to' => $assignedTo->id,
                        'submitted_at' => $status !== 'draft' ? now()->subDays(rand(1, 30)) : null,
                        'due_date' => now()->addDays(rand(1, 60)),
                        'completed_at' => $status === 'completed' ? now()->subDays(rand(1, 10)) : null,
                        'metadata' => [
                            'source' => 'web',
                            'notes' => 'ملاحظات إضافية للطلب ' . $i,
                        ],
                    ]
                );
            }
        }
    }
}

