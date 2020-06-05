<?php
    class MvcController{
        //Muestra una plantilla al usuario

        public function plantilla(){
            include 'Views/template.php';
        }

        //Mostrar enlaces

        public function enlacesPaginasController(){

            if(isset($_GET['action'])){
                $enlaces = $_GET['action'];
            }else{
                $enlaces = 'index';
            }

            $respuesta = Paginas::enlacesPaginasModel($enlaces);
            include $respuesta;
        }

        public function inicioDeSesion(){
            if(isset($_POST['txtUsuario']) && isset($_POST['txtContraseña'])){
                $datos = array(
                    "usuario" => $_POST['txtUsuario'],
                    "contraseña" => $_POST['txtContraseña']
                );

                $respuesta = Datos::ingresoUsuarioModel($datos);

                if($respuesta['usuario'] == $_POST['txtUsuario'] && $respuesta['contrasena'] == $_POST['txtContraseña']){
                    session_start();
                    $_SESSION['validar'] = true;
                    $_SESSION['usuario'] = $respuesta['nombre_usuario'];
                    $_SESSION['id'] = $respuesta['id'];
                    header('location:index.php?action=tablero');
                    //echo 'bien hecho';
                }else{
                    //echo 'mal hecho';
                    header('location:index.php?action=fallo&res=fallo');
                }
                

            }
        }

        public function vistaUsersController(){
            $respuesta = Datos::vistaUserModel('users');

            foreach($respuesta as $row => $item){
                echo '
                    <tr>
                        <td>
                            <a href="index.php?action=usuarios&idUserEditar='.$item['id'].'" class="btn btn-warning btn-sm btn-icon" 
                            title="Editar" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                            
                        </td>
                        <td>
                            <a href="index.php?action=usuarios&idBorrar='.$item['id'].'" class="btn btn-danger btn-sm btn-icon" 
                            title="Eliminar" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                        </td>
                        
                        <td>'.$item['firstname'].'</td>
                        <td>'.$item['lastname'].'</td>
                        <td>'.$item['user_name'].'</td>
                        <td>'.$item['user_email'].'</td>
                        <td>'.$item['date_added'].'</td>
                    </tr>';
            }
        }


        public function registrarUserController(){
            ?>
            <div class="col-md-6 mt-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4><b>Registro</b> de Usuarios</h4>                        
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?action=usuarios">
                            <div class="form-group">
                                <label for="nusuariotxt">Nombre: </label>
                                <input class="form-control" type="text" name="nusuariotxt" id="nusuariotxt" placeholder="Ingrese el nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="ausuariotxt">Apellido: </label>
                                <input class="form-control" type="text" name="ausuariotxt" id="ausuariotxt" placeholder="Ingrese el apellido" required>
                            </div>
                            <div class="form-group">
                                <label for="usuariotxt">Usuario: </label>
                                <input class="form-control" type="text" name="usuariotxt" id="usuariotxt" placeholder="Ingrese el usuario" required>
                            </div>
                            <div class="form-group">
                                <label for="ucontratxt">Contraseña: </label>
                                <input class="form-control" type="password" name="ucontratxt" id="ucontratxt" placeholder="Ingrese la contraseña" required>
                            </div>
                            <div class="form-group">
                                <label for="uemailtxt">Correo Electrónico: </label>
                                <input class="form-control" type="email" name="uemailtxt" id="uemailtxt" placeholder="Ingrese el correo electrónico" required>
                            </div>
                            <button class="btn btn-primary" type="submit">Agregar</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php    
        }


        // este controlador sirve para insertar el usuario que se aca de ingresar y notificar si se realiza
        // dicho actividad o si hubo algun error, en el case de la contraseña, primero que nada se tendra
        // que encriptar mediante el algoritmo mediante el algoritmo hash y la funcion password_hash y se guarda
        // para posteriormente realizar la insercion 
        public function insertarUserContoller(){
            if(isset($_POST["nusuariotxt"])){
                $_POST["ucontratxt"] = password_hash($_POST["ucontratxt"], PASSWORD_DEFAULT);

                $datosController = array("nusuario"=>$_POST["nusuariotxt"],
                                        "ausuario"=>$_POST["ausuariotxt"],
                                        "usuario"=>$_POST["usuariotxt"],
                                        "contra"=>$_POST["ucontratxt"],
                                        "email"=>$_POST["uemailtxt"]);
                
                $respuesta = Datos::insertarUserModel($datosController,"users");

                if($respuesta = "success"){
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-success alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    Exito!
                                </h5>
                                Usuario guardado
                            </div>
                        </div>
                    
                    ';
                }else{
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-ban"></i>
                                    Error!
                                </h5>
                                Se ha producido un error al momento de agregrar el usuario
                            </div>
                        </div>
                    ';
                }
            }
        }


        /*-- Este controlador se encarga de mostrar el formulario al usuario para editar sus datos, la contraseña no se carga debido a que como esta encriptada, no es optimo mostrarle al usuario su contraseña como una cadena de caracteres y se deja en blanco, pero se verifica al momento de hacer una modifica que haya ingresado una contraseña, si no es el caso entonces no se podrá ejecutar la modificación y cada que se quiera hacer una modificación a un determinado usuario, se deberá ingresar tambien una nueva contraseña --*/
        public function editarUserController() {
            $datosController = $_GET["idUserEditar"];
            //envío de datos al mododelo
            $respuesta = Datos::editarUserModel($datosController,"users");
            ?>
            <div class="col-md-6 mt-3">
                <div class="card card-warning">
                    <div class="card-header">
                        <h4><b>Editor</b> de Usuarios</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?action=usuarios">
                            <div class="form-group">
                                <input type="hidden" name="idUserEditar" class="form-control" value="<?php echo $respuesta["id"]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nusuariotxtEditar">Nombre: </label>
                                <input class="form-control" type="text" name="nusuariotxtEditar" id="nusuariotxtEditar" placeholder="Ingrese el nuevo nombre" value="<?php echo $respuesta["nusuario"]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="ausuariotxtEditar">Apellido: </label>
                                <input class="form-control" type="text" name="ausuariotxtEditar" id="ausuariotxtEditar" placeholder="Ingrese el nuevo apellido" value="<?php echo $respuesta["ausuario"]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="usuariotxtEditar">Usuario: </label>
                                <input class="form-control" type="text" name="usuariotxtEditar" id="usuariotxtEditar" placeholder="Ingrese el nuevo usuario" value="<?php echo $respuesta["usuario"]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="contratxtEditar">Contraseña: </label>
                                <input class="form-control" type="password" name="contratxtEditar" id="contratxtEditar" placeholder="Ingrese la nueva contraseña" required>
                            </div>
                            <div class="form-group">
                                <label for="uemailtxtEditar">Correo Electrónico: </label>
                                <input class="form-control" type="email" name="uemailtxtEditar" id="uemailtxtEditar" placeholder="Ingrese el nuevo correo electrónico" value="<?php echo $respuesta["email"]; ?>" required>
                            </div>
                            <button class="btn btn-primary" type="submit">Editar</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }

        
        public function actualizarUserController() {
            if(isset($_POST["nusuariotxtEditar"])){
                $_POST["contratxtEditar"]= password_hash($_POST["contratxtEditar"], PASSWORD_DEFAULT);

                $datosController = array("id" => $_POST["idUserEditar"],
                                        "nusuario" => $_POST["nusuariotxtEditar"],
                                        "ausuario" => $_POST["ausuariotxtEditar"],
                                        "usuario" => $_POST["usuariotxtEditar"],
                                        "contra" => $_POST["contratxtEditar"],
                                        "email" => $_POST["emailtxtEditar"],
                                    );
                    
                $respuesta = Datos::actualizarUserModel($datosController, "users");

                if($respuesta = "success"){
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-success alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    Exito!
                                </h5>
                                Usuario actualizado con exito
                            </div>
                        </div>
                    
                    ';
                }else{
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-ban"></i>
                                    Error!
                                </h5>
                                Se ha producido un error al momento de agregrar el usuario
                            </div>
                        </div>
                    ';
                }

            }
        }


        // este controlador sirve para eliminar el usuario que se acaba de ingresar y notifica
        // si se realizo dicha actividad o si hubo algun error
        public function eliminarUserController() {
            if(isset($_POST["idBorrar"])){
                $datosController = $_GET["idBorrar"];
                $respuesta = Datos::eliminarUserModel($datosController, "users");

                if($respuesta = "success"){
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-success alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    Exito!
                                </h5>
                                Usuario eliminado con exito
                            </div>
                        </div>
                    
                    ';
                }else{
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-ban"></i>
                                    Error!
                                </h5>
                                Se ha producido un error al momento de agregrar el usuario
                            </div>
                        </div>
                    ';
                }
            }
        }

        // CONTROLADORES PARA EL TABLERO //
        /*-- Este controlador sirve para mostrarle al usuario las cajas donde se tiene información sobre los usuarios, productos y ventas registradas, así como los movimientos que se tienen en el historial (altas/bajas de productos) y las ganancias que se tienen de acuerdo a todas las ventas --*/
        public function contarFilas () {
            $respuesta_users = Datos::contarFilasModel("users");
            $respuesta_products = Datos::contarFilasModel("productos");
            $respuesta_categories = Datos::contarFilasModel("categorias");
            $respuesta_historial = Datos::contarFilasModel("historial");
            
            echo '
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>'.$respuesta_users["filas"].'</h3>
                            <p>Total de Usuarios</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-address-card"></i>
                        </div>
                        <a class="small-box-footer" href="index.php?action=usuarios">Más <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3>'.$respuesta_products["filas"].'</h3>
                            <p>Total de Productos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <a class="small-box-footer" href="index.php?action=inventario">Más <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-olive">
                        <div class="inner">
                            <h3>'.$respuesta_categories["filas"].'</h3>
                            <p>Total de Categorías</p>
                        </div>
                        <div class="icon">
                        <i class="fas fa-tag"></i>
                        </div>
                        <a class="small-box-footer" href="index.php?action=categorias">Más <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3>'.$respuesta_historial["filas"].'</h3>
                            <p>Movimientos en el Inventario</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-archive"></i>
                        </div>
                        <a class="small-box-footer" href="index.php?action=inventario">Más <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>';
        }

        
        public function vistaProductsController(){
            $respuesta = Datos::vistaProductsModel('productos');

            foreach($respuesta as $row => $item){
                echo '
                    <tr>
                        <td>
                            <a href="index.php?action=usuarios&idUserEditar='.$item['id'].'" class="btn btn-warning btn-sm btn-icon" 
                            title="Editar" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                            
                        </td>
                        <td>
                            <a href="index.php?action=usuarios&idBorrar='.$item['id'].'" class="btn btn-danger btn-sm btn-icon" 
                            title="Eliminar" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                        </td>
                        
                        <td>'.$item['id'].'</td>
                        <td>'.$item['codigo'].'</td>
                        <td>'.$item['producto'].'</td>
                        <td>'.$item['fecha'].'</td>
                        <td>'.$item['precio'].'</td>
                        <td>'.$item['stock'].'</td>
                        <td>'.$item['categoria'].'</td>
                        <td><a href="index.php?action=inventario&idProductAdd='.$item['id'].'" class="btn btn-danger btn-sm btn-icon"
                        title="Eliminar" data-toggle="tooltip"><class="fa fa-edit"></i></a></td>"  

                    </tr>';
            }
        }

        public function registrarProductController(){
            ?>
            <div class="col-md-6 mt-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4><b>Registro</b> de Productos</h4>                        
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?action=inventarios">
                            <div class="form-group">
                                <label for="codigotxt">Código: </label>
                                <input class="form-control" type="text" name="codigotxt" id="codigotxt" placeholder="Código del producto" required>
                            </div>
                            <div class="form-group">
                                <label for="ausuariotxt">Nombre: </label>
                                <input class="form-control" type="text" name="nombretxt" id="nombretxt" placeholder="Nombre del producto" required>
                            </div>
                            <div class="form-group">
                                <label for="usuariotxt">Precio: </label>
                                <input class="form-control" type="number" name="preciotxt" id="preciotxt" placeholder="Precio del producto" min="1" required>
                            </div>
                            <div class="form-group">
                                <label for="ucontratxt">Stock: </label>
                                <input class="form-control" type="number" name="stocktxt" id="stocktxt" placeholder="Cantidad de stock del producto" min="1" required>
                            </div>
                            <div class="form-group">
                                <label for="uemailtxt">Motivo: </label>
                                <input class="form-control" type="text" name="referenciatxt" id="referenciatxt" placeholder="Referencia del producto" required>
                            </div>
                            <div class="form-group">
                                <label for="categoriatxt">Categoria:</label>
                                <select name="categoria" id="categoria" class="form-control">
                                    <?php
                                        $respuesta_categoria = Datos::obtenerCategoriaModel('categoria');
                                        foreach($respuesta_categoria as $row=> $item){
                                    ?>
                                        <option value="<?php echo $item['id']; ?>"><?php echo $item['categoria']; ?></option>
                                    <?php    
                                        }
                                    ?>
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit">Agregar</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php    
        }

        /*-- Esta funcion permite insertar productos llamando al modelo  que se encuentra en  el archivo crud de modelos confirma con un isset que la caja de texto del codigo 
        este llena y procede a llenar en una variable llamada datos controller este arreglo se manda como parametro al igual que el nombre de la tabla,una vez se obtiene una 
        respuesta de la funcion del modelo de inserccion tenemos que checar si la respuesta fue afirmativa hubo un error y mostrara los respectivas alerta,para insertar datos 
        en la tabla de historial se tiene que mandar a un modelo llamado ultimoproductmodel este traera el ultimo dato insertado que es el id del producto que se manda en el 
        array de datoscontroller2 junto al nombre de la tabla asi insertando los datos en la tabla historial --*/

       public function insertarProductContoller(){
            if(isset($_POST["codigotxt"])){
                $_POST["ucontratxt"] = password_hash($_POST["ucontratxt"], PASSWORD_DEFAULT);

                $datosController = array("codigo"=>$_POST["codigotxt"],
                                        "precio"=>$_POST["preciotxt"],
                                        "stock"=>$_POST["stocktxt"],
                                        "categoria"=>$_POST["categoria"],
                                        "nombre"=>$_POST["nombretxt"]);
                
                $respuesta = Datos::insertarProductModel($datosController,"productos");

                if($respuesta = "success"){
                    $respuesta3 = Datos::ultimoProductsModel('productos');
                    $datosController2 = array("user"=>$_SESSION['id'],
                                              "cantidad"=>$_POST['stocktxt']
                                              "producto"=>$respuesta3['id'],
                                              "note"=>$_SESSION['nombre_usuario']."agrego/compro",
                                              "reference"=>$_POST['referenciatxt']
                                            );

                    $respuesta2 = Datos::insertarHistorialModel($datosController2, "historial");



                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-success alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    Exito!
                                </h5>
                                Producto agregado con éxito.
                            </div>
                        </div>
                    
                    ';
                }else{
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-ban"></i>
                                    Error!
                                </h5>
                                Se ha producido un error al momento de agregrar el producto
                            </div>
                        </div>
                    ';
                }
            }
        }

        /*-- Esta funcion permite editar los datos de lat abla productos delproducto seleccionado del boton editar abre un formulario llenando la informacion correspondiente y empezando a editardichos campos apartir de los formularios el array de datossolo guarda el get delboton editar que en este caso es el id del producto y se envia elmodelo de edicioon y se pasa por el metodo form al igual que los demas datos --*/

        public function editarUserController() {
            $datosController = $_GET["idProductEditar"];
            //envío de datos al mododelo
            $respuesta = Datos::editarProductsModel($datosController,"productos");
            ?>
             <div class="col-md-6 mt-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4><b>Registro</b> de Productos</h4>                        
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?action=inventarios">
                            <div class="form-group">
                                <label for="codigotxtEditar">Código: </label>
                                <input class="form-control" type="text" name="codigotxtEditar" id="codigotxtEditar" placeholder="Código del producto" required>
                            </div>
                            <div class="form-group">
                                <label for="nombretxtEditar">Nombre: </label>
                                <input class="form-control" type="text" name="nombretxtEditar" id="nombretxtEditar" placeholder="Nombre del producto" required>
                            </div>
                            <div class="form-group">
                                <label for="preciotxtEditar">Precio: </label>
                                <input class="form-control" type="number" name="preciotxtEditar" id="preciotxtEditar" placeholder="Precio del producto" min="1" required>
                            </div>
                            <div class="form-group">
                                <label for="stocktxtEditar">Stock: </label>
                                <input class="form-control" type="number" name="stocktxtEditar" id="stocktxtEditar" placeholder="Cantidad de stock del producto" min="1" required>
                            </div>
                            <div class="form-group">
                                <label for="referenciatxtEditar">Motivo: </label>
                                <input class="form-control" type="text" name="referenciatxtEditar" id="referenciatxtEditar" placeholder="Referencia del producto" required>
                            </div>
                            <div class="form-group">
                                <label for="categoriaEditar">Categoria:</label>
                                <select name="categoriaEditar" id="categoriaEditar" class="form-control">
                                    <?php
                                        $respuesta_categoria = Datos::obtenerCategoriaModel('categoria');
                                        foreach($respuesta_categoria as $row=> $item){
                                    ?>
                                        <option value="<?php echo $item['id']; ?>"><?php echo $item['categoria']; ?></option>
                                    <?php    
                                        }
                                    ?>
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit">Editar</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }

        public function actualizarProductController(){
            if(isset($_POST['codigotxtEditar'])){
                $datos = array('id'=>$_POST['idProductEditar'],
                               'codigo'=>$_POST['codigotxtEditar'],
                               'precio'=>$_POST['preciotxtEditar'],
                               'stock'=>$_POST['stocktxtEditar'],
                               'categoria'=>$_POST['categoriaEditar'],
                               'nombre' =>$_POST['nombretxtEditar']);

                $respuesta = Datos::actualizarProductsModel($datos);
                if($respuesta == 'success'){
                    $datos2 = array('user'=>$_SESSION['id'],
                                    'cantidad'=>$_POST['stocktxtEditar'],
                                    'producto'=>$_POST['idProductEditar'],
                                    'note'=>$_SESSION['nombre_usuario'].'agrego/compro',
                                    'reference'=>$_POST['referenciatxtEditar']);

                    $respuesta2 = Datos::insertarHistorialModel($datos2);

                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-success alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    Exito!
                                </h5>
                                Producto actualizado con éxito.
                            </div>
                        </div>
                    
                    ';
                }else{
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-ban"></i>
                                    Error!
                                </h5>
                                Se ha producido un error al momento de actualizar el producto
                            </div>
                        </div>
                    ';
                }
            }
        }

        public function eliminarProductController() {
            if(isset($_POST["idBorrar"])){
                $datosController = $_GET["idBorrar"];
                $respuesta = Datos::eliminarProductsModel($datosController);

                if($respuesta = "success"){
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-success alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    Exito!
                                </h5>
                                Producto eliminado con exito
                            </div>
                        </div>
                    
                    ';
                }else{
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-ban"></i>
                                    Error!
                                </h5>
                                Se ha producido un error al momento de eliminar el producto
                            </div>
                        </div>
                    ';
                }
            }
        }

        public function addProductController() {
            $datosController = $_GET["idProductAdd"];
            //envío de datos al mododelo
            $respuesta = Datos::editarProductsModel($datosController,"productos");
            ?>
             <div class="col-md-6 mt-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4><b>Agregar</b> stock al Producto</h4>                        
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?action=inventario">
                            <div class="form-group">
                                <input type="hidden" name="idProductAdd" id="idProductAdd" value="<?php echo $respuesta['id']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="addstocktxt">Stock: </label>
                                <input class="form-control" type="number" name="addstocktxt" id="addstocktxt" min="1" value="1" placeholder="Stock de producto" required>
                            </div>
                            <div class="form-group">
                                <label for="referenciatxtadd">Motivo: </label>
                                <input class="form-control" type="text" name="referenciatxtadd" id="referenciatxtadd" placeholder="Referencia del producto" required>
                            </div>
                            <button class="btn btn-primary" type="submit">Realizar cambio</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }

        public function actualizarStockController(){
            if(isset($_POST['addstocktxt'])){
                $datos = array('id'=>$_POST['idProductAdd'],
                               'stock'=>$_POST['addstocktxt']);

                $respuesta = Datos::pushProductsModel($datos);
                if($respuesta == 'success'){
                    $datos2 = array('user'=>$_SESSION['id'],
                                    'cantidad'=>$_POST['addstocktxt'],
                                    'producto'=>$_POST['idProductAdd'],
                                    'note'=>$_SESSION['nombre_usuario'].'agrego/compro',
                                    'reference'=>$_POST['referenciatxtadd']);

                    $respuesta2 = Datos::insertarHistorialModel($datos2);

                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-success alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    Exito!
                                </h5>
                                Stock modificado con éxito.
                            </div>
                        </div>
                    
                    ';
                }else{
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
                                <h5>
                                    <i class="icon fas fa-ban"></i>
                                    Error!
                                </h5>
                                Se ha producido un error al momento de modificar el stock
                            </div>
                        </div>
                    ';
                }
            }
        }






        /*-- Esta funcion actualiza y llama al modelo de latabla producto asu vez inserta una nueva fila a la tabla historial, si el update sale correcto y elimina los productos  del stock entonces insertara la actualizacion en la tabla historial, si todo sale bien mostrara un mensaje de error o de correcto dependiendo de la respuesta --*/
        public function actualizar2StockController(){
            if (isset($_POST["delstocktxt"])) {
                $datosController = array("id"=>$_POST["idProductDel"],"stock"=>$_POST["delstocktxt"]);
                $respuesta = Datos::pullProductsModel($datosController,"products");

                if ($respuesta ==  "success") {
                    $datosController2 = array("user"=>$_SESSION["id"],"cantidad"=>$_POST["delstocktxt"],"producto"=>$_POST["idProductDel"],"note"=>$_SESSION["nombre_usuario"]."quito","reference"=>$_POST["referenciatxtdel"]);
                    $respuesta2 = Datos::insertarHistorialModel($datosController2,"historial");
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-success alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    ¡Éxito!
                                </h5>
                                Stock modificado con éxito.
                            </div>
                        </div>
                    ';
                } else {
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                                <h5>
                                    <i class="icon fas fa-ban"></i>
                                    ¡Error!
                                </h5>
                                Se ha producido un error al momento de modificar el stock del producto, trate de nuevo.
                            </div>
                        </div>
                    ';
                }
            }
        }
        
        public function delProductController() {
            $datosController = $_GET["idProductDel"];
            //envío de datos al mododelo
            $respuesta = Datos::editarProductsModel($datosController,"productos");
            ?>
             <div class="col-md-6 mt-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4><b>Eliminar</b> stock al Producto</h4>                        
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?action=inventarios">
                            <div class="form-group">
                                <input class="form-control" type="hidden" name="idProductDel" id="idProductDel" value="<?php echo $respuesta['id']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="delstocktxt">Stock: </label>
                                <input class="form-control" type="number" name="delstocktxt" id="delstocktxt" placeholder="Stock de producto" min="1" max="<?php echo $respuesta['stock']; ?>" value=""<?php echo $respuesta['stock']; ?> required>
                            </div>
                            <div class="form-group">
                                <label for="referenciatxtdel">Motivo: </label>
                                <input class="form-control" type="text" name="referenciatxtdel" id="referenciatxtdel" placeholder="Referencia del producto" required>
                            </div>
                            
                            <button class="btn btn-primary" type="submit">Realizar cambio</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }

        public function vistaHistorialController(){
            $respuesta = Datos::vistaHistorialModel();

            foreach($respuesta as $row => $item){
                echo '
                      <tr>
                          <td>'.$item['usuario'].'</td>
                          <td>'.$item['producto'].'</td>
                          <td>'.$item['nota'].'</td>
                          <td>'.$item['cantidad'].'</td>
                          <td>'.$item['referencia'].'</td>
                          <td>'.$item['fecha'].'</td>
                       </tr>';
            }
        }
    }
?>