<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Offer;

class CarritoController extends Controller
{
    /**
     * Muestra el contenido del carrito.
     */
    public function index()
    {
        // Obtener el carrito de la sesión
        $carrito = session()->get('carrito', []);

        // Calcular el total
        $total = array_reduce($carrito, function ($carry, $item) {
            return $carry + $item['subtotal'];
        }, 0);

        return view('carrito', compact('carrito', 'total'));
    }

    /**
     * Agrega una oferta al carrito.
     */
    public function agregar(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);

        // Obtener el carrito de la sesión
        $carrito = session()->get('carrito', []);

        // Verificar si la oferta ya está en el carrito
        if (isset($carrito[$id])) {
            if ($carrito[$id]['cantidad'] < $offer->CantidadCupones) {
                $carrito[$id]['cantidad']++;
            } else {
                return redirect()->route('carrito.index')->with('error', 'No hay suficientes cupones disponibles.');
            }
        } else {
            // Agregar nueva oferta al carrito
            $carrito[$id] = [
                'id' => $offer->id,
                'Título' => $offer->Título,
                'PrecioOferta' => $offer->PrecioOferta,
                'cantidad' => 1,
                'subtotal' => $offer->PrecioOferta,
                'max_cantidad' => $offer->CantidadCupones,
            ];
        }

        // Actualizar el subtotal
        $carrito[$id]['subtotal'] = $carrito[$id]['cantidad'] * $offer->PrecioOferta;

        // Guardar en sesión
        session()->put('carrito', $carrito);

        return redirect()->route('carrito.index')->with('success', 'Cupón agregado al carrito.');
    }

    /**
     * Actualiza la cantidad de una oferta en el carrito.
     */
    public function actualizar(Request $request, $id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $cantidad = $request->input('cantidad');

            // Validar que la cantidad no exceda la disponible
            if ($cantidad > $carrito[$id]['max_cantidad']) {
                return redirect()->route('carrito.index')->with('error', 'Cantidad no puede exceder los cupones disponibles.');
            }

            $carrito[$id]['cantidad'] = $cantidad;
            $carrito[$id]['subtotal'] = $cantidad * $carrito[$id]['PrecioOferta'];

            // Actualizar en sesión
            session()->put('carrito', $carrito);
        }

        return redirect()->route('carrito.index')->with('success', 'Carrito actualizado.');
    }

    /**
     * Elimina una oferta del carrito.
     */
    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            unset($carrito[$id]);

            // Actualizar en sesión
            session()->put('carrito', $carrito);
        }

        return redirect()->route('carrito.index')->with('success', 'Elemento eliminado del carrito.');
    }

    /**
     * Redirige a la vista de la pasarela de pago.
     */
    public function pagar()
    {
        // Obtener el carrito de la sesión para mostrar el total
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'El carrito está vacío.');
        }

        $total = array_reduce($carrito, function ($carry, $item) {
            return $carry + $item['subtotal'];
        }, 0);

        return view('pago', compact('total'));
    }

    /**
     * Procesa el pago.
     */
    public function procesarPago(Request $request)
    {
        $validated = $request->validate([
            'card_number' => 'required|digits:16',
            'expiry_date' => 'required|regex:/^(0[1-9]|1[0-2])\/?([0-9]{2})$/',
            'cvv' => 'required|digits:3',
            'cardholder_name' => 'required|string|max:255',
        ]);

        // Simular el pago (vaciar el carrito después del pago)
        session()->forget('carrito');

        return redirect()->route('carrito.index')->with('success', 'Pago procesado exitosamente. Gracias por su compra.');
    }
}
