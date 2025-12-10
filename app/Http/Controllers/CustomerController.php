<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Services\TenantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $organizationId = TenantManager::getOrganizationId();
        
        $query = Customer::with('organization');
        
        if ($organizationId) {
            $query->where('organization_id', $organizationId);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhere('national_id', 'like', '%' . $request->search . '%');
            });
        }
        
        $customers = $query->latest()->paginate(25);
        
        return view('dashboard.customers.index', compact('customers'));
    }

    public function create(): View
    {
        return view('dashboard.customers.create');
    }

    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        $organizationId = TenantManager::getOrganizationId();
        
        Customer::create([
            'organization_id' => $organizationId,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'national_id' => $request->national_id,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'تم إضافة العميل بنجاح.');
    }

    public function show(Customer $customer): View
    {
        $customer->load('transactions', 'invoices', 'organization');
        return view('dashboard.customers.show', compact('customer'));
    }

    public function edit(Customer $customer): View
    {
        return view('dashboard.customers.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer): RedirectResponse
    {
        $customer->update($request->validated());

        return redirect()->route('customers.index')
            ->with('success', 'تم تحديث بيانات العميل بنجاح.');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        if ($customer->transactions()->count() > 0) {
            return redirect()->route('customers.index')
                ->with('error', 'لا يمكن حذف العميل لأنه مرتبط بمعاملات.');
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'تم حذف العميل بنجاح.');
    }
}

