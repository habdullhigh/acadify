import FormCard from '@/components/FormCard';
import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import axios from 'axios';
import { useEffect, useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
    },
];

export default function Dashboard() {
    const [forms, setForms] = useState<any[]>([]);
    const [reciepts, setReciepts] = useState<any[]>([]);
    const [loading, setLoading] = useState(true);

    const getAllSubmissions = async () => {
        try {
            const response = await axios.get(route('submissions.admin'), {
                params: {
                    filter: 'all',
                },
            });
            console.log('Submissions', response.data);
            setForms(response.data.forms);
            setReciepts(response.data.reciepts);
        } catch (error) {
            console.error('Error fetching forms:', error);
        }
    };

    useEffect(() => {
        getAllSubmissions();
    }, []);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Admin Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                    <h1>All Submissions</h1>
                    <div className="flex-row items-center justify-between">
                        <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                            <h2 className="p-2 font-semibold">Forms</h2>
                            <div className="grid grid-cols-1 gap-4 p-6 md:grid-cols-2 lg:grid-cols-3">
                                {forms.map((form) => (
                                    <FormCard
                                        key={form.id}
                                        id={form.id}
                                        title={form.title}
                                        status={form.status}
                                        description={form.description}
                                        created={form.created}
                                        link={form.link}
                                        target_office={form.target_office}
                                        rejectionReason={form.rejection_reason} // if available
                                        type="Form"
                                    />
                                ))}
                            </div>
                        </div>

                        <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                            <h2 className="p-2 font-semibold">Receipts</h2>
                            <div className="grid grid-cols-1 gap-4 p-6 md:grid-cols-2 lg:grid-cols-3">
                                {reciepts.map((reciept) => (
                                    <FormCard
                                        key={reciept.id}
                                        id={reciept.id}
                                        title={reciept.title}
                                        status={reciept.status}
                                        description={reciept.description}
                                        created={reciept.created}
                                        link={reciept.link}
                                        target_office={reciept.target_office}
                                        type="Reciept"
                                        // if available
                                    />
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                    <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                </div>
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                    <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                </div>
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                    <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                </div>
            </div>
        </AppLayout>
    );
}
