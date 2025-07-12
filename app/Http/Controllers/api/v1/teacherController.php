<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponses;

class TeacherController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $teachers = User::teachers()->select('id', 'name', 'email', 'phone', 'created_at')->get();

        return $this->ok('Teachers fetched.', $teachers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
        ]);

        return $this->ok('Teacher created.', $user);
    }

    public function show($id)
    {
        $user = User::teachers()->findOrFail($id);

        return $this->ok('Teacher details.', $user);
    }

    public function update(Request $request, $id)
    {
        $user = User::teachers()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->update([
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'] ?? $user->email,
            'phone' => $validated['phone'] ?? $user->phone,
            'password' => isset($validated['password']) ? Hash::make($validated['password']) : $user->password,
        ]);

        return $this->ok('Teacher updated.', $user);
    }

    public function destroy($id)
    {
        $user = User::teachers()->findOrFail($id);

        $user->delete();

        return $this->ok('Teacher deleted.');
    }
}
