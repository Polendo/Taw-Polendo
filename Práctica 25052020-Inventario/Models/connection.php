<?php
    class Connection{
        public function conectar(){
            $link = new PDO('mysql:host=localhost;dbname=inventario;',"root","");
            return $link;
        }
    }