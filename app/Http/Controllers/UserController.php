<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            // PERBAIKAN: Gunakan query() tanpa ->latest() untuk menghindari error SQL Server
            $data = User::query();

            return DataTables::of($data)
                ->addIndexColumn()
                // Opsional: Jika ingin default sorting tetap yang terbaru (created_at DESC) via Yajra
                ->orderColumn('created_at', '-created_at $1')
                ->addColumn('action', function ($row) {
                    $dataJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');

                    $btn = '<div class="flex justify-end gap-1">';
                    $btn .= '<button type="button" onclick="openModal(\'edit\', '.$dataJson.')" class="w-8 h-8 rounded-full text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors flex items-center justify-center">
                            <i class="fa-solid fa-pen text-[13px]"></i>
                         </button>';
                    $btn .= '<button type="button" onclick="deleteData(\''.$row->id.'\')" class="w-8 h-8 rounded-full text-gray-400 hover:text-rose-600 hover:bg-rose-50 transition-colors flex items-center justify-center">
                            <i class="fa-solid fa-trash text-[13px]"></i>
                         </button>';
                    $btn .= '</div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('user');
    }

    public function store(Request $request)
    {
        $request->validate([
            'provider_code' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'nullable|email|max:255|unique:users,email',
            'role' => 'required|in:provider,admin',
            'is_active' => 'required|boolean',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'provider_code' => $request->provider_code,
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->is_active,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User berhasil ditambahkan!']);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'provider_code' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:provider,admin',
            'is_active' => 'required|boolean',
            'password' => 'nullable|string|min:6',
        ]);

        $user->fill($request->except('password'));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(['message' => 'Data user berhasil diperbarui!']);
    }

    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return response()->json(['message' => 'User berhasil dihapus!']);
    }
}
