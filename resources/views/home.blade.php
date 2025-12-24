<?php
/** @var \App\Models\Game $game*/
?> 


<x-layouts.main>
    <x-slot:title>Home</x-slot:title>
    <div id="home">
   
        <section id="section-1">
            <div class="container d-flex flex-column justify-content-center align-items-md-end align-items-center text-center">
                <h1>Baldur's Gate 3</h1>
                <a href="#section-3" class="btn-action">Conseguir</a>
            </div>
        </section>
        <section class="mi-fade p-3">
            <div class="container">
                <h2 class="text-center pt-4">Awards</h2>
                <div class="d-flex overflow-hidden p-3" id="carrousel">
                    <img src="img/premios/1.png"  class="img-fluid" alt="Premio Bafta">
                    <img src="img/premios/5.png"  class="img-fluid" alt="Premio Bilibili">
                    <img src="img/premios/12.png" class="img-fluid" alt="Premio Topp klass">
                    <img src="img/premios/2.png"  class="img-fluid" alt="Premio The game awards">
                    <img src="img/premios/4.png"  class="img-fluid" alt="Premio Golden joystick awards">
                    <img src="img/premios/15.png" class="img-fluid" alt="Premio PSU">
                    <img src="img/premios/21.png" class="img-fluid" alt="Premio Making Mofongo">
                </div>
            </div>
        </section>
        <section id="section-2">
            <div id="carouselPersonajes" class="carousel slide  carousel-fade">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselPersonajes" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselPersonajes" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselPersonajes" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div>
                            <div class="bg-1">
                                <div class="mask-1">
                                    <div class="triangulo"></div> 
                                    <h2>ASTARION</h2>
                                    <div class="personaje-body">
                                        <p class="mx-auto">Astarion merodeó la noche como un engendro vampírico durante siglos, obligado a seguir las órdenes de su sádico amo, Cazador: seducir a todo idiota con pulso y atraerlo de vuelta a su guarida. Libre por ahora, Astarion hará lo que sea para mantener su vida a la luz. Solo ve una manera de asegurar su libertad para siempre: volverse mucho más poderoso de lo que su antiguo abusador jamás soñó ser.</p>
                                        <img src="img/personajes/hero-astarion.webp" class="img-fluid" alt="Ilustración de Astarion de Baldur's Gate 3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div>
                            <div class="bg-2">
                                <div class="mask-1">
                                    <div class="triangulo"></div> 
                                    <h2>LAEZEL</h2>
                                    <div class="personaje-body">
                                        <p  class="mx-auto">
                                            Caída en la Costa de la Espada desde las estrellas, Lae'zel es una guerrera feroz, incluso para los estándares de la militante sociedad githyanki. Ante la posibilidad de convertirse en una azotamentes, el monstruo a cuya derrota dedicó su vida, deberá demostrar su valía y ganarse el derecho a reunirse con su pueblo, si no la ejecutan primero. ¿Serán suficientes la fuerza y ​​la determinación de Lae'zel para demostrar su valía a la reina Vlaakith, o deberá recorrer otro camino en el exilio?</p>
                                        <img src="img/personajes/hero-laezel.webp" class="img-fluid" alt="Ilustración de Laezel de Baldur's Gate 3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div>
                            <div class="bg-3">
                                <div class="mask-1">
                                    <div class="triangulo"></div> 
                                    <h2>KARLACH</h2>
                                    <div class="personaje-body">
                                        <p  class="mx-auto">
                                            Tras escapar del Infierno, Karlach por fin se ha liberado del archidiablo Zariel, pero no del motor infernal que Zariel le implantó en el pecho. Con su primera experiencia de libertad en diez años, Karlach ansía encontrar una solución para el motor que arde cada vez más antes de que la consuma por completo. ¿Pero qué es aún más importante en su mente? Explorar, encontrar viajeros con ideas afines, enamorarse (o sentir lujuria)... y vengarse del hombre que la vendió a Zariel hace tantos años.</p>
                                        <img src="img/personajes/hero-karlach.webp" class="img-fluid" alt="Ilustración de Karlach de Baldur's Gate 3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselPersonajes" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previo</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselPersonajes" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>
        </section>
        <section id="section-3" class="mt-5 container">
            <h2 class="mt-4 text-center text-light fs-1">COMPRALO AHORA!</h2>
            <div class="d-flex flex-column flex-md-row container-fluid">
                @foreach ($games as $game)
                    <a href="{{  route('games.details', ['id' => $game->juego_id]) }}"  class="text-decoration-none">
                        <div class="mask">
                            <div class="container">
                                <h3 class="text-center">{{ $game->titulo }}</h3>
                                <div>
                                    <img src="{{ asset($game->portada) }}" class="img-fluid" alt="Portada de {{ $game->titulo }}">
                                </div>
                            </div>
                        </div>                   
                    </a>
                @endforeach
            </div>
        </section>

        <section id="section-4" class="mask">
            <div>
                <div class="container d-flex flex-column align-items-center justify-content-center">
                    <h2 class="text-center">Updates y Noticias</h2>
                    <x-nav-link routeto="blogs.blog">Leer más</x-nav-link>
                </div>
                <div id="carrouselNoticias" class="d-flex gap-5 overflow-hidden container">
                    @foreach ($blogs as $blog)
                        <article class="bg me-4"> 
                            <div class="bg-dedicado-{{ $blog->blog_id }}"></div>
                            <div class="contenido">
                                <span>{{ $blog->autor }} - {{ $blog->created_at }}</span>
                                <h3>{{ $blog->titulo }}</h3>
                                <p>{{ $blog->descripcion }}</p>
                                <a href="{{ route('blogs.details', ['id' => $blog->blog_id]) }}" class="btn-action">Leer más</a>
                                
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    <div>
        
    </div>
</x-layouts.main>