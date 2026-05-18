import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

interface StatCardProps {
    label: string;
    value: string | number;
    description: string;
}

function StatCard({ label, value, description }: StatCardProps) {
    return (
        <div className="bg-white overflow-hidden shadow-sm rounded-lg p-6">
            <p className="text-sm font-medium text-gray-500">{label}</p>
            <p className="mt-1 text-3xl font-semibold text-gray-900">{value}</p>
            <p className="mt-1 text-sm text-gray-400">{description}</p>
        </div>
    );
}

export default function Dashboard() {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Painel Geral
                </h2>
            }
        >
            <Head title="Painel" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

                    <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        <StatCard
                            label="Condomínios"
                            value="—"
                            description="em gestão"
                        />
                        <StatCard
                            label="Moradores"
                            value="—"
                            description="cadastrados"
                        />
                        <StatCard
                            label="Cobranças pendentes"
                            value="—"
                            description="a vencer"
                        />
                        <StatCard
                            label="Chamados abertos"
                            value="—"
                            description="aguardando resposta"
                        />
                    </div>

                    <div className="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                        <h3 className="text-sm font-medium text-gray-500 mb-4">Início rápido</h3>
                        <p className="text-gray-400 text-sm">
                            Nenhum condomínio cadastrado ainda. Em breve você poderá gerenciar
                            condomínios, unidades, moradores e cobranças por aqui.
                        </p>
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
