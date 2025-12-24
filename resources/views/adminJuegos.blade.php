<?php 
    use App\Models\Game;
?>

<x-layouts.admin>
    <x-slot:title>Admin juegos</x-slot:title>
    <section class="container" id="section-juegos">
        <div class="container">
            <h2 class="text-center">Juegos</h2>
            
            <div class="d-flex justify-content-center link-crear" >
                <x-nav-link routeto="games.create">
                    Agregar juego
                </x-nav-link>
            </div>
            <div class="table-responsive">
                <table class="tabla-juegos w-100">
                    <thead>
                        <tr>
                            <th scope="col" class="p-4 text-center">Portada</th>
                            <th scope="col" class="p-4 text-center">Titulo</th>
                            <th scope="col" class="p-4 text-center">Lanzamiento</th>
                            <th scope="col" class="p-4 text-center">Precio</th>
                            <th scope="col" class="p-4 text-center">Descripción</th>
                            <th scope="col" class="p-4 text-center">Clases incluidas</th>
                            <th scope="col" class="p-4 text-center">Plataforma</th>
                             <th scope="col" class="p-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($games as $game)
                            <tr>
                                <td class="text-center align-middle p-4"><img src="{{ \Storage::url($game->portada) }}" alt="Portada de {{ $game->titulo }}"></td>
                                <td class="text-center align-middle p-4">{{ $game->titulo }}</td>
                                <td class="text-center align-middle p-4">{{ $game->fecha_lanzamiento }}</td>
                                <td class="text-center align-middle p-4">${{ $game->precio }}</td>
                                <td class="text-center align-middle p-4">{{ $game->recortarDescripcion }}</td>
                                <td class="text-start align-middle p-4">
                                    @foreach ($game->bg_classes as $clase)
                                        <span class="d-block mb-2">{{ $clase->nombre }}</span>
                                    @endforeach
                                </td>
                                <td class="text-start align-middle p-4">
                                    @foreach ($game->platforms as $plataforma)
                                        <span class="d-block mb-2">{{ $plataforma->nombre }}</span>
                                    @endforeach
                                </td>
                                <td class="text-center align-middle p-4">
                                    <div class="d-flex gap-3">
                                        <a href="{{ route('games.edit', ['id' => $game->juego_id]) }}" class="btn btn-secondary"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="{{ route('games.delete', ['id' => $game->juego_id]) }}" class="btn btn-secondary bg-danger"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                </td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-layouts.admin>