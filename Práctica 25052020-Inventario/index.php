<?php
    //Se activa el almacenamiento en el buffer para poder acceder a los valores guardados en los arreglos asociados $_GET y $_SESSION sin ningun problema
    ob_start();

    //Llamada al archivo que tiene los controladores y modelos que se necesitan para que el sistema funcione correctamente
    require_once 'Models/enlaces.php';
    require_once 'Models/crud.php';
    require_once 'Controllers/controller.php';

    //creamos un objeto

    $mvc = new MvcController();

    //Mostrar la función o método "página" disponible en controllers/controller.php 

    $mvc -> plantilla();

?>