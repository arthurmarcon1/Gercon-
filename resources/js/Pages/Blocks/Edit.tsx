import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Block, Condominium, PageProps } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

interface Props extends PageProps {
    block: Block;
    condominium: Condominium;
}

export default function Edit({ block, condominium }: Props) {
    const form = useForm({ name: block.name });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        form.patch(route('blocks.update', block.id));
    };

    return (
        <AuthenticatedLayout
            header={
                <div className="flex items-center gap-4">
                    <Link href={route('condominiums.show', condominium.id)} className="text-sm text-gray-500 hover:text-gray-700">
                        ← {condominium.name}
                    </Link>
                    <h2 className="text-xl font-semibold leading-tight text-gray-800">Editar bloco</h2>
                </div>
            }
        >
            <Head title="Editar bloco" />

            <div className="py-12">
                <div className="mx-auto max-w-md sm:px-6 lg:px-8">
                    <div className="bg-white p-8 shadow-sm sm:rounded-lg">
                        <form onSubmit={submit} className="space-y-6">
                            <div>
                                <InputLabel htmlFor="name" value="Nome do bloco" />
                                <TextInput
                                    id="name"
                                    className="mt-1 block w-full"
                                    value={form.data.name}
                                    onChange={(e) => form.setData('name', e.target.value)}
                                    required
                                    autoFocus
                                />
                                <InputError className="mt-2" message={form.errors.name} />
                            </div>
                            <PrimaryButton disabled={form.processing}>Salvar alterações</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
