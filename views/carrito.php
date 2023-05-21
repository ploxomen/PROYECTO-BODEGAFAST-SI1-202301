<!DOCTYPE html>
<html lang="es">

<head>
    <?php include("helpers/header.php") ?>
    <link rel="stylesheet" href="./../../public/css/agregarProducto.css">
    <link rel="stylesheet" href="./../public/css/carritoCompras.css">
    <script src="./../public/js/carritoCompras.js"></script>
    <title>Carrito de compras</title>
</head>

<body>
    <?php include("helpers/headerIndex.php"); ?>
    <main class="py-5" style="min-height: 715px;">
        <?php
            if(empty($carrito)){
        ?>
        <div class="container p-3">
            <h1 class="text-center titulo-principal-modulo my-4">CARRITO VACIO</h1>
            <div class="text-center my-3">
                <i class="fas fa-cart-arrow-down titulo-principal-modulo" style="font-size: 150px;"></i>
            </div>
            <p class="text-center my-4 text-secondary">
                Estimado cliente no se encontró ningún producto en el carrito, por favor agregar el producto en nuestra seccion de <strong>PRODUCTOS</strong>
            </p>
            <div class="text-center">
                <a href="<?php echo URL . '/listar/productos' ?>" class="btn btn-lg btn-primario-pg">
                    <i class="fab fa-product-hunt"></i>
                    Ir a los productos
                </a>
            </div>
        </div>
        <?php            
        }else{
        ?>
            <h1 class="text-center titulo-principal-modulo my-1"><i class="fas fa-shopping-cart"></i> MI CARRITO DE COMPRAS</h1>
            <div class="container">
                <div class="pasos pt-3 pb-4">
                    <div class="paso" id="btnPaso1" style="background-color: var(--color-principal);color:#fff;">
                        <span>1</span>
                        <div class="regla" style="width: 0;"></div>
                    </div>
                    <div class="paso" id="btnPaso2">
                        <span>2</span>
                        <div class="regla" style="width: 0;"></div>
                    </div>
                    <div class="paso" id="btnPaso3">
                        <span>3</span>
                    </div>
                </div>
                <div class="secciones">
                    <section class="my-2" id="seccion1">
                        <div class="pb-3">
                            <h3 class="text-center titulo-principal-modulo">Productos seleccionados</h3>
                        </div>
                        <div class="table-responsive my-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Bodega</th>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="contenidoCarrito">
                                    <?php
                                        foreach ($productos as $pk => $pv) {
                                            echo "<tr><td>".($pk+1)."</td>";
                                            echo "<td>".$pv['bodega']."</td>"; 
                                            echo "<td>".$pv['nombre']."</td>"; 
                                            echo "<td>S/ ".$pv['precio_venta']."</td>"; 
                                            echo "<td><input type='number' min='1' max='25' class='form-control form-control-sm change-valor-cantidad' data-producto='".$pv['id']."' value='".$pv['cantidad']."'></td>"; 
                                            echo "<td><span class='sub-total-tabla'>S/ ".number_format(floatval($pv['subtotal']),2)."</span></td>"; 
                                            echo "<td><button class='btn btn-sm btn-danger' data-producto='".$pv['id']."'><i class='fas fa-trash-alt'></i></button></td></tr>"; 
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end" style="font-size: 1.5rem;color:var(--color-principal)">
                            <b>Total: </b>
                            <strong class="info-costo-total">S/ <?php echo number_format(floatval($total),2) ?> </strong>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" id="btnSiguientePrimero"><i class="fa-regular fa-hand-point-right"></i> Siguiente</button>
                        </div>
                    </section>
                    <section class="my-3" id="seccion2" hidden>
                        <div class="m-auto" style="max-width: 500px;" id="alertaSession">
                            <?php
                            if(empty($tokenBodegafast)){
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    Por favor inicia sesión para seguir al ultimo paso
                                </div>
                            <?php
                            }else if(!empty($tokenBodegafast) && $data['rol'] != 'rol_usuario'){
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    Por favor inicia sesión como cliente para seguir al ultimo paso
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="pb-3">
                            <h3 class="text-center titulo-principal-modulo">Datos personales</h3>
                        </div>
                        <div class="mb-3">
                            <form class="row">
                                <div class="mb-2 col-12 col-md-6">
                                    <label for="txtNombres">Nombres</label>
                                    <input type="text" name="nombres" id="txtNombres" class="form-control form-control-lg" disabled value="<?php echo isset($data['nombres']) ? $data['nombres'] : '' ?>">
                                </div>
                                <div class="mb-2 col-12 col-md-6">
                                    <label for="txtApellidos">Apellidos</label>
                                    <input type="text" name="apellidos" id="txtApellidos" class="form-control form-control-lg" disabled value="<?php echo isset($data['apellidos']) ? $data['apellidos'] : '' ?>">
                                </div>
                                <div class="mb-2 col-12">
                                    <label for="txtDireccion">Dirección</label>
                                    <input type="text" name="direccion" id="txtDireccion" value="<?php echo isset($data['direccion']) ? $data['direccion'] : '' ?>" class="form-control form-control-lg" required>
                                </div>
                                <div class="mb-2 col-12 col-md-6">
                                    <label for="txtCelular">Celular</label>
                                    <input type="tel" name="celular" id="txtCelular" value="<?php echo isset($data['celular']) ? $data['celular'] : '' ?>" class="form-control form-control-lg" required>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-danger" id="btnAtrasSegundo"><i class="fa-regular fa-hand-point-left"></i> Atras</button>
                            <button class="btn btn-primary" id="btnSiguienteSegundo"><i class="fa-regular fa-hand-point-right"></i> Siguiente</button>
                        </div>
                    </section>
                    <section class="my-2" id="seccion3" hidden>
                        <div class="pb-3">
                            <h3 class="text-center titulo-principal-modulo">Finalizar compra</h3>
                        </div>
                        <form style="font-size: 1.2rem; max-width: 300px;" class="m-auto text-secondary mb-5">
                            <div>
                                <b>Total productos: </b>
                                <strong class="info-costo-total">S/ <?php echo number_format(floatval($total),2) ?></strong>
                            </div>
                            <div>
                                <b>Envío: S/ </b>
                                <strong>10.00</strong>
                            </div>
                            <div>
                                <b>Total a pagar: S/ </b>
                                <strong id="cantidadFinal"><?php echo number_format(floatval($total + 10),2)?></strong>
                            </div>
                            <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioCheckedDisabled" checked disabled>
                            <label class="form-check-label" for="flexRadioCheckedDisabled">
                                Pago contra entrega
                            </label>
                            </div>
                        </form>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-danger" id="btnAtrasTercero"><i class="fa-regular fa-hand-point-left"></i> Atras</button>
                            <button class="btn btn-secondary" id="btnCancelarTodo"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                            <button class="btn btn-primary" id="btnSiguienteFinalizar"><i class="fas fa-shopping-cart"></i> Comprar</button>
                        </div>
                    </section>
                </div>
            </div>
        <?php
        }
        ?>
    </main>
    <?php include("helpers/footerIndex.php"); ?>

</body>

</html>