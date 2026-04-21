<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $user = auth()->user();

        return Inertia::render('Dashboard', [
            'canManageUsers' => $user?->account_type === 'admin',
            'canEditCatalog' => in_array($user?->account_type, ['admin', 'staff'], true),
        ]);
    }
}
