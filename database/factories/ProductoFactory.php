<?php

namespace Database\Factories;

use App\Models\Producto;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array {
        $categorias = [
            'Electrónicos',
            'Ropa',
            'Hogar',
            'Alimentos',
            'Juguetes'
        ];
        
        $categoria = fake()->randomElement($categorias);

        // Generar nombres y descripciones según categoría
        [$nombre, $descripcion] = $this->generarDatosPorCategoria($categoria);

        return [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => fake()->randomFloat(2, 1, 1000),
            'stock' => fake()->numberBetween(0, 100),
        ];
    }

    private function generarDatosPorCategoria(string $categoria): array {
        return match ($categoria) {
            'Electrónicos' => [
                fake()->randomElement([
                    'Smartphone ' . fake()->company,
                    'Laptop ' . fake()->lastName . ' Pro',
                    'Tablet ' . fake()->colorName . ' HD'
                ]),
                fake()->randomElement([
                    'Pantalla Full HD, procesador de última generación.',
                    'Batería de larga duración y diseño ultradelgado.',
                    'Ideal para trabajo y entretenimiento.'
                ])
            ],
            'Ropa' => [
                fake()->randomElement([
                    'Camiseta ' . fake()->colorName,
                    'Pantalón ' . fake()->city,
                    'Zapatos ' . fake()->firstName
                ]),
                fake()->randomElement([
                    'Tela transpirable y cómoda.',
                    'Ajuste perfecto para cualquier ocasión.',
                    'Material resistente y elegante.'
                ])
            ],
            'Hogar' => [
                fake()->randomElement([
                    'Sofá ' . fake()->word,
                    'Lámpara ' . fake()->monthName,
                    'Cafetera ' . fake()->userName
                ]),
                fake()->randomElement([
                    'Diseño moderno y funcional.',
                    'Iluminación ajustable y eficiente.',
                    'Capacidad para 12 tazas, fácil de limpiar.'
                ])
            ],
            default => [
                fake()->words(3, true),
                fake()->sentence()
            ]
        };
    }
}