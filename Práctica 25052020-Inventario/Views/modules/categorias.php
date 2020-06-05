<?php 
    if(!isset($_SESSION['validar'])){
        header('location:index.php?action=ingresar');
        exit();
    }

    $categorias = new MvcController();
    $categorias->insertarCategoryController();
    $categorias->actualizarCategoryController();
    $categorias->eliminarCategoryController();

    if(isset($_GET['registrar'])){
        $categorias->registrarCategoryController();
    }else if(isset($_GET['idCategoryEditar'])){
        $categorias->editarCategoryController();
    }
?>

<div class="container-fluid">
    <div class="row mb-3">

    </div>
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Categorías</h3>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a href="index.php?action=categorias&registrar" class="btn btn-info">Agregar Nueva Categoría</a>
                </div>
            </div>

            <div class="dataTables_wrapper dt-bootstrap4" id="example2-wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="table-success">
                                <tr>
                                    <th>¿Editar?</th>
                                    <th>¿Eliminar?</th>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Fecha de Inserción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $categorias->vistaCategoriesController();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>