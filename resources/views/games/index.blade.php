@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Koleksi Game per PS</h2>
@foreach($psTypes as $ps)
<div class="bg-white rounded-xl shadow-md p-5 mb-6">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-bold text-indigo-800">{{ $ps->name }}</h3>
        <button class="addGameBtn bg-indigo-500 text-white px-3 py-1 rounded text-sm" data-psid="{{ $ps->id }}">
            <i class="fas fa-plus"></i> Tambah Game
        </button>
    </div>
    <div class="flex flex-wrap gap-2 mt-3">
        @foreach($ps->games as $game)
        <span class="bg-gray-100 px-3 py-1 rounded-full flex items-center gap-1">
            {{ $game->name }}
            <form method="POST" action="{{ route('admin.games.destroy', $game->id) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 ml-1"><i class="fas fa-times-circle"></i></button>
            </form>
        </span>
        @endforeach
    </div>
</div>
@endforeach

<form id="addGameForm" method="POST" action="{{ route('admin.games.store') }}" class="hidden">
    @csrf
    <input type="hidden" name="ps_type_id" id="gamePsId">
    <input type="hidden" name="name" id="gameName">
</form>

<script>
    document.querySelectorAll('.addGameBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            let psId = btn.dataset.psid;
            let gameName = prompt('Nama game baru:');
            if(gameName) {
                document.getElementById('gamePsId').value = psId;
                document.getElementById('gameName').value = gameName;
                document.getElementById('addGameForm').submit();
            }
        });
    });
</script>
@endsection
