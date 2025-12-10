<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
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

        $cities = ['الرياض', 'جدة', 'الدمام', 'المدينة المنورة', 'أبها', 'الطائف'];
        $countries = ['السعودية', 'الإمارات', 'الكويت', 'قطر', 'البحرين'];

        foreach ($organizations as $org) {
            // Create 20 customers per organization
            for ($i = 1; $i <= 20; $i++) {
                Customer::firstOrCreate(
                    [
                        'name' => "عميل {$i} - {$org->name}",
                        'organization_id' => $org->id,
                        'national_id' => $org->id . str_pad($i, 6, '0', STR_PAD_LEFT),
                    ],
                    [
                        'email' => "customer{$i}@{$org->slug}.com",
                        'phone' => '05' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                        'national_id' => $org->id . str_pad($i, 6, '0', STR_PAD_LEFT),
                        'address' => "شارع " . rand(1, 100) . "، حي " . ['الشمال', 'الجنوب', 'الشرق', 'الغرب', 'الوسط'][array_rand(['الشمال', 'الجنوب', 'الشرق', 'الغرب', 'الوسط'])],
                        'city' => $cities[array_rand($cities)],
                        'state' => ['المنطقة الوسطى', 'منطقة مكة المكرمة', 'المنطقة الشرقية'][array_rand(['المنطقة الوسطى', 'منطقة مكة المكرمة', 'المنطقة الشرقية'])],
                        'postal_code' => str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
                        'country' => $countries[array_rand($countries)],
                    ]
                );
            }
        }
    }
}

