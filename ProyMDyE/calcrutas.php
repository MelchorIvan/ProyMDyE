<?php 
    include 'inc/layout/header.php';
    include 'inc/funciones/funciones.php'; 
    error_reporting(0);
    /*echo "<pre>";
    var_dump($_GET);
    echo "</pre";*/
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    //var_dump($id);
    if(!$id) {
        die('ID no válido');
    } 
    //$oferta=1;
    //$demanda=1;
    $resultado = obtenerProducto($id);
    $producto = $resultado->fetch_assoc();
?>

<div class="contenedor-barra">
    <div class="contenedor barra">
        <a href="index.php" class="btn volver"><i class="fas fa-arrow-left"></i></a>
        <h1>Rutas marítimas</h1>
    </div>
</div>

<div class="bg-puertos contenedor sombra productos">
    <h1>Ruta Optimizada</h1>
        <div class="impuertos">
            <div class="campo">
                    <h2> Barco:  <?php echo ($producto["Producto"]) ?>   
                      Puerto de origen:   <?php echo ($producto["porigen"]) ?>
                      Puerto de destino:  <?php echo ($producto["pdestino"]) ?>
                      
                      
                    </h2>
            </div>
        </div>
        <div class="A">
                    <h2><?php 
                        //$puertos=shPath($producto["porigen"],$producto["pdestino"]);
                        $puertos=shPath($producto["porigen"],$producto["pdestino"]);
                        //$imgInicial = $producto["porigen"];
                        //Dijkstra();
                        //echo $puertos["$imgInicial"][9];  
                        //<?php puertosSwitch($imgInicial)
                      ?></h2>
        </div>
    
    <img src ="images/Puertosgral.png" alt=""width="100%"/>
</div>

<?php include 'inc/layout/footer.php'; ?>