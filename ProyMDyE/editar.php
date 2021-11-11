<?php 
    include 'inc/layout/header.php';
    include 'inc/funciones/funciones.php'; 
    /*echo "<pre>";
    var_dump($_GET);
    echo "</pre";*/
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    //var_dump($id);
    if(!$id) {
        die('ID no válido');
    } 
    $resultado = obtenerProducto($id);
    $producto = $resultado->fetch_assoc();
?>

<div class="contenedor-barra">
    <div class="contenedor barra">
        <a href="index.php" class="btn volver"><i class="fas fa-arrow-left"></i></a>
        <h1>Editar Barco</h1>
    </div>
</div>

<div class="bg-amarillo contenedor sombra">
    <form id="producto" action="#">
        <legend>Edite el barco</span></legend>
        <?php include 'inc/layout/formulario.php'; ?>
    </form>
</div>


<?php include 'inc/layout/footer.php'; ?>