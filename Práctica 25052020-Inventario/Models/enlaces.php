<?php

class Paginas{

    public function enlacesPaginasModel($enlaces){
        if($enlaces == 'ingresar' || $enlaces == 'usuarios' || 
           $enlaces == 'inventario' || $enlaces == 'categorias' ||
           $enlaces == 'tablero' || $enlaces == 'ventas' ||
           $enlaces == 'salir'){

                $module = 'Views/modules/'.$enlaces.'.php';
        }else if($enlaces == 'index'){
            $module = 'Views/modules/tablero.php';
        }else{
            $module = 'Views/modules/tablero.php';
        }

        return $module;

        //INCLUIR LAS URL DE LAS VISTAS 
    }
}