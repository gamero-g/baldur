<?php 
    $total = 0;
?>

<x-layouts.admin>
    <x-slot:title>Compra por usuario</x-slot:title>
    <section id="section-juegos" class="d-flex flex-column align-items-center">
        <h2 class="text-center">Compras de: {{ $usuario->email }}</h2>
        <div>
            <p>{{ count($usuario->buys) }} compras</p>

        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th scope="col" class="p-4 text-center">Estado</th>
                        <th scope="col" class="p-4 text-center">Fecha de compra</th>
                        <th scope="col" class="p-4 text-center">Productos</th>
                        <th scope="col" class="p-4 text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuario->buys as $compra)
                        <tr>
                            <td align="center" valign="middle" class="p-4">{{ $compra->estado }}</td>
                            <td align="center" valign="middle" class="p-4">{{ $compra->created_at->format('Y-m-d') }}</td>
                            <td align="center" valign="middle" class="p-4">
                                @foreach ($compra->products as $producto)
                                    <span class="d-block">{{ $producto->titulo }}</span>
                                    <span>Valor: ${{ $producto->precio }}</span>
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
    </section>

</x-layouts.admin>