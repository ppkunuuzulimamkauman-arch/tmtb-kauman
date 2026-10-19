<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    // Daftar akun GT/PJGT — Admin kelola user & kata sandi
    public function index(Request $request)
    {
        $role = $request->query('role');
        $search = $request->query('search');
        $query = User::with('biodata')->whereIn('role', ['gt', 'pjgt'])->orderBy('name');
        if (in_array($role, ['gt', 'pjgt'])) {
            $query->where('role', $role);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $users = $query->paginate(15)->withQueryString();
        $countGt = User::where('role', 'gt')->count();
        $countPjgt = User::where('role', 'pjgt')->count();
        return view('admin.users.index', compact('users', 'role', 'search', 'countGt', 'countPjgt'));
    }

    // Form buat akun GT/PJGT baru
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|in:pjgt,gt',
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, tanda minus dan garis bawah.',
            'username.unique' => 'Username sudah dipakai akun lain.',
            'email.unique' => 'Email sudah dipakai akun lain.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => $validated['password'],
        ]);

        return redirect()->route('users.index')->with('success', 'Akun ' . strtoupper($user->role) . ' ' . $user->name . ' berhasil dibuat.');
    }

    // Form edit user (nama, username, email, role, password opsional)
    public function edit(User $user)
    {
        $this->guardRole($user);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->guardRole($user);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'min:3', 'max:50', 'alpha_dash', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => 'required|in:pjgt,gt',
            'password' => ['nullable', 'confirmed', Password::min(6)],
        ], [
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, tanda minus dan garis bawah.',
            'username.unique' => 'Username sudah dipakai akun lain.',
            'email.unique' => 'Email sudah dipakai akun lain.',
        ]);

        $oldUsername = $user->username;
        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];
        if (!empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }
        $user->update($data);

        if ($oldUsername !== $user->username) {
            Permohonan::where('username', $oldUsername)->update(['username' => $user->username]);
        }

        return redirect()->route('users.index')->with('success', 'Akun ' . $user->name . ' berhasil diperbarui.');
    }

    // Form reset kata sandi
    public function resetForm(User $user)
    {
        $this->guardRole($user);
        return view('admin.users.reset', compact('user'));
    }

    public function reset(Request $request, User $user)
    {
        $this->guardRole($user);
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);
        $user->update(['password' => $validated['password']]);
        return redirect()->route('users.index')->with('success', 'Kata sandi akun ' . $user->username . ' berhasil direset.');
    }

    // Hapus akun GT/PJGT (cascade biodata & absensi)
    public function destroy(User $user)
    {
        $this->guardRole($user);
        if ($user->id === auth()->id()) {
            return back()->withErrors(['msg' => 'Tidak bisa menghapus akun sendiri.']);
        }
        $nama = $user->name;
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Akun ' . $nama . ' beserta biodata & absensinya dihapus.');
    }

    private function guardRole(User $user): void
    {
        if (! in_array($user->role, ['gt', 'pjgt'])) {
            abort(404);
        }
    }
}
