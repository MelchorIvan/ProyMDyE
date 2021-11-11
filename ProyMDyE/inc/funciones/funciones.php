<?php

function obtenerProductos() {
    include 'bd.php';
    try {
        return $db->query("SELECT id, Producto, porigen, pdestino FROM productos");
    } catch(Exception $e) {
        echo "Error!!" . $e->getMessage() . "<br>";
        return false;
    }
}
//Obtniene un contacto y obtiene su id
function obtenerProducto($id) {
    include 'bd.php';
    try {
        return $db->query("SELECT id, Producto, porigen, pdestino FROM productos WHERE id = $id");
    } catch(Exception $e) {
        echo "Error!!" . $e->getMessage() . "<br>";
        return false;
    }
}
//Calcular ruta más corta
function shPath($porigen, $pdestino){
    /*"francia" =>array
   (
    "nombre"=>"Francia",
    "lengua"=>"Francés",
    "moneda"=>"Franco"
    )
 );*/
        $porigenAux = 0;
        $pdestinoAux = 0;
        $puertos=array();
        //array(0,16,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0), //A
        $puertos[1][2] = 16;
        //array(16,0,3,6,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ,0,0), //B
        $puertos[2][1] = 16;
        $puertos[2][3] = 3;
        $puertos[2][4] = 6;
        //array(0,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0), //C
        $puertos[3][2] = 3;
        //array(0,6,0,0,19,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0), //D
        $puertos[4][2] = 6;
        $puertos[4][5] = 19;
        //array(0,0,0,19,0,1,7,21,0,0,0,0,0,0,0,0,0,0,0,0), //E
        $puertos[5][4] = 19;
        $puertos[5][6] = 1;
        $puertos[5][7] = 7;
        $puertos[5][8] = 21;
        //array(0,0,0,0,1,0,0,0,0,11,0,0,0,0,0,0,0,0,0,288834), //F
        $puertos[6][5] = 1;
        $puertos[6][10] = 11;
        $puertos[6][20] = 23;
        //array(0,0,0,0,7,0,0,0,0,0,0,14,0,0,0,0,0,0,0,0), //G <
        $puertos[7][5] = 7;
        $puertos[7][12] = 14;
        //array(0,0,0,0,21,0,0,0,19,25,0,0,0,0,0,0,0,0,0,0), //H <
        $puertos[8][5] = 21;
        $puertos[8][9] = 19;
        $puertos[8][10] = 25;
        //array(0,0,0,0,0,0,19,0,8,0,0,0,0,0,0,0,0,13,0,0), //I <
        $puertos[9][8] = 19;
        $puertos[9][10] = 8;
        $puertos[9][18] = 13;
        //array(0,0,0,0,0,11,0,25,8,0,4,17,0,0,0,0,0,0,0,24), //J <
        $puertos[10][6] = 11;
        $puertos[10][8] = 25;
        $puertos[10][9] = 8;
        $puertos[10][11] = 4;
        $puertos[10][12] = 17;
        $puertos[10][20] = 24;
        //array(0,0,0,0,0,0,0,0,0,4,0,13,5,0,0,9,2,0,0,0), //K <
        $puertos[11][10] = 4;
        $puertos[11][12] = 13;
        $puertos[11][13] = 5;
        $puertos[11][16] = 9;
        $puertos[11][17] = 2;
        //array(0,0,0,0,0,0,14,0,0,17,13,0,22,0,0,0,0,0,0,0), //L <
        $puertos[12][7] = 14;
        $puertos[12][10] = 17;
        $puertos[12][11] = 13;
        $puertos[12][13] = 22;
        //array(0,0,0,0,0,0,0,22,0,0,5,0,0,0,21,0,0,0,0,0), //M <
        $puertos[13][11] = 5;
        $puertos[13][12] = 22;
        $puertos[13][15] = 21;
        //array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,16,0,0,0,0,0), //N <
        $puertos[14][15] = 16;
        //array(0,0,0,0,0,0,0,0,0,0,0,0,21,16,0,19,0,0,0,0), //O <
        $puertos[15][13] = 21;
        $puertos[15][14] = 16;
        $puertos[15][16] = 19;
        //array(0,0,0,0,0,0,0,0,0,0,9,0,0,0,19,0,0,0,0,0), //P <
        $puertos[16][11] = 9;
        $puertos[16][15] = 19;
        //array(0,0,0,0,0,0,0,0,0,2,0,0,0,0,0,0,0,0,0,0), //Q <
        $puertos[17][11] = 2;
        //array(0,0,0,0,0,0,0,0,13,0,0,0,0,0,0,0,0,0,25,0), //R < 
        $puertos[18][9] = 13;
        $puertos[18][19] = 25;
        //array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,25,0,0), //S <
        $puertos[19][18] = 25;
       // array(0,0,0,0,0,23,0,0,0,24,0,0,0,0,0,0,0,0,0,0) //T
        $puertos[20][6] = 23;
        $puertos[20][10] = 24;
    if($porigen == "A"){$porigenAux = 1;}
    elseif($porigen == "B"){$porigenAux = 2;}
    elseif($porigen == "C"){$porigenAux = 3;}
    elseif($porigen == "D"){$porigenAux = 4;}
    elseif($porigen == "E"){$porigenAux = 5;}
    elseif($porigen == "F"){$porigenAux = 6;}
    elseif($porigen == "G"){$porigenAux = 7;}
    elseif($porigen == "H"){$porigenAux = 8;}
    elseif($porigen == "I"){$porigenAux = 9;}
    elseif($porigen == "J"){$porigenAux = 10;}
    elseif($porigen == "K"){$porigenAux = 11;}
    elseif($porigen == "L"){$porigenAux = 12;}
    elseif($porigen == "M"){$porigenAux = 13;}
    elseif($porigen == "N"){$porigenAux = 14;}
    elseif($porigen == "O"){$porigenAux = 15;}
    elseif($porigen == "P"){$porigenAux = 16;}
    elseif($porigen == "Q"){$porigenAux = 17;}
    elseif($porigen == "R"){$porigenAux = 18;}
    elseif($porigen == "S"){$porigenAux = 19;}
    elseif($porigen == "T"){$porigenAux = 20;}
    else{echo "Error";}

    if($pdestino == "A"){$pdestinoAux = 1;}
    elseif($pdestino == "B"){$pdestinoAux = 2;}
    elseif($pdestino == "C"){$pdestinoAux = 3;}
    elseif($pdestino == "D"){$pdestinoAux = 4;}
    elseif($pdestino == "E"){$pdestinoAux = 5;}
    elseif($pdestino == "F"){$pdestinoAux = 6;}
    elseif($pdestino == "G"){$pdestinoAux = 7;}
    elseif($pdestino == "H"){$pdestinoAux = 8;}
    elseif($pdestino == "I"){$pdestinoAux = 9;}
    elseif($pdestino == "J"){$pdestinoAux = 10;}
    elseif($pdestino == "K"){$pdestinoAux = 11;}
    elseif($pdestino == "L"){$pdestinoAux = 12;}
    elseif($pdestino == "M"){$pdestinoAux = 13;}
    elseif($pdestino == "N"){$pdestinoAux = 14;}
    elseif($pdestino == "O"){$pdestinoAux = 15;}
    elseif($pdestino == "P"){$pdestinoAux = 16;}
    elseif($pdestino == "Q"){$pdestinoAux = 17;}
    elseif($pdestino == "R"){$pdestinoAux = 18;}
    elseif($pdestino == "S"){$pdestinoAux = 19;}
    elseif($pdestino == "T"){$pdestinoAux = 20;}
    else{echo "Error";}

    Dijkstra($puertos, $porigenAux, $pdestinoAux);
    return $puertos;
}
function Dijkstra($puertos, $porigenAux, $pdestinoAux){
    $S1 = array();//the nearest path with its parent and weight
    $Q1 = array();//the left nodes without the nearest path

    foreach(array_keys($puertos) as $val) $Q1[$val] = 99999;
    $Q1[$porigenAux] = 0;

    while(!empty($Q1)){
        $min = array_search(min($Q1), $Q1);//the most min weight
        if($min == $pdestinoAux) break;
        foreach($puertos[$min] as $key=>$val) if(!empty($Q1[$key]) && $Q1[$min] + $val < $Q1[$key]) {
            $Q1[$key] = $Q1[$min] + $val;
            $S1[$key] = array($min, $Q1[$key]);
        }
        unset($Q1[$min]);
    }
    if (!array_key_exists($pdestinoAux, $S1)) {
        echo "No hay camino";
        return;
    }

    $path = array();
    $pathAux = array();
    $pos = $pdestinoAux;
    $cont = 0;
    $pos = $pdestinoAux;
    while($pos != $porigenAux){
	    $path[] = $pos;
	    $pos = $S1[$pos][0];
        $cont++;
    }
    $path[] = $porigenAux;
    $path = array_reverse($path);
    $contAux = 0;
    echo "La distancia es: ".$S1[$pdestinoAux][1]. "<br />";
    while($contAux < $cont + 1)
    {
        puertosSwitch($path[$contAux]);
        if($contAux < $cont || $contAux == 2){
            puertosSwitch("Flecha");
        }
        $contAux++;
    }
}

