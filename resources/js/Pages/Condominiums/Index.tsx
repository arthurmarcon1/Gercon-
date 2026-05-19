import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Condominium, Paginated, PageProps } from '@/types';
import { Head, Link, router } from '@inertiajs/react';

interface Props extends PageProps {
    condominiums: Paginated<Condominium>;
}

export default function Index({ condominiums }: Props) {
    function destroy(condominium: Condominium) {
        if (!confirm(`Remover "${condominium.name}"? Esta ação não pode ser desfeita.`)) return;
        router.delete(route('condominiums.destroy', condominium.id));
    }

    return (
        <AuthenticatedLayout
            header={
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800">
                        Condomínios
                    </h2>
                    <Link
                        href={route('condominiums.create')}
                        className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                    >
                        Novo condomínio
                    </Link>
                </div>
            }
        >
            <Head title="Condomínios" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        {condominiums.data.length === 0 ? (
                            <div className="p-12 text-center text-gray-400">
                                Nenhum condomínio cadastrado ainda.
                            </div>
                        ) : (
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nome</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Endereço</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Unidades</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                        <th className="px-6 py-3" />
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200 bg-white">
                                    {condominiums.data.map((condo) => (
                                        <tr key={condo.id} className="hover:bg-gray-50">
                                            <td className="px-6 py-4 font-medium text-gray-900">
                                                <Link href={route('condominiums.show', condo.id)} className="hover:text-indigo-600">
                                                    {condo.name}
                                                </Link>
                                            </td>
                                            <td className="px-6 py-4 text-sm text-gray-500">
                                                {condo.address
                                                    ? `${condo.address.street}, ${condo.address.number} — ${condo.address.city}/${condo.address.state}`
                                                    : '—'}
                                            </td>
                                            <td className="px-6 py-4 text-sm text-gray-500">{condo.units_count ?? 0}</td>
                                            <td className="px-6 py-4">
                                                <span className={`inline-flex rounded-full px-2 text-xs font-semibold leading-5 ${condo.active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600'}`}>
                                                    {condo.active ? 'Ativo' : 'Inativo'}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4 text-right text-sm">
                                                <Link
                                                    href={route('condominiums.edit', condo.id)}
                                                    className="mr-4 text-indigo-600 hover:text-indigo-900"
                                                >
                                                    Editar
                                                </Link>
                                                <button
                                                    onClick={() => destroy(condo)}
                                                    className="text-red-600 hover:text-red-900"
                                                >
                                                    Remover
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        )}
                    </div>

                    {condominiums.last_page > 1 && (
                        <div className="mt-4 flex justify-center gap-1">
                            {condominiums.links.map((link, i) => (
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
        </AuthenticatedLayout>
    );
}
