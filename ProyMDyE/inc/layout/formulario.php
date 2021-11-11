<div class="campos">
            <div class="campo">
                <label for="idproducto">Barco:</label>
                <input 
                    type="text" 
                    placeholder="Id Barco" 
                    id="idproducto"
                    value="<?php echo (isset($producto["Producto"])) ? $producto["Producto"] : ""; ?>"
                >
            </div>
            <div class="campo">
                <label for="porigen">Origen:</label>
                <input 
                    type="text" 
                    placeholder="Puerto de origen" 
                    id="porigen"
                    value="<?php echo (isset($producto["porigen"])) ? $producto["porigen"] : ""; ?>"
                >
            </div>
            <div class="campo">
                <label for="pdestino">Destino:</label>
                <input 
                    type="text" 
                    placeholder="Puerto de destino" 
                    id="pdestino"
                    value="<?php echo (isset($producto["pdestino"])) ? $producto["pdestino"] : ""; ?>"
                >
            </div>
</div>
<div class="campo enviar">
    <?php
        $textBtn = (isset($producto['pdestino'])) ? 'Guardar' : 'Añadir';
        $accion = (isset($producto['pdestino'])) ? 'editar' : 'crear';
    ?>
    <input type="hidden" id="accion" value="<?php echo $accion; ?>">
    <?php if( isset( $producto['id'] )) { ?>
        <input type="hidden" id="id" value="<?php echo $producto['id']; ?>">
    <?php } ?>
    <input type="submit" value="<?php echo $textBtn; ?>">
 </div>