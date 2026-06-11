@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold text-slate-800 mb-5">
    <i class="fas fa-tv mr-2"></i>Status PS & Unit
</h2>

<div class="space-y-6">
    @foreach($psTypes as $ps)
    <div class="bg-white rounded-2xl shadow-md p-5">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-xl font-bold">{{ $ps->name }}</h3>
            <span class="text-sm text-gray-500">Harga: Rp {{ number_format($ps->price_per_hour,0,',','.') }}/jam</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
            @foreach($ps->units_status as $unit)
            <div class="border rounded-lg p-3 {{ $unit['available'] ? 'bg-green-50 border-green-300' : 'bg-red-50 border-red-300' }}">
                <div class="font-bold text-lg">Unit {{ $unit['number'] }}</div>

                @if($unit['available'])
                <div class="text-green-600">
                    <i class="fas fa-check-circle"></i> Tersedia
                </div>
                @else
                <div class="text-red-600 text-sm">
                    <i class="fas fa-user"></i> {{ $unit['rental']['customer'] }}
                </div>
                <div class="text-sm mt-1">
                    ⏱️ Sisa: <span class="countdown font-mono" data-end="{{ $unit['rental']['ends_at']->toIso8601String() }}">--:--:--</span>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

<div class="mt-6 bg-indigo-50 p-4 rounded-xl">
    <p class="font-semibold">📊 Total rental aktif: {{ $totalActive }}</p>
</div>

<script>
    function updateTimers() {
        document.querySelectorAll('.countdown').forEach(function(el) {
            var endTime = new Date(el.dataset.end).getTime();
            var now = new Date().getTime();
            var diff = Math.max(0, endTime - now);
            var hours = Math.floor(diff / (1000 * 60 * 60));
            var minutes = Math.floor((diff % (3600000)) / (1000 * 60));
            var seconds = Math.floor((diff % 60000) / 1000);
            el.innerText = hours.toString().padStart(2,'0') + ':' + minutes.toString().padStart(2,'0') + ':' + seconds.toString().padStart(2,'0');
        });
    }
    setInterval(updateTimers, 1000);
    updateTimers();
</script>
@endsection
