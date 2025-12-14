import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';

export default function TransactionsIndex({ transactions = [] }: { transactions?: any[] }) {
    return (
        <AppLayout>
            <Head title="Transactions" />

            <div className="space-y-4">
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold">Transactions</h2>
                    <Link href="#" className="text-sm text-indigo-600">New Transaction</Link>
                </div>

                <div className="divide-y bg-white rounded border">
                    {transactions.length === 0 ? (
                        <div className="p-6">No transactions yet.</div>
                    ) : (
                        transactions.map((t: any) => (
                            <div key={t.id} className="p-4 flex items-center justify-between">
                                <div>
                                    <div className="font-medium">{t.reference_number}</div>
                                    <div className="text-sm text-gray-500">{t.status} • {t.customer?.name}</div>
                                </div>
                                <div className="flex items-center gap-4">
                                    <Link href={`/transactions/${t.id}`} className="text-sm text-indigo-600">View</Link>
                                    <div className="text-sm text-gray-600">{t.created_at}</div>
                                </div>
                            </div>
                        ))
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
