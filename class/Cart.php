<?php
require_once "Products.php"; 

class Cart {

    /**
     * Agrega un item al carrito de compras
     * @param int $productoID El ID del producto que se va a agregar.
     * @param int $cantidad La cantidad de unidades del producto que se van a agregar
     */
    public function add_item(int $productoID, int $cantidad) {
        
        $itemData = (new Products)->getProductById($productoID);
        
        if ($itemData) {
            $_SESSION['cart'][$productoID] = [
                'product' => $itemData->getName(),
                'img' => $itemData->getImage(),
                'precio' => $itemData->getPrice(),
                'cantidad' => $cantidad
            ];
        }

    }

    /**
     * Elimina un item del carrito de compras
     * @param int $productoID El id del producto a elminar
     */
    public function remove_item(string $productoID)
    {
        if (isset($_SESSION['cart'][$productoID])) {
            unset($_SESSION['cart'][$productoID]);
        }
    }

    /**
     * devuelve el contenido del carrito de compras actual
     */
    public function get_carrito()
    {
        if (!empty($_SESSION['cart'])) {
            return $_SESSION['cart'];
        } else {
            return [];
        }
    }

    /**
     * Actualiza las cantidades de los ids provistos
     * @param array $cantidades Array asociativo con las cantidades de cada ID
     */
    public function update_quantities(array $cantidades)
    {
        foreach ($cantidades as $key => $value) {
            if (isset($_SESSION['cart'][$key])) {
                $_SESSION['cart'][$key]['cantidad'] = $value;
            }
        }
    }
    /**
     * Vacia el carrito de compras
     */
    public function clear_items()
    {
        $_SESSION['cart'] = [];
    }

    /**
     * Devuelve el precio total actual del carrito de compras
     */
    public function precio_total()
    {
        $total = 0;
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }
        }
        return $total;
    }

    /**
     * Devuelve el precio total actual del carrito de compras
     */
    public function cantidad_total()
    {
        $quantity = 0;
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $quantity += $item['cantidad'];
            }
        }
        return $quantity;
    }

}
