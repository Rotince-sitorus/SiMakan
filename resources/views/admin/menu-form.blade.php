<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiMakan - {{ $menu ? 'Edit' : 'Tambah' }} Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="bg-orange-500 text-white p-4 shadow">
        <div class="max-w-2xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">🍽️ {{ $menu ? 'Edit Menu' : 'Tambah Menu' }}</h1>
            <a href="/admin/menu" class="bg-white text-orange-500 px-4 py-2 rounded-full font-semibold text-sm">← Kembali</a>
        </div>
    </div>

    <div class="max-w-2xl mx-auto p-4">
        <div class="bg-white rounded-xl shadow p-6">
            <form action="{{ $menu ? '/admin/menu/'.$menu->id : '/admin/menu' }}" method="POST">
                @csrf
                @if($menu) @method('PUT') @endif

                <!-- Nama Menu -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Menu</label>
                    <input type="text" name="name" value="{{ $menu->name ?? '' }}" required
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        placeholder="contoh: Nasi Ayam Geprek">
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="desc" rows="3"
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        placeholder="Deskripsi singkat menu...">{{ $menu->desc ?? '' }}</textarea>
                </div>

                <!-- Harga & Waktu -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ $menu->price ?? '' }}" required
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                            placeholder="contoh: 12000">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu Penyajian</label>
                        <input type="text" name="time" value="{{ $menu->time ?? '' }}"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                            placeholder="contoh: 10 Menit">
                    </div>
                </div>

                <!-- Kategori & Stok -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                        <select name="category" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
                            @foreach(['Makanan Utama', 'Camilan', 'Minuman', 'Dessert'] as $cat)
                                <option value="{{ $cat }}" {{ isset($menu) && $menu->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Stok</label>
                        <input type="number" name="stock" value="{{ $menu->stock ?? 0 }}" required min="0"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                            placeholder="contoh: 20">
                        <p class="text-xs text-gray-400 mt-1">Isi 0 jika menu habis</p>
                    </div>
                </div>

                <button type="submit" class="w-full bg-orange-500 text-white py-3 rounded-xl font-bold hover:bg-orange-600">
                    {{ $menu ? 'Simpan Perubahan' : 'Tambah Menu' }}
                </button>
            </form>
        </div>
    </div>
</body>
</html>