export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export interface Address {
    street: string;
    number: string;
    city: string;
    state: string;
    zip: string;
}

export interface Condominium {
    id: string;
    tenant_id: number;
    name: string;
    address: Address | null;
    document: string | null;
    active: boolean;
    units_count?: number;
    created_at: string;
    updated_at: string;
}

export interface Block {
    id: number;
    condominium_id: string;
    name: string;
    units_count?: number;
}

export interface Unit {
    id: string;
    condominium_id: string;
    block_id: number | null;
    block?: Block | null;
    number: string;
    type: string | null;
    floor: number | null;
}

export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface Paginated<T> {
    data: T[];
    links: PaginationLink[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
};
