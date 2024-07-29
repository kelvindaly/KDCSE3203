<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Zone;

class UserController extends Controller
{
    // Show the form for creating a new user
    public function create()
    {
        return view('manager.users.create');
    }

    // Store a newly created user in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|string|in:manager,driver,warehouse_staff,customer',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('manager.users.create')->with('success', 'User added successfully.');
    }
// List all users
public function index()
{
    $users = User::all();
    return view('manager.users.index', compact('users'));
}

// Show a single user
public function show(User $user)
{
    return view('manager.users.show', compact('user'));
}

 // Edit user form
 public function edit(User $user)
 {
     $zones = Zone::all(); // Fetch all zones from the database
     return view('manager.users.edit', compact('user', 'zones'));
 }

// Update user information
public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'telephone' => 'nullable|string|max:20',
        'role' => 'required|string|in:manager,driver,warehouse_staff,customer',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->telephone = $request->telephone;
    $user->role = $request->role;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}


}
