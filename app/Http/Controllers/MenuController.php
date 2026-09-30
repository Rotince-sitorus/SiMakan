<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    // Halaman menu mahasiswa
    public function index()
    {
        $menus = DB::table('menus')->get();
        return view('menu', compact('menus'));
    }

    // Halaman daftar menu admin
    public function adminIndex()
    {
        $menus = DB::table('menus')->get();
        return view('admin.menu-list', compact('menus'));
    }

    // Halaman form tambah menu
    public function create()
    {
        return view('admin.menu-form', ['menu' => null]);
    }

    // Simpan menu baru
    public function store(Request $request)
    {
        DB::table('menus')->insert([
            'name'       => $request->name,
            'desc'       => $request->desc,
            'price'      => $request->price,
            'time'       => $request->time,
            'category'   => $request->category,
            'stock'      => $request->stock,
            'image'      => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect('/admin/menu')->with('success', 'Menu berhasil ditambahkan!');
    }

    // Halaman form edit menu
    public function edit($id)
    {
        $menu = DB::table('menus')->where('id', $id)->first();
        return view('admin.menu-form', compact('menu'));
    }

    // Update menu
    public function update(Request $request, $id)
    {
        DB::table('menus')->where('id', $id)->update([
            'name'       => $request->name,
            'desc'       => $request->desc,
            'price'      => $request->price,
            'time'       => $request->time,
            'category'   => $request->category,
            'stock'      => $request->stock,
            'updated_at' => now(),
        ]);
        return redirect('/admin/menu')->with('success', 'Menu berhasil diupdate!');
    }

    // Hapus menu
    public function destroy($id)
    {
        DB::table('menus')->where('id', $id)->delete();
        return redirect('/admin/menu')->with('success', 'Menu berhasil dihapus!');
    }
}