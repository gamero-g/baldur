<?php

namespace App\Http\Controllers;

use App\Models\BgClass;
use App\Models\Game;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GamesController extends Controller
{
    public static function allGames() {
      $games = Game::all();
      return view('games.all', [
        'games' => $games
      ]);
    }

    public static function firstTwoGames() {
      $games = Game::with('bg_classes')->get();
      $twoGames = $games->find([1, 2]);
      
      return $twoGames;
    }

    public function gameById(int $id) {
      $game = Game::with('bg_classes', 'platforms')->findOrFail($id);
      $yaComprado = false;
      if(Auth::check()) {
        $userCompras = User::with('buys.products')->findOrFail(Auth::id());
        foreach ($userCompras->buys as $compra) {
          foreach ($compra->products as $product) {
            if($product->juego_id === $game->juego_id) {
              $yaComprado = true;
            } 
          }
        }
      }
      return view('games.details', [
        'game' => $game,
        'carrito' => session()->get('carrito', []),
        'yaComprado' => $yaComprado
      ]);
    }

    public function adminJuegos() {
      $games = Game::all();
      return view('adminJuegos', [
        'games' => $games
      ]);
    }

    public function create() {
      $clases = BgClass::select()->where('juego_fk', null)->get();
      if($clases->isEmpty()) {
        return to_route('adminJuegos')
          ->with('feedback.message', 'No hay más clases disponibles. Desvinculá alguna de algún juego.');
      }
      return view('games.create', [
        'clases' => $clases,
        'plataformas' => Platform::all()
      ]);
    }

    public function store(Request $request) {
      $request->validate([
        'titulo' => 'required|min:5|max:255',
        'fecha_lanzamiento' => 'required|before_or_equal:today|date_format:Y-m-d',
        'descripcion' => 'required|min:25',
        'precio' => 'required|numeric|min:0',
        'portada' => 'required',
        'plataformas' => 'required'
      ],
      [
        'titulo.required' => 'El título es obligatorio',
        'titulo.min' => 'El título debe tener más de 5 caracteres',
        'titulo.max' => 'El título no debe tener más de 255 caracteres', 
        'fecha_lanzamiento.required' => 'La fecha es obligatoria',
        'fecha_lanzamiento.before_or_equal' => 'La fecha debe ser hoy o anterior al día de hoy',
        'fecha_lanzamiento.date_format' => 'La fecha debe tener el formato y-m-d',
        'descripcion.required' => 'La descripción es obligatoria',
        'descripcion.min' => 'La descripción debe tener más de 25 caracteres',
        'precio.required' => 'El precio es obligatorio',
        'precio.numeric' => 'El precio debe ser un número',
        'precio.min' => 'El precio debe ser mayor a 0',
        'portada.required' => 'La portada es obligatoria',
        'plataformas.required' => 'El juego debe estar en al menos 1 plataforma'
        
      ]);

      try {
        $data = $request->only('titulo', 'fecha_lanzamiento', 'descripcion', 'precio', 'portada');

        if($request->hasFile('portada')) {
          $data['portada'] = $request->file('portada')->store('img', 'public');
        } 
      
        DB::transaction(function() use ($data, $request) {
          $game = Game::create($data);

          $game->platforms()->attach($request->input('plataformas', []));

          if($request->clases) {
              foreach($request->clases as $clase) {
              $classParaUpdatear = BgClass::findOrFail($clase);
              $classParaUpdatear->update([
                'juego_fk' => $game->juego_id
              ]);
            }
          }
        });

        return to_route('adminJuegos')
          ->with('feedback.message', 'El juego <b>' . e($data['titulo']) . '</b> se creó con éxito.');
      } catch(\Throwable $th) {
        throw $th;
        return to_route('games.create')
            ->withInput()
            ->with('feedback.message', 'Ocurrió un error inesperado. No se puedo crear la película.');
      }
    }

    public function delete(int $id) {
      $game = Game::findOrFail($id);
      return view('games.delete', [
        'game' => $game,
        'clases' => BgClass::all(),
      ]);
    }

    public function destroy(int $id) {
      $game = Game::findOrFail($id);
      
      $game->platforms()->detach();

      BgClass::where('juego_fk', $game->juego_id)->update([
        'juego_fk' => null
      ]);

      if($game->portada !== null && Storage::exists($game->portada)) {
        Storage::delete($game->portada);
      }

      $game->delete();

      return to_route('adminJuegos')
        ->with('feedback.message', 'El juego <b>' . e($game['titulo']) . '</b> se eliminó con éxito.');
    }


    public function edit(int $id) {
      $game = Game::findOrFail($id);
      
      $clases = BgClass::select()
        ->where('juego_fk', null)
        ->orWhere('juego_fk', $id)
      ->get();
      
      $plataformas = Platform::all();

      return view('games.edit', [
        'game' => $game,
        'clases' => $clases,
        'plataformas' => $plataformas
      ]);
    }

    public function update(Request $request, int $id) {
       $request->validate([
        'titulo' => 'required|min:5|max:255',
        'fecha_lanzamiento' => 'required|before_or_equal:today|date_format:Y-m-d',
        'descripcion' => 'required|min:25',
        'precio' => 'required|numeric|min:0',
        'plataformas' => 'required'
      ],
      [
        'titulo.required' => 'El título es obligatorio',
        'titulo.min' => 'El título debe tener más de 5 caracteres',
        'titulo.max' => 'El título no debe tener más de 255 caracteres', 
        'fecha_lanzmiento.required' => 'La fecha es obligatoria',
        'fecha_lanzamiento.before_or_equal' => 'La fecha debe ser hoy o anterior al día de hoy',
        'fecha_lanzmiento.date_format' => 'La fecha debe tener el formato y-m-d',
        'descripcion.required' => 'La descripción es obligatoria',
        'descripcion.min' => 'La descripción debe tener más de 25 caracteres',
        'precio.required' => 'El precio es obligatorio',
        'precio.numeric' => 'El precio debe ser un número',
        'precio.min' => 'El precio debe ser mayor a 0',
        'plataformas' => 'El juego debe estar en al menos 1 plataforma'
      ]);

     

      $data = $request->only(['titulo', 'fecha_lanzamiento', 'descripcion', 'precio']);

      
      $game = Game::findOrFail($id);
    

      $portadaAnterior = null;

      if($request->hasFile('portada')) {
        $data['portada'] = $request->file('portada')->store('img', 'public');
        $portadaAnterior = $game->portada;
      }

      if($portadaAnterior !== null && Storage::exists($portadaAnterior)) {
        Storage::delete($portadaAnterior);
      }

      $game->update($data);
      
      BgClass::where('juego_fk', $game->juego_id)->update([
        'juego_fk' => null
      ]);

      foreach ($request->clases as $clase) {
        BgClass::where('clase_id', $clase)->update([
          'juego_fk' => $game->juego_id
        ]);
      }

      

      $game->platforms()->sync($request->input('plataformas', []));

      return to_route('adminJuegos')
        ->with('feedback.message', 'El juego <b>' . e($data['titulo']) . '</b> se editó con éxito.');
    }
}
