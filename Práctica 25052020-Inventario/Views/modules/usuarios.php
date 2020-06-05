<?php
    if(isset($_SESSION['validar'])){
        header('location:index.php?action=ingresar');
        exit();
    }

    $usuarios = new MvcController();
    $usuarios->insertarUserContoller();
    $usuarios->actualizarUserController();
    $usuarios->eliminarUserController();

    if(isset($_GET['registrar'])){
        $usuarios->registrarUserController();
    }else if($_GET['idUserEditar']){
        $usuarios->editarUserController();
    }

?>

<div class="container-fluid">
    <div class="row mb-3"></div>
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Usuarios</h3>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a href="index.php?action=usuarios&registrar" class="btn btn-info">Agregar nuevo usuario</a>
                </div>
            </div>

            <div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-hover m-0 table-bordered table-striped">
                            <thead class="table-info">
                                <tr>
                                    <th>¿Editar?</th>
                                    <th>¿Eliminar?</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Usuario</th>
                                    <th>Correo electrónico</th>
                                    <th>Fecha de inserción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $usuarios->vistaUsersController();

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>