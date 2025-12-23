<x-layouts.main>
    <x-slot:title>Productos</x-slot:title>
    <section id="productos">
        <div id="productos-hero">
            <div class="container">
                <h1>Versiones de Baldur's Gate 3</h1>
            </div>
        </div>
        <section class="container d-flex flex-column align-items-center">
            <h2 class="visually-hidden">Listado de versiones disponibles</h2>
            @foreach ($games as $game)
                <article>
                    <a href="{{ route('games.details', ['id' => $game->juego_id]) }}" class="d-flex align-items-center text-decoration-none text-light flex-column flex-md-row">
                        <img src="{{ asset($game->portada) }}" alt="Portada de {{ $game->titulo }}">
                        <h2>{{ $game->titulo }}</h2>
                    </a>
                </article>
            @endforeach
        </section>
    </section>
</x-layouts.main>