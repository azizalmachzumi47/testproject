<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role_akses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::all();
        $roles = \App\Models\Role_akses::all();
    
        return view('admin.index', compact('users', 'roles'));
    }

    public function edituser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role_id' => 'required',
        ]);
    
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role_id = $validatedData['role_id'];
    
        // Update password jika ada input baru
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
    
        // Update gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image && file_exists(public_path('images/' . $user->image))) {
                unlink(public_path('images/' . $user->image));
            }
        
            // Simpan gambar baru langsung ke folder 'public/images'
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
        
            // Simpan nama file ke database
            $user->image = $imageName;
        }
        
        $user->save();
    
        return redirect()->route('admin.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Hapus gambar jika ada
        if ($user->image && file_exists(public_path('images/' . $user->image))) {
            unlink(public_path('images/' . $user->image));
        }

        // Hapus user dari database
        $user->delete();

        return redirect()->route('admin.index')->with('success', 'User berhasil dihapus.');
    }

    public function role()
    {
        $roles = Role_akses::all();
        return view('admin.role', compact('roles'));    
    }

    public function addrole(Request $request)
    {
        // Validasi data
        $request->validate([
            'role' => 'required|string|max:255',
        ]);

        // Simpan data ke database
        Role_akses::create([
            'role' => $request->role,
        ]);

        // Redirect kembali ke halaman menu dengan pesan sukses
        return redirect()->route('admin.role')->with('success', 'Role berhasil ditambahkan!');
    }

    public function role_edit($id)
    {
        $roles = Role_akses::findOrFail($id);
        return view('admin.edit', compact('admin'));
    }

    public function role_update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|max:255',
        ]);

        $roles = Role_akses::findOrFail($id);
        $roles->update([
            'role' => $request->role,
        ]);

        return redirect()->route('admin.role')->with('success', 'Role berhasil diperbarui!');
    }

    public function role_delete($id)
    {
        Role_akses::findOrFail($id)->delete();
        return redirect()->route('admin.role')->with('success', 'Role deleted successfully');
    }

    public function roleAccess($id)
    {
        $role = Role_akses::findOrFail($id);
        $menu = Menu::all();
        return view('admin.roleaccess', compact('role', 'menu'));
    }

    public function changeAccess(Request $request)
    {
        $menuId = $request->menuId;
        $roleId = $request->roleId;

        // Cek apakah akses sudah ada
        $access = DB::table('users_access_menu')
            ->where('role_id', $roleId)
            ->where('menu_id', $menuId)
            ->first();

        if ($access) {
            // Jika akses sudah ada, hapus akses
            DB::table('users_access_menu')
                ->where('role_id', $roleId)
                ->where('menu_id', $menuId)
                ->delete();

            return response()->json(['success' => true, 'message' => 'Akses dihapus']);
        } else {
            // Jika akses tidak ada, tambahkan akses
            DB::table('users_access_menu')->insert([
                'role_id' => $roleId,
                'menu_id' => $menuId
            ]);

            return response()->json(['success' => true, 'message' => 'Akses ditambahkan']);
        }
    }

}