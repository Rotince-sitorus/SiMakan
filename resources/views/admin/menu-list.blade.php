<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiMakan - Kelola Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="bg-orange-500 text-white p-4 shadow">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">🍽️ SiMakan — Kelola Menu</h1>
            <div class="flex gap-3">
                <a href="/orders" class="bg-white text-orange-500 px-4 py-2 rounded-full font-semibold text-sm">Pesanan</a>
                <a href="/admin/menu/tambah" class="bg-orange-700 text-white px-4 py-2 rounded-full font-semibold text-sm">+ Tambah Menu</a>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto p-4">

        <!-- Notifikasi -->
        @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Tabel Menu -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-orange-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama Menu</th>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3 text-left">Harga</th>
                        <th class="px-4 py-3 text-left">Waktu</th>
                        <th class="px-4 py-3 text-left">Stok</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($menus as $menu)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $menu->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $menu->category }}</td>
                        <td class="px-4 py-3 text-orange-500 font-semibold">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $menu->time }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $menu->stock }}</td>
                        <td class="px-4 py-3">
                            @if($menu->stock > 0)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Tersedia</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">Habis</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="/admin/menu/{{ $menu->id }}/edit" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-blue-600">Edit</a>
                            <form action="/admin/menu/{{ $menu->id }}" method="POST" onsubmit="return confirm('Yakin hapus menu ini?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>