<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserManagementController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('users/Index', [
            'users' => User::query()
                ->orderBy('username')
                ->get(['id', 'username', 'account_type', 'created_on', 'updated_on']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('users/Create');
    }

    public function store(UserStoreRequest $request): RedirectResponse
    {
        User::create([
            ...$request->safe()->except(['password', 'password_confirmation']),
            'password' => $request->password,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'User account created successfully.']);

        return to_route('users.index');
    }

    public function edit(User $user): Response
    {
        return Inertia::render('users/Edit', [
            'user' => $user->only(['id', 'username', 'account_type']),
        ]);
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $validated = $request->safe()->except(['password', 'password_confirmation']);

        if ($request->filled('password')) {
            $validated['password'] = $request->password;
        }

        $validated['updated_by'] = auth()->id();

        $user->update($validated);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'User account updated successfully.']);

        return to_route('users.index');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ((int) auth()->id() === (int) $user->id) {
            Inertia::flash('toast', ['type' => 'error', 'message' => 'You cannot delete your own account.']);

            return to_route('users.index');
        }

        $user->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'User account deleted successfully.']);

        return to_route('users.index');
    }
}
