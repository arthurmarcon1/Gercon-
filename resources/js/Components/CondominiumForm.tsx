import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Condominium } from '@/types';
import { useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

type FormData = {
    name: string;
    address: {
        street: string;
        number: string;
        city: string;
        state: string;
        zip: string;
    };
    document: string;
    active: boolean;
};

interface Props {
    condominium?: Condominium;
    onSubmit: (form: ReturnType<typeof useForm<FormData>>) => void;
    submitLabel: string;
}

export default function CondominiumForm({ condominium, onSubmit, submitLabel }: Props) {
    const form = useForm<FormData>({
        name: condominium?.name ?? '',
        address: {
            street: condominium?.address?.street ?? '',
            number: condominium?.address?.number ?? '',
            city: condominium?.address?.city ?? '',
            state: condominium?.address?.state ?? '',
            zip: condominium?.address?.zip ?? '',
        },
        document: condominium?.document ?? '',
        active: condominium?.active ?? true,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        onSubmit(form);
    };

    return (
        <form onSubmit={submit} className="space-y-6">
            <div>
                <InputLabel htmlFor="name" value="Nome" />
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

            <fieldset className="space-y-4">
                <legend className="text-sm font-medium text-gray-700">Endereço</legend>

                <div className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div className="sm:col-span-2">
                        <InputLabel htmlFor="street" value="Rua / Avenida" />
                        <TextInput
                            id="street"
                            className="mt-1 block w-full"
                            value={form.data.address.street}
                            onChange={(e) => form.setData('address', { ...form.data.address, street: e.target.value })}
                            required
                        />
                        <InputError className="mt-2" message={form.errors['address.street']} />
                    </div>

                    <div>
                        <InputLabel htmlFor="number" value="Número" />
                        <TextInput
                            id="number"
                            className="mt-1 block w-full"
                            value={form.data.address.number}
                            onChange={(e) => form.setData('address', { ...form.data.address, number: e.target.value })}
                            required
                        />
                        <InputError className="mt-2" message={form.errors['address.number']} />
                    </div>
                </div>

                <div className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div className="sm:col-span-2">
                        <InputLabel htmlFor="city" value="Cidade" />
                        <TextInput
                            id="city"
                            className="mt-1 block w-full"
                            value={form.data.address.city}
                            onChange={(e) => form.setData('address', { ...form.data.address, city: e.target.value })}
                            required
                        />
                        <InputError className="mt-2" message={form.errors['address.city']} />
                    </div>

                    <div>
                        <InputLabel htmlFor="state" value="Estado (UF)" />
                        <TextInput
                            id="state"
                            className="mt-1 block w-full uppercase"
                            maxLength={2}
                            value={form.data.address.state}
                            onChange={(e) => form.setData('address', { ...form.data.address, state: e.target.value.toUpperCase() })}
                            required
                        />
                        <InputError className="mt-2" message={form.errors['address.state']} />
                    </div>
                </div>

                <div className="sm:w-48">
                    <InputLabel htmlFor="zip" value="CEP" />
                    <TextInput
                        id="zip"
                        className="mt-1 block w-full"
                        placeholder="00000-000"
                        value={form.data.address.zip}
                        onChange={(e) => form.setData('address', { ...form.data.address, zip: e.target.value })}
                        required
                    />
                    <InputError className="mt-2" message={form.errors['address.zip']} />
                </div>
            </fieldset>

            <div className="sm:w-64">
                <InputLabel htmlFor="document" value="CNPJ (opcional)" />
                <TextInput
                    id="document"
                    className="mt-1 block w-full"
                    placeholder="00.000.000/0000-00"
                    value={form.data.document}
                    onChange={(e) => form.setData('document', e.target.value)}
                />
                <InputError className="mt-2" message={form.errors.document} />
            </div>

            <div className="flex items-center gap-3">
                <input
                    id="active"
                    type="checkbox"
                    className="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    checked={form.data.active}
                    onChange={(e) => form.setData('active', e.target.checked)}
                />
                <InputLabel htmlFor="active" value="Condomínio ativo" />
            </div>

            <div className="flex items-center gap-4">
                <PrimaryButton disabled={form.processing}>{submitLabel}</PrimaryButton>
            </div>
        </form>
    );
}
