import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Block, Condominium, Paginated, PageProps, Unit } from '@/types';
import { Head, Link, router } from '@inertiajs/react';

interface Props extends PageProps {
    condominium: Condominium;
    blocks: Block[];
    units: Paginated<Unit>;
    unitTypes: Record<string, string>;
}

export default function Show({ condominium, blocks, units, unitTypes }: Props) {
    function destroyBlock(block: Block) {
        if (!confirm(`Remover bloco "${block.name}"? As unidades vinculadas perderão o bloco.`)) return;
        router.delete(route('blocks.destroy', block.id));
    }

    function destroyUnit(unit: Unit) {
        if (!confirm(`Remover unidade ${unit.number}?`)) return;
        router.delete(route('units.destroy', unit.id));
    }

    return (
        <AuthenticatedLayout
            header={
                <div className="flex items-center gap-4">
                    <Link href={route('condominiums.index')} className="text-sm text-gray-500 hover:text-gray-700">
                        ← Condomínios
                    </Link>
                    <h2 className="text-xl font-semibold leading-tight text-gray-800">
                        {condominium.name}
                    </h2>
                </div>
            }
        >
            <Head title={condominium.name} />

            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">

                    {/* Blocos */}
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                            <h3 className="font-medium text-gray-900">Blocos</h3>
                            <Link
                                href={route('condominiums.blocks.create', condominium.id)}
                                className="rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700"
                            >
                                Novo bloco
                            </Link>
                        </div>

                        {blocks.length === 0 ? (
                            <p className="px-6 py-4 text-sm text-gray-400">Nenhum bloco cadastrado.</p>
                        ) : (
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nome</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Unidades</th>
                                        <th className="px-6 py-3" />
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200 bg-white">
                                    {blocks.map((block) => (
                                        <tr key={block.id} className="hover:bg-gray-50">
                                            <td className="px-6 py-3 font-medium text-gray-900">{block.name}</td>
                                            <td className="px-6 py-3 text-sm text-gray-500">{block.units_count ?? 0}</td>
                                            <td className="px-6 py-3 text-right text-sm">
                                                <Link href={route('blocks.edit', block.id)} className="mr-4 text-indigo-600 hover:text-indigo-900">
                                                    Editar
                                                </Link>
                                                <button onClick={() => destroyBlock(block)} className="text-red-600 hover:text-red-900">
                                                    Remover
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        )}
                    </div>

                    {/* Unidades */}
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                            <h3 className="font-medium text-gray-900">
                                Unidades <span className="ml-2 text-sm font-normal text-gray-400">({units.total})</span>
                            </h3>
                            <Link
                                href={route('condominiums.units.create', condominium.id)}
                                className="rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700"
                            >
                                Nova unidade
                            </Link>
                        </div>

                        {units.data.length === 0 ? (
                            <p className="px-6 py-4 text-sm text-gray-400">Nenhuma unidade cadastrada.</p>
                        ) : (
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Número</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tipo</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Andar</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Bloco</th>
                                        <th className="px-6 py-3" />
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200 bg-white">
                                    {units.data.map((unit) => (
                                        <tr key={unit.id} className="hover:bg-gray-50">
                                            <td className="px-6 py-3 font-medium text-gray-900">{unit.number}</td>
                                            <td className="px-6 py-3 text-sm text-gray-500">{unit.type ? unitTypes[unit.type] : '—'}</td>
                                            <td className="px-6 py-3 text-sm text-gray-500">{unit.floor ?? '—'}</td>
                                            <td className="px-6 py-3 text-sm text-gray-500">{unit.block?.name ?? '—'}</td>
                                            <td className="px-6 py-3 text-right text-sm">
                                                <Link href={route('units.edit', unit.id)} className="mr-4 text-indigo-600 hover:text-indigo-900">
                                                    Editar
                                                </Link>
                                                <button onClick={() => destroyUnit(unit)} className="text-red-600 hover:text-red-900">
                                                    Remover
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        )}

                        {units.last_page > 1 && (
                            <div className="flex justify-center gap-1 px-6 py-4">
                                {units.links.map((link, i) => (
                                    <Link
                                        key={i}
                                        href={link.url ?? '#'}
                                        className={`rounded px-3 py-1 text-sm ${link.active ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'} ${!link.url ? 'cursor-default opacity-40' : ''}`}
                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                    />
                                ))}
                            </div>
                        )}
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
