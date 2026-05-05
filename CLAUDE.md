# Gercon — Sistema de Gestão de Condomínios

## Contexto

Sistema multi-tenant para a empresa Gercon administrar múltiplos condomínios.
Projeto pessoal/portfólio do Arthur Marcon, desenvolvedor que está saindo de
júnior pra pleno. Foco em código limpo, testado e profissional.

## Stack

- **Backend:** Laravel 12, PHP 8.3, PostgreSQL 16, Redis 7
- **Frontend:** Inertia.js + React 18 + TypeScript + Tailwind CSS
- **Auth:** Laravel Breeze (Inertia/React/TS scaffold)
- **Permissões:** spatie/laravel-permission
- **DTOs:** spatie/laravel-data
- **Testes:** Pest
- **Qualidade:** Larastan, Laravel Pint
- **Filas:** Redis queue
- **Deploy futuro:** VPS Hetzner com nginx + supervisor

## Arquitetura e padrões

- **Multi-tenant por escopo:** cada User pertence a uma ou mais Tenants
  (administradoras). Models filtrados por tenant via Global Scope.
- **Roles e permissões:** super-admin, admin (administradora), sindico, morador.
- **Modelagem principal:**
  - `Tenant` (administradora, ex: Gercon) → muitos Condominium
  - `Condominium` → muitos Block → muitos Unit → muitos Resident
  - `Charge` (cobrança) pertence a Unit, tem status (pending/paid/overdue)
  - `Announcement` (comunicado) pertence a Condominium
  - `Reservation` (reserva de área comum) feita por Resident
  - `Ticket` (chamado) aberto por Resident, respondido por admin/sindico

## Convenções de código

### Backend
- Controllers slim: validação em FormRequest, lógica em Action classes
  (`app/Actions/`), retorno via Inertia render.
- Models com relationships tipadas, casts explícitos, $fillable definido.
- Migrations sempre reversíveis (`down()` implementado).
- Sem facades dentro de actions; injeta dependências via construtor.
- Queries N+1 são bug. Sempre eager load (`with`).
- Nada de `Model::all()` em listas — sempre paginação.

### Frontend
- Componentes em `resources/js/Components/` (reutilizáveis) e
  `resources/js/Pages/` (páginas Inertia).
- TypeScript strict. Nada de `any` sem comentário justificando.
- Forms via `useForm` do Inertia.
- Tipos compartilhados em `resources/js/types/`.

### Geral
- Nomes de variável, função, comentário e commit em **inglês**.
- Strings de UI visíveis ao usuário em **português**.
- Commits no padrão Conventional Commits (`feat:`, `fix:`, `refactor:`,
  `test:`, `docs:`, `chore:`).
- Branch por feature (`feat/charge-creation`), PR pra main.

## Comandos úteis

```bash
# Dev
npm run dev                    # Vite dev server
php artisan serve              # Laravel dev server
php artisan queue:work redis   # processa filas

# Testes e qualidade
./vendor/bin/pest              # roda testes
./vendor/bin/pint              # formata código
./vendor/bin/phpstan analyse   # análise estática

# Migrations
php artisan migrate:fresh --seed   # reseta banco com seed
```

## Decisões importantes

- **Inertia em vez de API REST + SPA:** stack mais produtiva pra app interno,
  reaproveita auth/CSRF do Laravel.
- **PostgreSQL em vez de MySQL:** experiência com banco "mais profissional".
- **UUID como primary key em entidades públicas (Condominium, Unit):**
  evita exposição de IDs sequenciais nas URLs.
- **Multi-tenant single-database:** simples pra MVP, refatora se virar SaaS.

## Fluxo de trabalho com o Claude

- **Eu (Arthur) decido o que fazer.** Você ajuda a executar e questiona
  decisões ruins.
- **Antes de implementar feature complexa**, planeje em conjunto comigo:
  modelagem, endpoints, fluxo. Não saia codando direto.
- **Sempre explique o porquê**, não só o como. Estou aprendendo.
- **Não invente requisitos.** Se algo está ambíguo, pergunte.
- **Não instale package novo sem me perguntar.** Stack enxuta é decisão.
- **Sempre proponha testes** pra novas features.
