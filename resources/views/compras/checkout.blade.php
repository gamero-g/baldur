<?php
    $subtotal = 0;
    $n = 0;
?>
<x-layouts.main>
    <x-slot:title>completar compra</x-slot:title>
    <section id="section-carrito" class="container text-light">
        <h1>Completar compra - resumen</h1>
        <div class="info-direccion">
            <h2>Tu dirección</h2>
            <div>
                <p class="fs-3 font-bold">{{ Auth::user()->profile->direccion ?? 'No hay una dirección proporcionada'}}</p>
            </div>
            <p>Si el producto es físico, lo enviaramos a esa dirección.</p>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th scope="col" class="p-4 text-center">Número de producto</th>
                        <th scope="col" class="p-4 text-center">Producto</th>
                        <th scope="col" class="p-4 text-center">Precio</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ($productos as $producto)
                        <tr>
                            <td align="center" valign="middle" class="p-4">
                                {{ $n += 1 }}
                            </td>
                            <td align="center" valign="middle" class="p-4">
                               @if (\Storage::disk('public')->exists($producto->portada))  
                                    <img src="{{ \Storage::url($producto->portada) }}"> 
                                @else
                                    <img src="img/{{ $producto->portada}}"></a>
                                @endif    
                                {{ $producto->titulo }}
                            </td>
                            <td align="center" valign="middle" class="p-4">
                              ${{ $producto->precio }}
                            </td>
                        </tr>
                        <?php $subtotal += $producto->precio ?>
                    @endforeach
                </tbody>
                 <tfoot>
                    <tr>
                        <td align="center" valign="middle" class="p-4">
                                {{ $n }} Productos
                        </td>
                        <td  colspan="1" align="center" valign="middle" class="p-4"><strong>Subtotal</strong></td>
                        <td  colspan="2" align="center" valign="middle" class="p-4"><strong>${{ $subtotal }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @if (Auth::user()->profile->direccion !== null)
            <div id="mercadopago_payload_button"></div>
        @else
            <div class=" text-center mt-4">
                <p class="fs-3">Indicá una direccón para terminar la compra!</p>
                <a class="fs-3 btn-action m-auto" href="{{ route('users.perfil') }}">Ir a mi perfil</a>
            </div>
        @endif
        
    </section>

    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        const mp = new MercadoPago('{{ $MPPublicKey }}');
        
        mp.bricks().create('wallet', 'mercadopago_payload_button', {
            initialization: {
                preferenceId: '{{ $preference->id }}'
            }
        });
    </script>
</x-layouts.main>