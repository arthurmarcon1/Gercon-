<?php

namespace App\Http\Controllers;

use App\Actions\CreateUnitAction;
use App\Actions\UpdateUnitAction;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Condominium;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UnitController extends Controller
{
    public function create(Condominium $condominium): Response
    {
        return Inertia::render('Units/Create', [
            'condominium' => $condominium,
            'blocks'      => $condominium->blocks()->orderBy('name')->get(['id', 'name']),
            'unitTypes'   => Unit::TYPES,
        ]);
    }

    public function store(StoreUnitRequest $request, Condominium $condominium, CreateUnitAction $action): RedirectResponse
    {
        $action->handle($condominium, $request->validated());

        return redirect()->route('condominiums.show', $condominium)
            ->with('success', 'Unidade criada com sucesso.');
    }

    public function edit(Unit $unit): Response
    {
        return Inertia::render('Units/Edit', [
            'unit'        => $unit->load('block'),
            'condominium' => $unit->condominium,
            'blocks'      => $unit->condominium->blocks()->orderBy('name')->get(['id', 'name']),
            'unitTypes'   => Unit::TYPES,
        ]);
    }

    public function update(UpdateUnitRequest $request, Unit $unit, UpdateUnitAction $action): RedirectResponse
    {
        $action->handle($unit, $request->validated());

        return redirect()->route('condominiums.show', $unit->condominium_id)
            ->with('success', 'Unidade atualizada.');
    }

    public function destroy(Unit $unit): RedirectResponse
    {
        $condominiumId = $unit->condominium_id;
        $unit->delete();

        return redirect()->route('condominiums.show', $condominiumId)
            ->with('success', 'Unidade removida.');
    }
}
