<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role; 
use Illuminate\Support\Arr; 

class UserController extends Controller
{
    /**
     * Menampilkan daftar user.
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10); 
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat user baru.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all(); 
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            
            // PERBAIKAN: Tambahkan 'unique' agar tidak ada nomor HP ganda saat buat baru
            // Di method store()
            'phone_number' => [
                'required', 
                'numeric',                 // Pastikan format angka
                'digits_between:10,15',    // Panjang minimal 10, maksimal 15 digit
                'regex:/^[0-9]+$/',        // Wajib angka 0-9, dilarang simbol (+, -, ., spasi, dll)
                'unique:'.User::class
            ],
                        
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => ['required', 'string'], 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number, 
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->input('roles'));

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil dibuat.');
    }

    /**
     * Menampilkan detail user (opsional).
     */
    public function show(User $user)
    {
        return redirect()->route('admin.users.index');
    }

    /**
     * Menampilkan form untuk mengedit user.
     */
    public function edit(User $user) 
    {
        $roles = Role::pluck('name', 'name')->all(); 
        $userRole = $user->roles->pluck('name', 'name')->first(); 

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Memperbarui data user di database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Abaikan validasi unik email untuk user ini sendiri
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$user->id], 
            
            // PERBAIKAN: Validasi unik No HP, TAPI abaikan untuk user yang sedang diedit ini
            // Format: unique:table,column,except,idColumn
            'phone_number' => [
                'required', 
                'numeric', 
                'digits_between:10,15', 
                'regex:/^[0-9]+$/', 
                'unique:'.User::class.',phone_number,'.$user->id
            ],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], 
            'roles' => ['required', 'string'], 
        ]);

        $input = $request->except(['password', 'password_confirmation']);
        
        if(empty($input['password'])){
            $input = Arr::except($input, array('password'));
        } else {
            $input['password'] = Hash::make($input['password']); 
        }

        $user->update($input);
        $user->syncRoles($request->input('roles'));

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Menghapus user dari database.
     */
    public function destroy(User $user)
    {
        if (auth()->user()->id == $user->id) {
             return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil dihapus.');
    }
}