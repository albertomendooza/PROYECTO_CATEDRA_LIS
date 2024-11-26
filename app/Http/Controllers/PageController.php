<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer; // Asegúrate de importar el modelo Offer

class PageController extends Controller
{
    /**
     * Muestra la página de inicio con las ofertas disponibles.
     */
    public function home()
    {
        // Obtener las ofertas con estado "Disponible"
        $offers = Offer::where('Estado', 'Disponible')->get();

        // Pasar las ofertas a la vista
        return view('home', compact('offers'));
    }
}
