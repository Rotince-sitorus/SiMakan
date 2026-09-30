<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiMakan - Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="bg-orange-500 text-white p-4 shadow">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">🍽️ SiMakan — Dashboard Admin</h1>
            <a href="/menu" class="bg-white text-orange-500 px-4 py-2 rounded-full font-semibold text-sm">Lihat Menu</a>
        </div>
    </div>

    <!-- Daftar Pesanan -->
    <div class="max-w-5xl mx-auto p-4">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Pesanan Masuk</h2>

        @if($orders->isEmpty())
            <div class="bg-white rounded-xl shadow p-8 text-center text-gray-400">
                Belum ada pesanan masuk.
            </div>
        @else
        <div class="space-y-4">
            @foreach($orders as $order)
            @php $items = json_decode($order->items, true); @endphp
            <div class="bg-white rounded-xl shadow p-4">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="font-bold text-gray-800 text-lg">{{ $order->customer }}</p>
                        <p class="text-gray-400 text-sm">{{ $order->order_code }}</p>
                        <p class="text-gray-400 text-xs">{{ $order->created_at }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        @if($order->status == 'Menunggu') bg-yellow-100 text-yellow-700
                        @elseif($order->status == 'Sedang Disiapkan') bg-blue-100 text-blue-700
                        @elseif($order->status == 'Siap Diambil') bg-green-100 text-green-700
                        @else bg-gray-100 text-gray-500 @endif">
                        {{ $order->status }}
                    </span>
                </div>

                <!-- Item Pesanan -->
                <div class="border-t pt-3 mb-3">
                    @foreach($items as $item)
                    <div class="flex justify-between text-sm text-gray-600 py-1">
                        <span>{{ $item['name'] }} × {{ $item['qty'] }}</span>
                        <span>Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center border-t pt-3">
                    <p class="font-bold text-orange-500">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</p>

                    <!-- Tombol Update Status -->
                    <div class="flex gap-2">
                        @if($order->status == 'Menunggu')
                        <form action="/order/{{ $order->id }}/status" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Sedang Disiapkan">
                            <button class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600">Proses</button>
                        </form>
                        @elseif($order->status == 'Sedang Disiapkan')
                        <form action="/order/{{ $order->id }}/status" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Siap Diambil">
                            <button class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-600">Siap Diambil</button>
                        </form>
                        @elseif($order->status == 'Siap Diambil')
                        <form action="/order/{{ $order->id }}/status" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Selesai">
                            <button class="bg-gray-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-gray-600">Selesai</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</body>
</html>