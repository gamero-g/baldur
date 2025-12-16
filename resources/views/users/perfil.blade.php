<?php 
    $total = 0;
?>

<x-layouts.main>
    <x-slot:title>Mi perfil</x-slot:title>
    <section id="section-perfil" class="container">
        <div class="d-flex flex-column text-light">
            <div class="d-flex align-items-center gap-3 line mb-2 pb-1 justify-content-between">
                <h1 class="fs-2 mb-0">{{ $user->name }}</h1>
                <a href="{{ route('users.editName') }}" class="btn-action mt-1"><i class="fa-solid fa-pen-to-square"></i></a>
            </div>
            <div>
                @if($user->profile->avatar !== null)
                    @if (\Storage::disk('public')->exists($user->profile->avatar))  
                        <a href="{{ route('users.editAvatar') }}" class="mt-1"><img src="{{ \Storage::url($user->profile->avatar) }}" class="user-avatar"></a>
                        <span>Clickea tu avatar para cambiarlo</span>
                    @else
                        <a href="{{ route('users.editAvatar') }}" class="mt-1"><img src="img/{{ $user->profile->avatar }}" class="user-avatar"></a>
                        <span>Clickea tu avatar para cambiarlo</span>
                    @endif
                @else
                    <a href="{{ route('users.editAvatar') }}" class="mt-1 btn-action">Elegir avatar</a>
                @endif
            </div>
            <span>{{ $user->email }}</span>
        </div>
        <div class="d-flex flex-column text-light mt-4">
            <div class="d-flex align-items-center gap-3 line mb-2 pb-1 justify-content-between">
                <h2 class="fs-4 mb-0">Tu información</h2>
                <a href="{{ route('users.editInformacion') }}" class="btn-action mt-1"><i class="fa-solid fa-pen-to-square"></i></a>
            </div>
            <div>
                <p>Direccion: {{ $user->profile->direccion ?? 'Sin especificar...'}}</p>
            </div>
        </div>
        <div class="d-flex flex-column  text-light mt-4">
            <h2 class="fs-4 line pb-2">Mis compras</h2>
            @if (!$user->buys->isEmpty())
                <span class="mb-3 ">Hiciste {{ count($user->buys)}} compras</span>
                <div class="table-responsive">       
                    <table>
                        <thead>
                            <tr>
                                <th scope="col" class="p-4 text-center">Estado</th>
                                <th scope="col" class="p-4 text-center">Fecha</th>
                                <th scope="col" class="p-4 text-center">Productos</th>
                                <th scope="col" class="p-4 text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach ($user->buys as $compra)
                                    <tr>
                                        <td align="center" valign="middle" class="p-4">{{ $compra->estado }}</td>
                                        <td align="center" valign="middle" class="p-4">{{ $compra->created_at->format('Y-m-d') }}</td>
                                        <td align="center" valign="middle" class="p-4">
                                            @foreach ($compra->products as $producto)
                                                <span class="d-block">- {{ $producto->titulo }}</span>
                                            @endforeach
                                        </td>
                                        <td align="center" valign="middle" class="p-4">
                                            @foreach ($compra->products as $producto)
                                                <?php $total+= $producto->precio ?>
                                            @endforeach
                                            ${{ $total }}
                                        </td>
                                    </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                </div> 
            @else
                <div class="mt-3">¡Realizá tu primera compra!</div>
                <a href="{{ route('games.all') }}" class="btn-action mt-1">Ver productos</a>
            @endif
        </div>
    </section>
</x-layouts.main>