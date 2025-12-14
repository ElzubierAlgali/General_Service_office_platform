import React from 'react';
import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';

export default function TransactionShow({ transaction = null }: { transaction?: any }) {
    const trackings = transaction?.taskTrackings || [];

    return (
        <AppLayout>
            <Head title={`Transaction ${transaction?.reference_number || ''}`} />

            <div className="space-y-6">
                <div>
                    <h2 className="text-xl font-semibold">{transaction?.reference_number}</h2>
                    <div className="text-sm text-gray-500">Status: {transaction?.status}</div>
                </div>

                <div className="bg-white border rounded p-4">
                    <h3 className="font-medium mb-2">Workflow</h3>
                    <ol className="space-y-3">
                        {trackings.length === 0 ? (
                            <li className="text-sm text-gray-500">No workflow steps.</li>
                        ) : (
                            trackings.map((t: any) => (
                                <li key={t.id} className="flex items-start justify-between">
                                    <div>
                                        <div className="font-medium">{t.task?.name || t.task_id}</div>
                                        <div className="text-sm text-gray-500">{t.status} • Assigned: {t.assigned_to || '—'}</div>
                                    </div>
                                    <div className="text-sm text-gray-500">{t.started_at ? new Date(t.started_at).toLocaleString() : ''}</div>
                                </li>
                            ))
                        )}
                    </ol>
                </div>
            </div>
        </AppLayout>
    );
}
