<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    public function addmenu(Request $request)
    {
        // Validasi data
        $request->validate([
            'menu' => 'required|string|max:255',
            'icon_menu' => 'required|string|max:255',
        ]);

        // Simpan data ke database
        Menu::create([
            'menu' => $request->menu,
            'icon_menu' => $request->icon_menu,
        ]);

        // Redirect kembali ke halaman menu dengan pesan sukses
        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function editmenu($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    public function editmenu_action(Request $request, $id)
    {
        $request->validate([
            'menu' => 'required|string|max:255',
            'icon_menu' => 'required|string|max:255',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update([
            'menu' => $request->menu,
            'icon_menu' => $request->icon_menu,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function delete($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }

    public function submenu()
    {
        $menuModel = new Menu();
        $subMenus = $menuModel->getSubMenu();
        $menus = Menu::all();

        return view('menu.submenu', compact('subMenus', 'menus'));
    }

    public function addSubMenu(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'menu_id' => 'required|exists:users_menu,id',
            'url' => 'required',
            'is_active' => 'boolean',
        ]);

        DB::table('users_sub_menu')->insert([
            'title' => $request->title,
            'menu_id' => $request->menu_id,
            'url' => $request->url,
            'is_active' => $request->is_active ?? 0,
        ]);

        return redirect()->route('menu.submenu')->with('success', 'Submenu berhasil ditambahkan!');
    }

    public function editSubMenu(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'menu_id' => 'required|exists:users_menu,id',
            'url' => 'required',
            'is_active' => 'nullable|boolean',
        ]);

        DB::table('users_sub_menu')
            ->where('id', $id)
            ->update([
                'title' => $request->title,
                'menu_id' => $request->menu_id,
                'url' => $request->url,
                'is_active' => $request->is_active ?? 0,
            ]);

        return redirect()->route('menu.submenu')->with('success', 'Submenu berhasil diperbarui!');
    }

    public function deleteSubMenu($id)
    {
        DB::table('users_sub_menu')->where('id', $id)->delete();

        return redirect()->route('menu.submenu')->with('success', 'Submenu berhasil dihapus!');
    }


}