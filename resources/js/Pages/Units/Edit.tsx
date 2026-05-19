import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Block, Condominium, PageProps, Unit } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

interface Props extends PageProps {
    unit: Unit;
    condominium: Condominium;
    blocks: Pick<Block, 'id' | 'name'>[];
    unitTypes: Record<string, string>;
}

export default function Edit({ unit, condominium, blocks, unitTypes }: Props) {
    const form = useForm({
        number: unit.number,
        type: unit.type ?? '',
        floor: unit.floor?.toString() ?? '',
        block_id: unit.block_id?.toString() ?? '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        form.patch(route('units.update', unit.id));
    };

    return (
        <AuthenticatedLayout
            header={
                <div className="flex items-center gap-4">
                    <Link href={route('condominiums.show', condominium.id)} className="text-sm text-gray-500 hover:text-gray-700">
                        ← {condominium.name}
                    </Link>
                    <h2 className="text-xl font-semibold leading-tight text-gray-800">
                        Editar unidade {unit.number}
                    </h2>
                </div>
            }
        >
            <Head title={`Editar unidade ${unit.number}`} />

            <div className="py-12">
                <div className="mx-auto max-w-lg sm:px-6 lg:px-8">
                    <div className="bg-white p-8 shadow-sm sm:rounded-lg">
                        <form onSubmit={submit} className="space-y-6">

                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel htmlFor="number" value="Número" />
                                    <TextInput
                                        id="number"
                                        className="mt-1 block w-full"
                                        value={form.data.number}
                                        onChange={(e) => form.setData('number', e.target.value)}
                                        required
                                        autoFocus
                                    />
                                    <InputError className="mt-2" message={form.errors.number} />
                                </div>

                                <div>
                                    <InputLabel htmlFor="floor" value="Andar (opcional)" />
                                    <TextInput
                                        id="floor"
                                        type="number"
                                        min={0}
                                        className="mt-1 block w-full"
                                        value={form.data.floor}
                                        onChange={(e) => form.setData('floor', e.target.value)}
                                    />
                                    <InputError className="mt-2" message={form.errors.floor} />
                                </div>
                            </div>

                            <div>
                                <InputLabel htmlFor="type" value="Tipo (opcional)" />
                                <select
                                    id="type"
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    value={form.data.type}
                                    onChange={(e) => form.setData('type', e.target.value)}
                                >
                                    <option value="">— Selecionar —</option>
                                    {Object.entries(unitTypes).map(([value, label]) => (
                                        <option key={value} value={value}>{label}</option>
                                    ))}
                                </select>
                                <InputError className="mt-2" message={form.errors.type} />
                            </div>

                            {blocks.length > 0 && (
                                <div>
                                    <InputLabel htmlFor="block_id" value="Bloco (opcional)" />
                                    <select
                                        id="block_id"
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        value={form.data.block_id}
                                        onChange={(e) => form.setData('block_id', e.target.value)}
                                    >
                                        <option value="">— Sem bloco —</option>
                                        {blocks.map((block) => (
                                            <option key={block.id} value={block.id}>{block.name}</option>
                                        ))}
                                    </select>
                                    <InputError className="mt-2" message={form.errors.block_id} />
                                </div>
                            )}

                            <PrimaryButton disabled={form.processing}>Salvar alterações</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
