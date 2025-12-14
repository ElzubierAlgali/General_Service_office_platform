import React, { PropsWithChildren } from 'react';
import { Link } from '@inertiajs/react';

export default function Layout({ children }: PropsWithChildren) {
    return (
        <div className="min-h-screen bg-gray-50">
            <header className="bg-white shadow">
                <div className="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                    <h1 className="text-lg font-semibold text-gray-900">GSO Platform</h1>
                    <nav className="space-x-4">
                        <Link href="/" className="text-sm text-gray-600 hover:text-gray-900">Home</Link>
                        <Link href="/dashboard" className="text-sm text-gray-600 hover:text-gray-900">Dashboard</Link>
                        <Link href="/services" className="text-sm text-gray-600 hover:text-gray-900">Services</Link>
                        <Link href="/transactions" className="text-sm text-gray-600 hover:text-gray-900">Transactions</Link>
                    </nav>
                </div>
            </header>

            <main className="py-8">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white shadow sm:rounded-lg p-6">{children}</div>
                </div>
            </main>
        </div>
    );
}
