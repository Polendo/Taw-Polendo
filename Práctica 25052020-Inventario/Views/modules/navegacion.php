<?php
    if($_GET['action'] == 'salir'){
        header('location:index.php?action=ingresar');
    }
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="index.php?action=tablero" class="nav-link" data-widget="pushmenu"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
</nav>

<aside class="main-sidebar sidebar-dark-success elevation-4">
    <a href="index.php?action=tablero" class="bews/assets/dist/img/UPV.pngrand-link nav-success">
        <img src="vi" alt="Práctica 5 | TAW | UPV" class="brand-image img-square" style="opacity: .8">
        <span class="brand-text font-weight-light">Inventarios</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="Views/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>

            <div class="info">
                <a href="index.php?action=tablero" class="d-block">
                    <?php 
                        if(isset($_SESSION['nombre_usuario'])){
                            echo $_SESSION['nombre_usuario'];
                        }
                    ?>
                </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="index.php?action=tablero" class="nav-link">
                        <i class="nav-icon fas fa fa-tachometer-alt"></i>
                        <p>Tablero</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="index.php?action=usuarios" class="nav-link">
                        <i class="nav-icon fas fa fa-tachometer-alt"></i>
                        <p>Usuarios</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="index.php?action=inventario" class="nav-link">
                        <i class="nav-icon fas fa fa-tachometer-alt"></i>
                        <p>Inventario</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="index.php?action=categorias" class="nav-link">
                        <i class="nav-icon fas fa fa-tachometer-alt"></i>
                        <p>Categorias</p>
                    </a>
                </li>
            
            </ul>
        </nav>
    </div>
</aside>