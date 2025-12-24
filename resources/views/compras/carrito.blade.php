<?php
    $subtotal = 0;
?>
<x-layouts.main>
    <x-slot:title>Carrito</x-slot:title>
    <section id="section-carrito" class="container text-light">
        <h1>CARRITO</h1>
        @if (session('feedback.message'))
            <div class="alert alert-{{ session('feedback.type', 'success') }}">
                {{ session('feedback.message') }}
            </div>
        @endif
        @if (count($productos) > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th scope="col" class="p-4 text-center">Producto</th>
                            <th scope="col" class="p-4 text-center">Precio</th>
                            <th scope="col" class="p-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr>
                                <td class="p-4 d-flex flex-column justify-content-center align-items-center">
                                    @php
                                        $portada = $producto->portada;
                                    @endphp

                                    @if (\Storage::disk('public')->exists($portada))
                                        <img src="{{ \Storage::url($portada) }}" alt="Portada de {{ $producto->titulo }}">
                                    @else
                                        @php
                                        $fallback = \Illuminate\Support\Str::startsWith($portada, ['img/', '/img/'])
                                            ? ltrim($portada, '/')
                                            : 'img/'.$portada;
                                        @endphp

                                        <img src="{{ asset($fallback) }}" alt="Portada de {{ $producto->titulo }}">
                                    @endif
                                    {{ $producto->titulo }}
                                </td>
                                <td align="center" valign="middle" class="p-4">
                                ${{ $producto->precio }}
                                </td>
                                <td align="center" valign="middle" class="p-4">
                                <form action="{{ route('compras.eliminar', ['id' => $producto->juego_id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class=" btn-action border-0 outline-0"><i class="fa-solid fa-xmark"></i></button>
                                </form>
                                </td>
                            </tr>
                            <?php $subtotal += $producto->precio ?>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td  colspan="1" align="center" valign="middle" class="p-4"><strong>Subtotal</strong></td>
                            <td  colspan="2" align="center" valign="middle" class="p-4"><strong>${{ $subtotal }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="carrito-acciones d-flex gap-4 justify-content-between">
                <div class="d-flex gap-4">
                    <div>
                        <a href="{{ route('compras.checkout')}}" class="btn-action">Continuar con la compra</a>
                    </div>
                    <div>
                        <a href="{{ route('games.all') }}" class="btn-action">Seguir comprando</a>
                    </div>
                </div>
                <div>
                    <form action="{{ route('compras.vaciar') }}" method="POST">
                        @csrf
                        <button type="submit" class="vaciar border-0 outline-0">Vaciar carrito</button>
                    </form>
                </div>
            </div>
            
        @else
            <div class="carrito-vacio d-flex flex-column align-items-center justify-content-center">
                <h2>Tu carrito está vacío!</h2>
                <div>
                    <a href="{{ route('games.all') }}" class="btn-action">Ver productos</a>
                </div>
            </div>
        @endif
        
    </section>
</x-layouts.main>