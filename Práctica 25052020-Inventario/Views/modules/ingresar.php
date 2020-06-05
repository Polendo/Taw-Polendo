<div class="login-box">
    <div class="login-logo">
        <a href="index.php"><b>Sistema de</b>Inventarios</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Login</p>
            <form method="POST">
                
                <div class="input-group mb-3">
                    <input type="text" name="txtUsuario" class="form-control" placeholder="Username">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="txtContraseña" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block btn-flat" type="submit">Iniciar Sesión</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<?php 
    $ingreso = new MvcController();
    $ingreso ->inicioDeSesion();

    if(isset($_GET['res'])){
        if($_GET['res'] == 'fallo'){
            echo 'Fallo al ingresar';
        }
    }

    if(isset($_GET['salir'])){
        if($_GET['salir'] == '1'){
            echo 'Ha cerrado sesión exitosamente';
        }
    }
    ?>