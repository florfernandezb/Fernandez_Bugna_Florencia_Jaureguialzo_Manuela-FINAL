<?php

/**
 * Get array of navigation routes
 * @return string[][]
 */
function getRoutesSitio() {
    return [
        "dashboard" => [
            "title" => "Panel de administración"
        ],
        "product_crud" => [
            "title" => "Gestión de productos"
        ],
        "category_crud" => [
            "title" => "Gestión de categorías"
        ],
        "color_crud" => [
            "title" => "Gestión de colores"
        ],
        "add_product" => [
            "title" => "Agrega un producto"
        ],
        "modify_product" => [
            "title" => "Edita un producto"
        ],
        "delete_product" => [
            "title" => "Elimina el producto"
        ],
        "add_category" => [
            "title" => "Agregá una categoría"
        ],
        "modify_category" => [
            "title" => "Editá una categoría"
        ],
        "add_color" => [
            "title" => "Agregá un color"
        ],
        "modify_color" => [
            "title" => "Editá un color"
        ],
        "delete_category" => [
            "title" => "Elimina una categoría"
        ],
        "delete_color" => [
            "title" => "Elimina un color"
        ],
        "generic_error" => [
            "title" => "Algo salió mal"
        ]
    ];
}