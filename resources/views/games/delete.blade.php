<x-layouts.admin>
    <x-slot:title>Eliminar juego</x-slot:title>
    <section id="section-juegos-delete">
        <div class="container">
            <h2 class="text-center">¿Estás seguro de eliminar Baldur's Gate 3 <span class="fw-bold">{{ $game->titulo }}</span>?</h2>
            <img src="{{ \Storage::url($game->portada) }}">
            <form action="{{ route('games.destroy', ['id' => $game->juego_id]) }}" method="POST" class="d-flex justify-content-center gap-3" novalidate>
                @csrf
                <button type="submit" class="btn btn-danger px-4">Sí, eliminar</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary px-4">Cancelar</a>
            </form>
        </div>
    </section>

</x-layouts.admin>