<?PHP
$miCarrito = new Cart;

$items = $miCarrito->get_carrito();

?>
<h2 class="text-center fs-2 my-5"> Carrito de Compras</h2>
<div class="container my-4">

    <?PHP if (count($items)) { ?>
        <form action="actions/update_product_acc.php" method="POST">
        <div class="row justify-content-center">

       
        <div class="col-auto table">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col" >Producto</th>
                        <th scope="col" >Cantidad</th>
                        <th class="text-end" scope="col" >Precio unitario</th>
                        <th class="text-end" scope="col" >Subtotal</th>
                        <th scope="col" ></th>
                    </tr>
                </thead>
                <tbody>
                    <?PHP foreach ($items as $key => $item) { ?>
                        <tr>
                            <td class="align-middle text-center cartProd">
                                <img src="<?= Products::getImageUrlFromName($item['img']) ?>" alt="Imagen Ilustrativa de <?= htmlspecialchars($item['product'], ENT_QUOTES, 'UTF-8') ?>" class="img-fluid rounded">
                                <h3 class="h5"><?= htmlspecialchars($item['product'], ENT_QUOTES, 'UTF-8') ?></h3>
                            </td>
                            <td class="align-middle text-center cartCant">
                                    <div>
                                    <label for="q_<?= $key ?>" class="visually-hidden">Cantidad</label>
                                    <input type="number" class="form-control" value="<?= $item['cantidad'] ?>" id="q_<?= $key ?>" name="q[<?= $key ?>]">
                                    <input type="submit" value="Actualizar Cantidad" class="btn btnActCant">
                                </div>
                                </td>
                            <td class="text-end align-middle text-center">
                                <p class="h6 py-3">$<?= number_format((float)$item['precio'], 2, ",", ".") ?></p>
                            </td>
                            <td class="text-end align-middle text-center cartPrice">
                                <p class="h5 py-3">$<?= number_format($item['cantidad'] * $item['precio'], 2, ",", ".") ?></p>
                            </td>
                            <td class="text-end align-middle text-center divCartDel">
                                <a href="actions/remove_product_acc.php?id=<?= $key ?>" class="delete" data-toggle="modal" aria-label="Eliminar producto">
                                    <i class="bi bi-trash-fill biIcons" data-toggle="tooltip" title="" data-original-title="Delete"></i>
                                </a>
                            </td>
                        </tr>
                    <?PHP } ?>

                    <tr>
                        <td colspan="3" class="text-end">
                            <h3 class="h5 py-3">Total:</h3>
                        </td>
                        <td class="text-end">
                            <p class="h5 py-3">$<?= number_format($miCarrito->precio_total(), 2, ",", ".") ?></p>
                        </td>
                        <td></td>
                    </tr>
                </tbody>



            </table>
            </div>
            </div>


            <div class="d-flex justify-content-end gap-2">
                
                <a href="index.php?s=productList" role="button" class=" btn btnSeguirComprando"><i class="bi bi-arrow-left biIconsLight"></i>Seguir comprando</a>
                <a href="actions/clear_cart_acc.php" role="button" class="btn btnVaciar"><i class="bi bi-trash-fill biIcons" data-toggle="tooltip" title="" data-original-title="Delete"></i>Vaciar Carrito</a>
                <button type="submit" class="btn btnFinalizar" formaction="actions/checkout_acc.php">Finalizar Compra <i class="bi bi-arrow-right biIconsLight"></i></button>
            </div>

        </form>
    <?PHP } else { ?>
        <h3 class="text-center mb-5 text-danger">Su carrito esta vacío</h3>
    <?PHP } ?>

</div>