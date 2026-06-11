@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded-xl shadow mb-6">
    <form method="GET" action="{{ route('admin.rentals.history') }}" class="flex flex-wrap gap-3 items-end">
        <div><label>Filter Tanggal</label><input type="date" name="date" class="border rounded p-1" value="{{ request('date') }}"></div>
        <div><label>Filter Jam</label><select name="hour" class="border rounded p-1"><option value="">Semua</option>@for($i=0;$i<24;$i++)<option value="{{ $i }}" {{ request('hour')==$i?'selected':'' }}>{{ $i }}:00</option>@endfor</select></div>
        <div><label>Tipe PS</label><select name="ps_type_id" class="border rounded p-1"><option value="">Semua</option>@foreach($psTypes as $ps)<option value="{{ $ps->id }}" {{ request('ps_type_id')==$ps->id?'selected':'' }}>{{ $ps->name }}</option>@endforeach</select></div>
        <div><button type="submit" class="bg-indigo-600 text-white px-4 py-1 rounded">Filter</button></div>
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-100">
            <tr><th class="p-2">Tanggal Sewa</th><th>PS Type</th><th>Unit</th><th>Customer</th><th>Durasi</th><th>Total Bayar</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($rentals as $rental)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-2">{{ $rental->rental_date->format('d/m/Y H:i') }}</td>
                <td>{{ $rental->psType->name }}</td>
                <td>Unit {{ $rental->unit_number ?? '-' }}</td>
                <td>{{ $rental->customer_name }}</td>
                <td>{{ $rental->duration_hours }} jam</td>
                <td>Rp {{ number_format($rental->total_price,0,',','.') }}</td>
                <td><span class="px-2 py-1 rounded text-xs {{ $rental->status=='active'?'bg-yellow-200':'bg-green-200' }}">{{ $rental->status=='active'?'Berlangsung':'Selesai' }}</span></td>
                <td>@if($rental->status=='active')<form method="POST" action="{{ route('admin.rentals.return',$rental->id) }}">@csrf @method('PATCH')<button type="submit" class="bg-red-500 text-white px-2 py-1 rounded text-xs">Kembalikan</button></form>@else-@endif</td>
            </tr>
            @empty
            <tr><td colspan="8" class="p-4 text-center">Tidak ada transaksi</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
