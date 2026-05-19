import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import CondominiumForm from '@/Components/CondominiumForm';
import { Condominium, PageProps } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface Props extends PageProps {
    condominium: Condominium;
}

export default function Edit({ condominium }: Props) {
    return (
        <AuthenticatedLayout
            header={
                <div className="flex items-center gap-4">
                    <Link href={route('condominiums.index')} className="text-sm text-gray-500 hover:text-gray-700">
                        ← Condomínios
                    </Link>
                    <h2 className="text-xl font-semibold leading-tight text-gray-800">
                        Editar condomínio
                    </h2>
                </div>
            }
        >
            <Head title="Editar condomínio" />

            <div className="py-12">
                <div className="mx-auto max-w-2xl sm:px-6 lg:px-8">
                    <div className="bg-white p-8 shadow-sm sm:rounded-lg">
                        <CondominiumForm
                            condominium={condominium}
                            submitLabel="Salvar alterações"
                            onSubmit={(form) =>
                                form.patch(route('condominiums.update', condominium.id))
                            }
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
