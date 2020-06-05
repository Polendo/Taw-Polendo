<?php
    //CIERRA LA SESIÓN ACTUAL Y LIMPIA LA INFORMACIÓN ASOCIADA A ELLA
    session_destroy();
    ob_end_flush();
