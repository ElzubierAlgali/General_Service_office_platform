<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Organization;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();
        if ($organizations->isEmpty()) {
            $this->call([OrganizationSeeder::class, TransactionSeeder::class]);
        }

        $statuses = ['draft', 'issued', 'paid', 'overdue', 'cancelled'];

        foreach ($organizations as $org) {
            $transactions = Transaction::where('organization_id', $org->id)
                ->where('status', 'completed')
                ->with('customer', 'service')
                ->get();

            foreach ($transactions->take(10) as $transaction) {
                $status = $statuses[array_rand($statuses)];
                $invoiceNumber = 'INV-' . $org->id . '-' . str_pad($transaction->id, 6, '0', STR_PAD_LEFT);

                Invoice::firstOrCreate(
                    [
                        'invoice_number' => $invoiceNumber,
                        'organization_id' => $org->id,
                    ],
                    [
                        'transaction_id' => $transaction->id,
                        'customer_id' => $transaction->customer_id,
                        'amount' => $transaction->service->price ?? 1000.00,
                        'currency' => 'SAR',
                        'status' => $status,
                        'issued_at' => in_array($status, ['issued', 'paid', 'overdue']) ? now()->subDays(rand(1, 30)) : null,
                        'due_at' => in_array($status, ['issued', 'overdue']) ? now()->addDays(rand(1, 30)) : null,
                        'paid_at' => $status === 'paid' ? now()->subDays(rand(1, 15)) : null,
                        'notes' => 'فاتورة للخدمة: ' . ($transaction->service->name ?? 'خدمة'),
                        'line_items' => [
                            [
                                'description' => $transaction->service->name ?? 'خدمة',
                                'quantity' => 1,
                                'unit_price' => $transaction->service->price ?? 1000.00,
                                'total' => $transaction->service->price ?? 1000.00,
                            ],
                        ],
                    ]
                );
            }
        }
    }
}

