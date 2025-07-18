<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ProductoController extends Controller
{
    /**
     * Muestra una lista de todos los productos.
     * GET /api/productos
     */
    public function index()
    {
        try {
            $productos = Producto::all();
            return response()->json([
                'success' => true,
                'data' => $productos,
                'message' => 'Productos obtenidos exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener productos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guarda un nuevo producto en la base de datos.
     * POST /api/productos
     */
    public function store(Request $request)
    {
        try {
            // Validar los datos del producto
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'precio' => 'required|numeric|min:0',
                'descripcion' => 'nullable|string|max:1000',
                'stock' => 'nullable|integer|min:0'
            ]);

            // Crear el producto
            $producto = Producto::create($validatedData);

            return response()->json([
                'success' => true,
                'data' => $producto,
                'message' => 'Producto creado exitosamente'
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de validación incorrectos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra un producto específico por ID.
     * GET /api/productos/{id}
     */
    public function show(string $id)
    {
        try {
            $producto = Producto::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $producto,
                'message' => 'Producto encontrado'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualiza un producto existente por ID.
     * PUT/PATCH /api/productos/{id}
     */
    public function update(Request $request, string $id)
    {
        try {
            // Buscar el producto a actualizar
            $producto = Producto::findOrFail($id);

            // Validar solo los campos que se envíen
            $validatedData = $request->validate([
                'nombre' => 'sometimes|required|string|max:255',
                'precio' => 'sometimes|required|numeric|min:0',
                'descripcion' => 'nullable|string|max:1000',
                'stock' => 'sometimes|integer|min:0'
            ]);

            // Actualizar el producto
            $producto->update($validatedData);

            return response()->json([
                'success' => true,
                'data' => $producto->fresh(), // Obtener datos actualizados
                'message' => 'Producto actualizado exitosamente'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de validación incorrectos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un producto de la base de datos por ID.
     * DELETE /api/productos/{id}
     */
    public function destroy(string $id)
    {
        try {
            // Buscar el producto y eliminarlo
            $producto = Producto::findOrFail($id);
            $nombreProducto = $producto->nombre; // Guardar nombre antes de eliminar
            $producto->delete();

            return response()->json([
                'success' => true,
                'message' => "Producto '{$nombreProducto}' eliminado exitosamente"
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
