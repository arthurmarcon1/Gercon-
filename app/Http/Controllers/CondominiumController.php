<?php

namespace App\Http\Controllers;

use App\Actions\CreateCondominiumAction;
use App\Actions\UpdateCondominiumAction;
use App\Http\Requests\StoreCondominiumRequest;
use App\Http\Requests\UpdateCondominiumRequest;
use App\Models\Condominium;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class CondominiumController extends Controller
{
    public function index(): Response
    {
        $condominiums = Condominium::withCount('units')
            ->orderBy('name')
            ->paginate(15);

        return Inertia::render('Condominiums/Index', [
            'condominiums' => $condominiums,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Condominiums/Create');
    }

    public function store(StoreCondominiumRequest $request, CreateCondominiumAction $action): RedirectResponse
    {
        $action->handle($request->validated());

        return redirect()->route('condominiums.index')
            ->with('success', 'Condomínio criado com sucesso.');
    }

    public function show(Condominium $condominium): Response
    {
        $blocks = $condominium->blocks()
            ->withCount('units')
            ->orderBy('name')
            ->get();

        $units = $condominium->units()
            ->with('block:id,name')
            ->orderBy('number')
            ->paginate(20);

        return Inertia::render('Condominiums/Show', [
            'condominium' => $condominium,
            'blocks'      => $blocks,
            'units'       => $units,
            'unitTypes'   => \App\Models\Unit::TYPES,
        ]);
    }

    public function edit(Condominium $condominium): Response
    {
        return Inertia::render('Condominiums/Edit', [
            'condominium' => $condominium,
        ]);
    }

    public function update(UpdateCondominiumRequest $request, Condominium $condominium, UpdateCondominiumAction $action): RedirectResponse
    {
        $action->handle($condominium, $request->validated());

        return redirect()->route('condominiums.index')
            ->with('success', 'Condomínio atualizado com sucesso.');
    }

    public function destroy(Condominium $condominium): RedirectResponse
    {
        $condominium->delete();

        return redirect()->route('condominiums.index')
            ->with('success', 'Condomínio removido.');
    }
}
