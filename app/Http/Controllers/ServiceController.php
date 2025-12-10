<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\Task;
use App\Services\TenantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $organizationId = TenantManager::getOrganizationId();
        
        $query = Service::with('organization');
        
        if ($organizationId) {
            $query->where('organization_id', $organizationId);
        }
        
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }
        
        $services = $query->latest()->paginate(25);
        
        return view('dashboard.services.index', compact('services'));
    }

    public function create(): View
    {
        $organizationId = TenantManager::getOrganizationId();
        $tasks = Task::when($organizationId, function ($q) use ($organizationId) {
            $q->where('organization_id', $organizationId);
        })->orderBy('default_order')->get();
        
        return view('dashboard.services.create', compact('tasks'));
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $organizationId = TenantManager::getOrganizationId();
        
        $service = Service::create([
            'organization_id' => $organizationId,
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'price' => $request->price ?? 0,
            'estimated_duration_days' => $request->estimated_duration_days,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('services.index')
            ->with('success', 'تم إضافة الخدمة بنجاح.');
    }

    public function show(Service $service): View
    {
        $service->load('transactions', 'organization');
        return view('dashboard.services.show', compact('service'));
    }

    public function edit(Service $service): View
    {
        $organizationId = TenantManager::getOrganizationId();
        $tasks = Task::when($organizationId, function ($q) use ($organizationId) {
            $q->where('organization_id', $organizationId);
        })->orderBy('default_order')->get();
        
        return view('dashboard.services.edit', compact('service', 'tasks'));
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $service->update($request->validated());
        $service->active = $request->has('active');
        $service->save();

        return redirect()->route('services.index')
            ->with('success', 'تم تحديث بيانات الخدمة بنجاح.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        if ($service->transactions()->count() > 0) {
            return redirect()->route('services.index')
                ->with('error', 'لا يمكن حذف الخدمة لأنها مرتبطة بمعاملات.');
        }

        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'تم حذف الخدمة بنجاح.');
    }
}

