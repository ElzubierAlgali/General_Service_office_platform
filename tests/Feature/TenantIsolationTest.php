<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Organization;
use App\Models\Role;
use App\Models\Service;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\TransactionTaskTracking;
use App\Models\User;
use App\Services\TenantManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_isolation_for_customers()
    {
        // Create two organizations
        $orgA = Organization::create(['name' => 'Org A', 'subdomain' => 'orga', 'slug' => 'orga']);
        $orgB = Organization::create(['name' => 'Org B', 'subdomain' => 'orgb', 'slug' => 'orgb']);

        // Create user for orgA and act as them
        $userA = User::factory()->create(['organization_id' => $orgA->id]);

        $this->actingAs($userA);

        // Create a customer under orgA
        $customerA = Customer::create([
            'organization_id' => $orgA->id,
            'name' => 'Alice',
            'email' => 'alice@example.com',
        ]);

        // Ensure customer isn't visible to orgB context
        TenantManager::setOrganizationId($orgB->id);

        $this->assertEquals(0, Customer::count());

        // Reset to orgA
        TenantManager::setOrganizationId($orgA->id);
        $this->assertEquals(1, Customer::count());

        TenantManager::setOrganizationId(null);
    }

    public function test_transaction_materializes_workflow_and_tracking_is_scoped()
    {
        $org = Organization::create(['name' => 'Org C', 'subdomain' => 'orgc', 'slug' => 'orgc']);
        $user = User::factory()->create(['organization_id' => $org->id]);

        // Create three tasks for org
        $task1 = Task::create(['organization_id' => $org->id, 'name' => 'Verify Docs', 'code' => 'verify_docs']);
        $task2 = Task::create(['organization_id' => $org->id, 'name' => 'Collect Fee', 'code' => 'collect_fee']);
        $task3 = Task::create(['organization_id' => $org->id, 'name' => 'Issue Certificate', 'code' => 'issue_cert']);

        // Create service with workflow_json referencing the tasks
        $service = Service::create([
            'organization_id' => $org->id,
            'name' => 'Certificate Service',
            'code' => 'cert_service',
            'workflow_json' => ['tasks' => [$task1->id, $task2->id, $task3->id]],
        ]);

        $customer = Customer::create(['organization_id' => $org->id, 'name' => 'Bob']);

        // Create transaction
        $transaction = Transaction::create([
            'organization_id' => $org->id,
            'customer_id' => $customer->id,
            'service_id' => $service->id,
            'reference_number' => 'T-12345',
            'status' => 'submitted',
        ]);

        // Materialize workflow
        $transaction->materializeWorkflow();

        // Assert that three tracking rows were created and scoped to org
        $this->assertEquals(3, TransactionTaskTracking::where('organization_id', $org->id)->where('transaction_id', $transaction->id)->count());

        // Ensure counts are zero if we set a different tenant context
        TenantManager::setOrganizationId($org->id + 1);
        $this->assertEquals(0, TransactionTaskTracking::count());

        TenantManager::setOrganizationId(null);
    }
}
