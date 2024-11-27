<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer; // Asegúrate de importar el modelo Offer

class PageController extends Controller
{
    /**
     * Muestra la página de inicio con las ofertas disponibles, filtradas por categoría y búsqueda.
     */
    public function home(Request $request)
    {
        $query = Offer::where('Estado', 'Disponible'); // Inicia la consulta para obtener las ofertas disponibles

        // Filtrar por categoría
        if ($request->has('categoria') && $request->categoria) {
            $query->where('categoria', $request->categoria);
        }

        // Filtrar por búsqueda en nombre o descripción
        if ($request->has('search') && $request->search) {
            $query->where(function($query) use ($request) {
                $query->where('Título', 'like', '%' . $request->search . '%')
                      ->orWhere('Descripción', 'like', '%' . $request->search . '%');
            });
        }

        // Obtener las ofertas filtradas
        $offers = $query->get();

        // Pasar las ofertas a la vista
        return view('home', compact('offers'));
    }
}
