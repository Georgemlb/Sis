<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramStoreRequest;
use App\Http\Requests\ProgramUpdateRequest;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProgramController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('programs/Index', [
            'programs' => Program::query()
                ->orderBy('title')
                ->get(['program_id', 'code', 'title', 'years']),
            'canEditCatalog' => in_array(auth()->user()?->account_type, ['admin', 'staff'], true),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('programs/Create');
    }

    public function store(ProgramStoreRequest $request): RedirectResponse
    {
        Program::create($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Program created successfully.']);

        return to_route('programs.index');
    }

    public function edit(Program $program): Response
    {
        return Inertia::render('programs/Edit', [
            'program' => $program,
        ]);
    }

    public function update(ProgramUpdateRequest $request, Program $program): RedirectResponse
    {
        $program->update($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Program updated successfully.']);

        return to_route('programs.index');
    }
}