function puertosSwitch($puerto)
{
    switch($puerto)
    {
        case "1":
            echo '<img src ="images/A.png" alt=""width="10%"/>';
            break;
        case "2":
            echo '<img src ="images/B.png" alt=""width="10%"/>';
            break;
        case "3":
            echo '<img src ="images/C.png" alt=""width="10%"/>';
            break;
        case "4":
            echo '<img src ="images/D.png" alt=""width="10%"/>';
            break;
        case "5":
            echo '<img src ="images/E.png" alt=""width="10%"/>';
            break;
        case "6":
            echo '<img src ="images/F.png" alt=""width="10%"/>';
            break;
        case "7":
            echo '<img src ="images/G.png" alt=""width="10%"/>';
            break;
        case "8":
            echo '<img src ="images/H.png" alt=""width="10%"/>';
            break;
        case "9":
            echo '<img src ="images/I.png" alt=""width="10%"/>';
            break;
        case "10":
            echo '<img src ="images/J.png" alt=""width="10%"/>';
            break;
        case "11":
            echo '<img src ="images/K.png" alt=""width="10%"/>';
            break;
        case "12":
            echo '<img src ="images/L.png" alt=""width="10%"/>';
            break;
        case "13":
            echo '<img src ="images/M.png" alt=""width="10%"/>';
            break;
        case "14":
            echo '<img src ="images/N.png" alt=""width="10%"/>';
            break;
        case "15":
            echo '<img src ="images/O.png" alt=""width="10%"/>';
            break;
        case "16":
            echo '<img src ="images/P.png" alt=""width="10%"/>';
            break;
        case "17":
            echo '<img src ="images/Q.png" alt=""width="10%"/>';
            break;
        case "18":
            echo '<img src ="images/R.png" alt=""width="10%"/>';
            break;
        case "19":
            echo '<img src ="images/S.png" alt=""width="10%"/>';
            break;
        case "20":
            echo '<img src ="images/T.png" alt=""width="10%"/>';
            break;
        case "Flecha":
            echo '<img src ="images/ZFlecha.png" alt=""width="7%"/>';
            break;
        default:
            echo "hola";
            break;
    }
}
