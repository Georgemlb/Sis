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
        $this->authorize('viewAny', User::class);

        return Inertia::render('users/Index', [
            'users' => User::query()
                ->orderBy('username')
                ->get(['id', 'username', 'account_type', 'created_on', 'updated_on'])
                ->map(fn (User $user): array => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'account_type' => $user->account_type,
                    'created_on' => $user->created_on?->format('Y/m/d H:i'),
                    'updated_on' => $user->updated_on?->format('Y/m/d H:i'),
                ]),
        ]);
    }

    public function create(): Response
    {
        $this->authorize('create', User::class);

        return Inertia::render('users/Create');
    }

    public function store(UserStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

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
        $this->authorize('update', $user);

        return Inertia::render('users/Edit', [
            'user' => $user->only(['id', 'username', 'account_type']),
        ]);
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

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
        $this->authorize('delete', $user);

        $user->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'User account deleted successfully.']);

        return to_route('users.index');
    }
}
