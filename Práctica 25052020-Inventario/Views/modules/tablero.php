<?php
//SE VERIFICA QUE EXISTE UNA SESION, EN CASO DE QUE NO SEA ASÍ, SE MUESTRA EL LOGIN
    if(!isset($_SESSION['validar'])){
        header('location:index.php?action=ingresar');
        exit();
    }

    //SE LLAMA AL CONTROLADOR QUE MUESTRA LAS TARJETAS CON LA INFORMACIÓN QUE SE OBTIENE DEL SISTEMA (# DE VENTAS, # DE USUARIOS, # DE PRODUCTOS, # DE CATEGORIAS)
    $tablero = new MvcController();
    $tablero -> contarFilas();