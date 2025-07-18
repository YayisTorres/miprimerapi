<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Opcional: Agregar validaciones a nivel de modelo
    public static function rules($id = null)
    {
        return [
            'nombre' => 'required|string|max:255|unique:productos,nombre,' . $id,
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:1000',
            'stock' => 'nullable|integer|min:0'
        ];
    }
}
