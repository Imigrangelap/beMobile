<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        $user = User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'message' => 'User registered',
            'user' => $user->only(['id', 'nama', 'email'])
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user->only(['id', 'nama', 'email'])
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    public function forgetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan.'], 404);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return response()->json(['message' => 'Password berhasil diperbarui.']);
    }

    public function updateUserData(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'noTlp' => 'nullable|min:10|max:15',
            'alamat' => 'nullable|string|min:6',
            'user_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggalLahir' => 'nullable|date',
            'gender' => 'nullable|in:male,female'
        ]);

        if ($request->hasFile('user_foto')) {
            $filename = time() . '_' . $request->file('user_foto')->getClientOriginalName();
            $request->file('user_foto')->storeAs('userImg', $filename, 'public');
            $data['user_foto'] = $filename;
        }

        $user->update($data);

        return response()->json([
            'message' => 'Data pengguna berhasil diperbarui.',
            'user' => $user->only(['id', 'nama', 'email', 'noTlp', 'alamat', 'tanggalLahir', 'gender', 'user_foto'])
        ]);
    }
}
