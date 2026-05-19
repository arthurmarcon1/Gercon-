import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import CondominiumForm from '@/Components/CondominiumForm';
import { PageProps } from '@/types';
import { Head, Link } from '@inertiajs/react';

export default function Create(_props: PageProps) {
    return (
        <AuthenticatedLayout
            header={
                <div className="flex items-center gap-4">
                    <Link href={route('condominiums.index')} className="text-sm text-gray-500 hover:text-gray-700">
                        ← Condomínios
                    </Link>
                    <h2 className="text-xl font-semibold leading-tight text-gray-800">
                        Novo condomínio
                    </h2>
                </div>
            }
        >
            <Head title="Novo condomínio" />

            <div className="py-12">
                <div className="mx-auto max-w-2xl sm:px-6 lg:px-8">
                    <div className="bg-white p-8 shadow-sm sm:rounded-lg">
                        <CondominiumForm
                            submitLabel="Criar condomínio"
                            onSubmit={(form) => form.post(route('condominiums.store'))}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
