<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return Inertia::render('Admin/Users/Index', [
            'users' => $users
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Cannot delete admin users.');
        }

        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
