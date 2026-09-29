<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SiMakan - Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="bg-orange-500 text-white p-4 shadow">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">🍽️ SiMakan</h1>
            <button onclick="toggleKeranjang()" class="bg-white text-orange-500 px-4 py-2 rounded-full font-semibold">
                🛒 Keranjang (<span id="jumlah-keranjang">0</span>)
            </button>
        </div>
    </div>

    <!-- Daftar Menu -->
    <div class="max-w-4xl mx-auto p-4">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Menu Hari Ini</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($menus as $menu)
            <div class="bg-white rounded-xl shadow p-4">
                <div class="bg-orange-100 rounded-lg h-24 flex items-center justify-center text-4xl mb-3">🍱</div>
                <h3 class="font-bold text-gray-800">{{ $menu->name }}</h3>
                <p class="text-gray-500 text-sm mb-1">{{ $menu->desc }}</p>
                <p class="text-orange-500 font-bold">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                <p class="text-gray-400 text-xs mb-3">⏱ {{ $menu->time }} · Stok: {{ $menu->stock }}</p>
                @if($menu->stock > 0)
                <button onclick='tambahKeranjang({{ json_encode(["id" => $menu->id, "name" => $menu->name, "price" => $menu->price]) }})'
                    class="w-full bg-orange-500 text-white py-2 rounded-lg text-sm font-semibold hover:bg-orange-600">
                    + Pesan
                </button>
                @else
                <button disabled class="w-full bg-gray-300 text-gray-500 py-2 rounded-lg text-sm">Habis</button>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <!-- Panel Keranjang -->
    <div id="panel-keranjang" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="absolute right-0 top-0 h-full w-full max-w-sm bg-white shadow-xl flex flex-col">
            <div class="p-4 bg-orange-500 text-white flex justify-between items-center">
                <h2 class="text-lg font-bold">🛒 Keranjang</h2>
                <button onclick="toggleKeranjang()" class="text-white text-xl">✕</button>
            </div>
            <div class="p-4 mb-2">
                <label class="text-sm text-gray-600">Nama Pemesan</label>
                <input id="nama-pemesan" type="text" placeholder="Masukkan nama kamu..."
                    class="w-full border rounded-lg px-3 py-2 mt-1 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <div id="isi-keranjang" class="flex-1 overflow-y-auto px-4"></div>
            <div class="p-4 border-t">
                <div class="flex justify-between font-bold text-lg mb-3">
                    <span>Total</span>
                    <span class="text-orange-500">Rp <span id="total-harga">0</span></span>
                </div>
                <button onclick="checkout()" class="w-full bg-orange-500 text-white py-3 rounded-xl font-bold hover:bg-orange-600">
                    Pesan Sekarang
                </button>
            </div>
        </div>
    </div>

    <script>
        let keranjang = [];

        function tambahKeranjang(menu) {
            let ada = keranjang.find(i => i.id === menu.id);
            if (ada) { ada.qty++; }
            else { keranjang.push({...menu, qty: 1}); }
            updateKeranjang();
        }

        function updateKeranjang() {
            document.getElementById('jumlah-keranjang').textContent = keranjang.reduce((a, i) => a + i.qty, 0);
            let total = keranjang.reduce((a, i) => a + (i.price * i.qty), 0);
            document.getElementById('total-harga').textContent = total.toLocaleString('id-ID');
            let html = keranjang.map(i => `
                <div class="flex justify-between items-center py-2 border-b">
                    <div>
                        <p class="font-semibold text-sm">${i.name}</p>
                        <p class="text-orange-500 text-sm">Rp ${(i.price).toLocaleString('id-ID')}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="kurangQty(${i.id})" class="bg-gray-200 px-2 rounded">−</button>
                        <span>${i.qty}</span>
                        <button onclick="tambahQty(${i.id})" class="bg-gray-200 px-2 rounded">+</button>
                    </div>
                </div>`).join('');
            document.getElementById('isi-keranjang').innerHTML = html || '<p class="text-gray-400 text-sm text-center mt-8">Keranjang masih kosong</p>';
        }

        function tambahQty(id) { keranjang.find(i => i.id === id).qty++; updateKeranjang(); }
        function kurangQty(id) {
            let item = keranjang.find(i => i.id === id);
            if (item.qty > 1) { item.qty--; } else { keranjang = keranjang.filter(i => i.id !== id); }
            updateKeranjang();
        }

        function toggleKeranjang() {
            document.getElementById('panel-keranjang').classList.toggle('hidden');
        }

        function checkout() {
            let nama = document.getElementById('nama-pemesan').value.trim();
            if (!nama) { alert('Masukkan nama pemesan dulu ya!'); return; }
            if (keranjang.length === 0) { alert('Keranjang masih kosong!'); return; }
            let total = keranjang.reduce((a, i) => a + (i.price * i.qty), 0);
            fetch('/order', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ customer: nama, items: keranjang, total: total })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert('Pesanan berhasil! Kode pesanan kamu: ' + data.order_code);
                    keranjang = [];
                    updateKeranjang();
                    toggleKeranjang();
                }
            });
        }
    </script>
</body>
</html>