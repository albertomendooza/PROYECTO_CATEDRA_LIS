<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    /**
     * Muestra la página principal con el formulario y los cupones existentes.
     */
    public function create()
    {
        // Obtener cupones de la empresa autenticada
        $offers = Offer::where('EmpresaID', Auth::id())->get();

        // Retornar la vista con los cupones existentes
        return view('auth.coupon', compact('offers'));
    }

    /**
     * Almacena un nuevo cupón en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Título' => 'required|string|max:255',
            'PrecioRegular' => 'required|numeric|min:0',
            'PrecioOferta' => 'required|numeric|min:0|lt:PrecioRegular',
            'FechaInicio' => 'required|date',
            'FechaFin' => 'required|date|after:FechaInicio',
            'FechaLimiteCanje' => 'required|date|after:FechaFin',
            'CantidadCupones' => 'required|integer|min:1',
            'Descripción' => 'required|string',
            'Estado' => 'required|in:Disponible,No disponible',
        ]);

        $validated['EmpresaID'] = Auth::id();

        try {
            Offer::create($validated);

            return redirect()->route('offers.create')->with('success', 'Cupón registrado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('offers.create')->withErrors(['error' => 'Error al registrar el cupón: ' . $e->getMessage()]);
        }
    }

    /**
     * Actualiza un cupón existente.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'Título' => 'required|string|max:255',
            'PrecioRegular' => 'required|numeric|min:0',
            'PrecioOferta' => 'required|numeric|min:0|lt:PrecioRegular',
            'FechaInicio' => 'required|date',
            'FechaFin' => 'required|date|after:FechaInicio',
            'FechaLimiteCanje' => 'required|date|after:FechaFin',
            'CantidadCupones' => 'required|integer|min:1',
            'Descripción' => 'required|string',
            'Estado' => 'required|in:Disponible,No disponible',
        ]);

        try {
            $offer = Offer::where('EmpresaID', Auth::id())->findOrFail($id);
            $offer->update($validated);

            return redirect()->route('offers.create')->with('success', 'Cupón actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('offers.create')->withErrors(['error' => 'Error al actualizar el cupón: ' . $e->getMessage()]);
        }
    }

    /**
     * Elimina un cupón existente.
     */
    public function destroy($id)
    {
        try {
            // Verificar que el cupón pertenece al usuario autenticado
            $offer = Offer::where('EmpresaID', Auth::id())->findOrFail($id);
    
            // Eliminar el cupón
            $offer->delete();
    
            return redirect()->route('offers.create')->with('success', 'Cupón eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('offers.create')->withErrors(['error' => 'Error al eliminar el cupón: ' . $e->getMessage()]);
        }
    }
}
