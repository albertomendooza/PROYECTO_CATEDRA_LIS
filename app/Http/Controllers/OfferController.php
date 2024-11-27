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
    // Validar los datos de entrada, incluyendo la categoría
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
        'categoria' => 'required|in:Tecnología,Restaurantes,Entretenimiento,Salud y Belleza,Viajes,Ropa y Moda,Hogar y Muebles', // Validación de categoría
        'Imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Agregar el ID de la empresa autenticada
    $validated['EmpresaID'] = Auth::id();

    // Si hay una imagen, la procesamos
    if ($request->hasFile('Imagen')) {
        // Guardar la imagen en el directorio 'public/offers'
        $imagePath = $request->file('Imagen')->store('public/offers');
        $validated['Imagen'] = $imagePath;  // Guardar la ruta de la imagen en la base de datos
    }

    try {
        // Crear la oferta con los datos validados, incluyendo la categoría
        Offer::create($validated);

        // Redirigir con éxito
        return redirect()->route('offers.create')->with('success', 'Cupón registrado exitosamente.');
    } catch (\Exception $e) {
        // Manejo de errores
        return redirect()->route('offers.create')->withErrors(['error' => 'Error al registrar el cupón: ' . $e->getMessage()]);
    }
}


    /**
     * Actualiza un cupón existente.
     */
    public function update(Request $request, $id)
{
    // Validar los datos de entrada, incluyendo la categoría y la imagen (si se proporciona)
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
        'categoria' => 'required|in:Tecnología,Restaurantes,Entretenimiento,Salud y Belleza,Viajes,Ropa y Moda,Hogar y Muebles', // Validación de categoría
        'Imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la imagen
    ]);

    // Obtener la oferta a actualizar
    try {
        $offer = Offer::where('EmpresaID', Auth::id())->findOrFail($id);

        // Si hay una imagen, la procesamos y la actualizamos
        if ($request->hasFile('Imagen')) {
            // Eliminar la imagen anterior si existe
            if ($offer->Imagen) {
                // Eliminar la imagen anterior del storage
                Storage::delete($offer->Imagen);
            }

            // Guardar la nueva imagen
            $imagePath = $request->file('Imagen')->store('public/offers');
            $validated['Imagen'] = $imagePath; // Guardar la ruta de la nueva imagen
        }

        // Actualizar la oferta con los datos validados
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
