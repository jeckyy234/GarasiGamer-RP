@extends('layouts.app')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold">🎮 Sewa PlayStation</h2>
    <form method="POST" action="{{ route('admin.rentals.store') }}" id="rentalForm">
        @csrf
        <div class="mt-5 space-y-4">
            <div>
                <label class="block font-medium">Tipe PS</label>
                <select name="ps_type_id" id="psTypeSelect" class="w-full border p-2 rounded" required>
                    <option value="">-- Pilih Tipe PS --</option>
                    @foreach($psTypes as $ps)
                    <option value="{{ $ps->id }}" data-price="{{ $ps->price_per_hour }}">
                        {{ $ps->name }} (Rp {{ number_format($ps->price_per_hour,0,',','.') }}/jam)
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium">Pilih Unit</label>
                <select name="unit_number" id="unitSelect" class="w-full border p-2 rounded" required disabled>
                    <option value="">-- Pilih PS dulu --</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Nama Customer</label>
                <input type="text" name="customer_name" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block font-medium">Durasi Sewa (Jam)</label>
                <input type="number" name="duration_hours" id="durationHours" step="0.5" min="0.5" class="w-full border p-2 rounded" value="1" required>
            </div>

            <div class="bg-gray-100 p-3 rounded">
                <p class="font-bold">💰 Total Harga: Rp <span id="pricePreview">0</span></p>
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-2 px-5 rounded-lg w-full">
                Buat Transaksi Sewa
            </button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updatePrice() {
        let select = document.getElementById('psTypeSelect');
        let selected = select.options[select.selectedIndex];
        let pricePerHour = parseInt(selected.dataset.price) || 0;
        let hours = parseFloat(document.getElementById('durationHours').value) || 0;
        let total = pricePerHour * hours;
        document.getElementById('pricePreview').innerText = total.toLocaleString('id-ID');
    }

    $('#psTypeSelect').change(function() {
        let psId = $(this).val();
        let unitSelect = $('#unitSelect');
        if (!psId) {
            unitSelect.prop('disabled', true).html('<option value="">-- Pilih PS dulu --</option>');
            updatePrice();
            return;
        }

        $.get('/admin/get-available-units/' + psId, function(data) {
            unitSelect.prop('disabled', false).empty();
            if (data.units.length === 0) {
                unitSelect.append('<option value="">-- Tidak ada unit tersedia --</option>');
                unitSelect.prop('disabled', true);
            } else {
                unitSelect.append('<option value="">-- Pilih Unit --</option>');
                $.each(data.units, function(i, unit) {
                    unitSelect.append($('<option></option>').val(unit.number).text(unit.name));
                });
            }
        }).fail(function() {
            alert('Gagal mengambil data unit. Pastikan route /admin/get-available-units/{id} sudah benar.');
        });
        updatePrice();
    });

    $('#durationHours').on('input', updatePrice);
    updatePrice();
</script>
@endsection
