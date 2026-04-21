<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectStoreRequest;
use App\Http\Requests\SubjectUpdateRequest;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SubjectController extends Controller
{
    public function index(): Response
    {
        $this->authorize('viewAny', Subject::class);

        return Inertia::render('subjects/Index', [
            'subjects' => Subject::query()
                ->orderBy('title')
                ->get(['subject_id', 'code', 'title', 'unit']),
            'canEditCatalog' => in_array(auth()->user()?->account_type, ['admin', 'staff'], true),
        ]);
    }

    public function create(): Response
    {
        $this->authorize('create', Subject::class);

        return Inertia::render('subjects/Create');
    }

    public function store(SubjectStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Subject::class);

        Subject::create($request->validated());

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Subject created successfully.',
        ]);

        return to_route('subjects.index');
    }

    public function edit(Subject $subject): Response
    {
        $this->authorize('update', $subject);

        return Inertia::render('subjects/Edit', [
            'subject' => $subject,
        ]);
    }

    public function update(SubjectUpdateRequest $request, Subject $subject): RedirectResponse
    {
        $this->authorize('update', $subject);

        $subject->update($request->validated());

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Subject updated successfully.',
        ]);

        return to_route('subjects.index');
    }
}
