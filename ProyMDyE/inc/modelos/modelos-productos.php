<?php
//error_reporting(E_ALL ^ E_NOTICE);

if(isset($_POST['accion'])){
    if($_POST['accion'] == 'crear')
    {
        require_once('../funciones/bd.php');

        $idproducto = filter_var($_POST['idproducto'], FILTER_SANITIZE_STRING);
        $puertoOrigen = filter_var($_POST['puertoOrigen'], FILTER_SANITIZE_STRING);
        $puertoDestino = filter_var($_POST['puertoDestino'], FILTER_SANITIZE_STRING);
        /*$idproducto = filter_var($_POST['idproducto'], FILTER_SANITIZE_STRING);
        $porigen = filter_var($_POST['porigen'], FILTER_SANITIZE_STRING);
        $pdestino = filter_var($_POST['pdestino'], FILTER_SANITIZE_STRING);*/
        

        try {
            $stmt = $db->prepare("INSERT INTO productos (Producto, porigen, pdestino) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $idproducto, $puertoOrigen, $puertoDestino);
            $stmt->execute();
            if($stmt->affected_rows == 1) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'datos' => array(
                        'idproducto' => $idproducto,
                        'puertoOrigen' => $puertoOrigen,
                        'puertoDestino' => $puertoDestino,
                        'id_insertado' => $stmt->insert_id
                    )
                );
            }
            $stmt->close();
            $db->close();
        }catch(Exception $e) {
            $respuesta = array('error' => $e->getMessage());
        }
        echo json_encode($respuesta);
    }
    //echo json_encode($respuesta);
}
if (isset($_GET['accion'])){
    if($_GET['accion'] == 'borrar') {
        //echo json_encode($_GET);
        require_once('../funciones/bd.php');
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        try {
            $stmt = $db->prepare("DELETE FROM productos WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            if($stmt->affected_rows == 1) {
                $respuesta = array('respuesta' => 'correcto');
            }
            $stmt->close();
            $db->close();
        } catch(Exception $e){
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }
        //echo json_encode($respuesta);
    }
    echo json_encode($respuesta);
}
if(isset($_POST['accion']) == 'editar') {
    //echo json_encode($_POST);

    require_once('../funciones/bd.php');
    //Validación de entradas
    $idproducto = filter_var($_POST['idproducto'], FILTER_SANITIZE_STRING);
    $puertoOrigen = filter_var($_POST['puertoOrigen'], FILTER_SANITIZE_STRING);
    $puertoDestino = filter_var($_POST['puertoDestino'], FILTER_SANITIZE_STRING);
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    try{
        $stmt = $db->prepare("UPDATE productos SET Producto = ?, porigen = ?, pdestino = ? WHERE id = ?");
        $stmt->bind_param("sssi", $idproducto,  $puertoOrigen,  $puertoDestino, $id);
        $stmt->execute();
        if($stmt->affected_rows == 1){
             $respuesta = array(
                  'respuesta' => 'correcto'
             );
        } else {
             $respuesta = array(
                  'respuesta' => 'error'
             );
        }
        $stmt->close();
        $db->close();
   } catch(Exception $e){
        $respuesta = array(
             'error' => $e->getMessage()
        );
   }
   echo json_encode($respuesta);
}
