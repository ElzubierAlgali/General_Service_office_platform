<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use App\Models\Role;
use App\Services\TenantManager;
use Illuminate\Http\Request;

class DashController extends Controller
{
    public function index(Request $request)
    {
        $organizationId = TenantManager::getOrganizationId();
        
        $stats = [
            'customers_count' => Customer::when($organizationId, function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            })->count(),
            'services_count' => Service::when($organizationId, function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            })->where('active', true)->count(),
            'users_count' => User::when($organizationId, function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            })->count(),
            'roles_count' => Role::when($organizationId, function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            })->count(),
        ];
        
        return view('dashboard', $stats);
    }
}
