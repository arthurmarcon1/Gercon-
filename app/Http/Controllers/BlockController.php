<?php

namespace App\Http\Controllers;

use App\Actions\CreateBlockAction;
use App\Actions\UpdateBlockAction;
use App\Http\Requests\StoreBlockRequest;
use App\Http\Requests\UpdateBlockRequest;
use App\Models\Block;
use App\Models\Condominium;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class BlockController extends Controller
{
    public function create(Condominium $condominium): Response
    {
        return Inertia::render('Blocks/Create', [
            'condominium' => $condominium,
        ]);
    }

    public function store(StoreBlockRequest $request, Condominium $condominium, CreateBlockAction $action): RedirectResponse
    {
        $action->handle($condominium, $request->validated());

        return redirect()->route('condominiums.show', $condominium)
            ->with('success', 'Bloco criado com sucesso.');
    }

    public function edit(Block $block): Response
    {
        return Inertia::render('Blocks/Edit', [
            'block'       => $block,
            'condominium' => $block->condominium,
        ]);
    }

    public function update(UpdateBlockRequest $request, Block $block, UpdateBlockAction $action): RedirectResponse
    {
        $action->handle($block, $request->validated());

        return redirect()->route('condominiums.show', $block->condominium_id)
            ->with('success', 'Bloco atualizado.');
    }

    public function destroy(Block $block): RedirectResponse
    {
        $condominiumId = $block->condominium_id;
        $block->delete();

        return redirect()->route('condominiums.show', $condominiumId)
            ->with('success', 'Bloco removido.');
    }
}
