<?php


    $clasesIds = old('editing', false) == false && $game->bg_classes->isNotEmpty()
    ? $game->getClassesId()
    : [];



    $plataformasIds = old('editing', false) == false && $game->platforms->isNotEmpty()
    ? $game->getPlatformsId()
    : [];

?>


<x-layouts.admin>
    <x-slot:title>Editar juego</x-slot:title>
    <section id="section-juegos-edit">
        <div class="container d-flex flex-column align-items-center">
            <h2 class="text-center">Editar Baldur's Gate 3 <span class="fw-bold">{{ $game->titulo }}</span></h2>
            <form action="{{ route('games.update', ['id' => $game->juego_id]) }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column justify-content-around p-3" novalidate>
                @csrf
                <div class="d-flex flex-column">
                    <label for="titulo">Título</label>
                    <input 
                    type="text" 
                    name="titulo" 
                    id="titulo"
                    class="a @error('titulo') border-red @enderror"
                    @error('titulo')
                        aria-invalid="true"
                        aria-errormessage="error-titulo"
                    @enderror
                    value="{{ old('titulo', $game->titulo) }}"
                    >
                  
                    @error('titulo')
                     <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="d-flex flex-column">
                    <label for="fecha_lanzamiento">Fecha de lanzamiento</label>
                    <input
                    type="date"
                    name="fecha_lanzamiento"
                    id="fecha_lanzamiento"
                    class="a @error('fecha_lanzamiento') border-red @enderror"
                    @error('fecha_lanzamiento')
                    aria-invalid="true"
                    aria-errormessage="error-fecha_lanzamiento"
                    @enderror
                    value="{{ old('fecha_lanzamiento', $game->fecha_lanzamiento) }}"
                    >
                    @error('fecha_lanzamiento')
                     <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="d-flex flex-column">
                    <label for="precio">Precio</label>
                    <input
                    type="number"
                    name="precio"
                    id="precio"
                    class="a @error('precio') border-red @enderror"
                    @error('precio')
                    aria-invalid="true"
                    aria-errormessage="error-precio"
                    @enderror
                    value="{{ old('precio', $game->precio) }}">
                    @error('precio')
                     <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <p>Portada actual</p>
                    @if ($game->portada &&  \Storage::exists($game->portada)) 
                        <img src="{{ \Storage::url($game->portada) }}" alt="Portada de {{ $game->titulo }}" class="img-fluid"></img>
                    @else
                        <p>No hay una portada</p>
                    @endif
                </div>
                <div class="d-flex flex-column">
                    <label for="portada">Portada</label>
                    <input 
                    type="file"
                    name="portada"
                    id="portada"
                    enctype="multipart/form-data"
                    >
                </div>
                <div class="d-flex flex-column">
                    <label for="descripcion">Descripción</label>
                    <textarea
                    name="descripcion"
                    id="descripcion"
                    @error('descripcion')
                    aria-invalid="true"
                    aria-errormessage="error-descripcion"
                    @enderror>{{ old('descripcion', $game->descripcion) }} </textarea>
                    @error('descripcion')
                     <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <fieldset>
                        <legend>Clases</legend>
                        <p>Clases disponibles:</p>
                        @foreach ($clases as $clase)
                            <label for="clase_{{ $clase->clase_id }}">
                                <input 
                                type="checkbox"
                                id="clase_{{ $clase->clase_id }}"
                                name="clases[]" value="{{ $clase->clase_id }}"
                                @checked(in_array($clase->clase_id, old('clases', $clasesIds)))
                                >
                                {{ $clase->nombre }}
                            </label>  
                        @endforeach
                    </fieldset>
                </div>
                <div class="mt-3">
                    <fieldset>
                        <legend>Plataforma</legend>
                        @foreach ($plataformas as $plataforma)
                            <label for="plataforma_{{ $plataforma->plataforma_id }}">
                                <input
                                type="checkbox" 
                                id="plataforma_{{ $plataforma->plataforma_id }}" 
                                name="plataformas[]" 
                                value="{{ $plataforma->plataforma_id }}"
                                 @checked(in_array($plataforma->plataforma_id, old('plataformas', $plataformasIds)))
                                >
                                {{ $plataforma->nombre }}
                            </label>  
                        @endforeach
                        @error('plataformas')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </fieldset>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <input type="submit" value="Editar" class="btn btn-action px-4 me-3">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary px-4">Cancelar</a>
                </div>
            </form>
        </div>

    </section>
</x-layouts.admin>