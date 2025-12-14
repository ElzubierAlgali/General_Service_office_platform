import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';

export default function ServicesIndex({ services = [] }: { services?: any[] }) {
    return (
        <AppLayout>
            <Head title="Services" />
            <div className="space-y-4">
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold">Services</h2>
                    <Link href="#" className="text-sm text-indigo-600">New Service</Link>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {services.length === 0 ? (
                        <div className="p-6 border rounded bg-white">No services yet.</div>
                    ) : (
                        services.map((s: any) => (
                            <div key={s.id} className="p-4 border rounded bg-white">
                                <div className="flex items-center justify-between">
                                    <div>
                                        <div className="text-lg font-medium">{s.name}</div>
                                        <div className="text-sm text-gray-500">{s.code}</div>
                                    </div>
                                    <div className="text-right">
                                        <div className="text-sm font-semibold">${s.price}</div>
                                        <Link href={`/services/${s.id}`} className="text-sm text-indigo-600">Manage</Link>
                                    </div>
                                </div>
                            </div>
                        ))
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
