@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold">Manajemen Tipe PS & Stok</h2>
    <button id="addPsTypeBtn" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-plus"></i> Tambah Tipe PS
    </button>
</div>

<div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3" id="psListContainer">
    @foreach($psTypes as $ps)
    <div class="bg-white rounded-xl shadow p-4">
        <div class="flex justify-between items-start">
            <h3 class="text-xl font-bold">{{ $ps->name }}</h3>
            <button class="deletePsBtn text-red-500 hover:text-red-700" data-id="{{ $ps->id }}">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
        <div class="mt-2">
            <label class="text-sm">Harga/jam (Rp)</label>
            <input type="number" class="priceInput border rounded w-full p-1 mt-1" data-id="{{ $ps->id }}" value="{{ $ps->price_per_hour }}">
        </div>
        <div class="mt-2">
            <label class="text-sm">Total Unit</label>
            <div class="flex items-center gap-2">
                <button class="decUnit bg-gray-300 px-2 rounded" data-id="{{ $ps->id }}">-</button>
                <span id="unitVal_{{ $ps->id }}" class="font-bold w-8 text-center">{{ $ps->total_units }}</span>
                <button class="incUnit bg-gray-300 px-2 rounded" data-id="{{ $ps->id }}">+</button>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                Aktif digunakan: {{ $ps->active_rentals ?? 0 }} |
                Tersedia: {{ $ps->total_units - ($ps->active_rentals ?? 0) }}
            </p>
        </div>
        <div class="mt-3">
            <button class="updatePsBtn bg-emerald-600 text-white text-sm py-1 px-3 rounded" data-id="{{ $ps->id }}">
                Simpan Perubahan
            </button>
        </div>
    </div>
    @endforeach
</div>

<form id="addPsForm" class="hidden" method="POST" action="{{ route('admin.ps-types.store') }}">
    @csrf
    <input type="hidden" name="name" id="newPsName">
    <input type="hidden" name="price_per_hour" id="newPsPrice">
    <input type="hidden" name="total_units" id="newPsUnits">
</form>

<script>
    // Handle add PS
    document.getElementById('addPsTypeBtn')?.addEventListener('click', function() {
        let name = prompt('Nama tipe PS (contoh: PS2)');
        if(!name) return;
        let price = prompt('Harga per jam (Rp)');
        if(!price) return;
        let units = prompt('Jumlah unit');
        if(!units) return;
        document.getElementById('newPsName').value = name;
        document.getElementById('newPsPrice').value = price;
        document.getElementById('newPsUnits').value = units;
        document.getElementById('addPsForm').submit();
    });

    // Handle update price dan units via AJAX atau form submission? Kita pakai form biasa biar mudah.
    // Tapi karena controller update menggunakan method PUT, kita perlu buat form per item.
    // Alternatif: buat form untuk setiap PS dengan method POST dan spoofing PUT.
    // Agar simple, kita ubah sedikit: setiap kartu memiliki form terpisah.
</script>

<!-- Untuk keperluan update, lebih baik render form terpisah -->
@foreach($psTypes as $ps)
<form method="POST" action="{{ route('admin.ps-types.update', $ps->id) }}" class="hidden updateForm-{{ $ps->id }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="price_per_hour" class="updatePrice-{{ $ps->id }}">
    <input type="hidden" name="total_units" class="updateUnits-{{ $ps->id }}">
</form>
@endforeach

<script>
    // Event listener untuk update
    document.querySelectorAll('.updatePsBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            let psId = this.dataset.id;
            let price = document.querySelector(`.priceInput[data-id="${psId}"]`).value;
            let units = document.getElementById(`unitVal_${psId}`).innerText;
            document.querySelector(`.updatePrice-${psId}`).value = price;
            document.querySelector(`.updateUnits-${psId}`).value = units;
            document.querySelector(`.updateForm-${psId}`).submit();
        });
    });

    document.querySelectorAll('.incUnit').forEach(btn => {
        btn.addEventListener('click', function() {
            let psId = this.dataset.id;
            let span = document.getElementById(`unitVal_${psId}`);
            let val = parseInt(span.innerText);
            span.innerText = val + 1;
        });
    });
    document.querySelectorAll('.decUnit').forEach(btn => {
        btn.addEventListener('click', function() {
            let psId = this.dataset.id;
            let span = document.getElementById(`unitVal_${psId}`);
            let val = parseInt(span.innerText);
            if(val > 1) span.innerText = val - 1;
            else alert('Minimal 1 unit');
        });
    });
</script>
@endsection
