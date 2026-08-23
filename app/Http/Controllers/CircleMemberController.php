<?php

namespace App\Http\Controllers;

use App\Models\CircleMember;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CircleMemberController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:circle_members,email'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        CircleMember::create($validated);

        return back()->with('circle_joined', true);
    }
}
