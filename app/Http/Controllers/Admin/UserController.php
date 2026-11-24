<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();
        $roleFilter = $request->string('role')->toString();

        $users = User::query()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')
                        ->orWhere('nim', 'like', '%'.$search.'%');
                });
            })
            ->when(in_array($roleFilter, ['student', 'admin'], true), fn ($query) => $query->where('role', $roleFilter))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
            'roleFilter' => $roleFilter,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(['student', 'admin'])],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($user->is($request->user()) && ($data['role'] !== 'admin' || ! $data['is_active'])) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan atau menurunkan peran akun sendiri.');
        }

        $user->forceFill($data)->save();

        return back()->with('success', 'Data pengguna berhasil diperbarui.');
    }
}
