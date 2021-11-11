<?php 
include 'inc/funciones/funciones.php';
include 'inc/layout/header.php';  
//Iván Melchor Santiago
//José Antonio Cortés Olmos
//Karen Iveth Plata Hernández
//Edgar Hernández Millan
//Luis Enrique Contreras Vázquez
?>


<div class="contenedor-barra">
     <h1>Rutas marítimas</h1>
</div>

<div class="bg-amarillo contenedor sombra">
    <form id="producto" action="#">
        <legend>Añada un barco <span>Todos los campos son obligatorios</span></legend>
        <?php include 'inc/layout/formulario.php'; ?>
    </form>
</div>
<div class="bg-puertos contenedor sombra productos">
    <div class="impuertos">
        <h2>Puertos disponibles</h2>
        <img src ="images/Puertosgral.png" alt=""width="100%"/>
    </div>
</div>
<div class="bg-productos contenedor sombra productos">
    <div class="contenedor-productos">
        <h2>Barcos</h2>

        <input type="text" id="buscar" class="buscador sombra" placeholder="Buscar producto">
        <p class="total-productos"><span>2</span> Barcos</p>
        
        <div class="contenedor-tabla">
            <table id="listado-productos" class="listado-productos">
                <thead>
                    <tr>
                        <th>Barco</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $productos = obtenerProductos(); 
                        //var_dump($productos);
                            if($productos->num_rows){
                                 foreach($productos as $Producto) { ?>

                                <tr>
                                    <td><?php echo $Producto['Producto']; ?></td>
                                    <td><?php echo $Producto['porigen']; ?></td>
                                    <td><?php echo $Producto['pdestino']; ?></td>
                                    <td>
                                        <a class="btn-editar btn" href="editar.php?id=<?php echo $Producto['id']; ?>">
                                            <i class="fas fa-pen-square"></i>
                                        </a>

                                        <button data-id="id=<?php echo $Producto['id']; ?>"type="button" class="btn-borrar btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <a class="btn-ruta btn" href="calcrutas.php?id=<?php echo $Producto['id']; ?>">
                                            <i class="fas fa-ship"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                    }  ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include 'inc/layout/footer.php'; ?>
