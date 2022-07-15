<?php include("cabecera.php"); ?>
<?php include("conexion.php"); ?>
<?php
    if($_POST){
        print_r($_POST);
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $fecha = new DateTime();
        $imagen = $fecha->getTimestamp()."_".$_FILES['archivo']['name'];
        $imagen_temporal = $_FILES['archivo']['tmp_name'];
        move_uploaded_file($imagen_temporal, "imagenes/".$imagen);
        $objConexion = new conexion();
        $sql="INSERT INTO `proyectos` (`id`, `nombre`, `imagen`, `descripción`) VALUES (NULL, '$nombre', $imagen, 'Es un proyecto')";
        $objConexion->ejecutar($sql);
        header("location:portafolio.php");
    }

    if($_GET){
        $id = $_GET['borrar'];
        $objConexion = new conexion();
        $imagen = $objConexion->consultar("SELECT imagen FROM `proyectos` WHERE id = ".$id);
        unlink("imagenes/".$imagen[0]['imagen']);
        $sql="DELETE FROM 'proyectos' WHERE 'proyectos'.'id'=".$id;
        $objConexion->ejecutar($sql);
        header("location:portafolio.php");
    }
    $objConexion = new conexion();
    $proyectos = $objConexion->consultar("SELECT * FROM `proyectos`");
?>
    <br/>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
        <div class="card-header">
            Datos del proyecto
        </div>
        <div class="card-body">
            <form action="portafiolo.php" method="post" enctype="multipart/form-data">
                Nombre del proyecto: <input require class="form-control" type="text" name="nombre" id="">
                <br/>
                Imagen del proyecto: <input require class="form-control" type="file" name="archivo" id="">                    <br/>
                <br/>
                Descripción:
                <textarea require class="form-control" name="descripcion" id="" rows="3"></textarea>
                <br/>
                <input class="btn btn-success" type="submit" value="Enviar proyecto">
            </form>
        </div>
        <div class="card-footer text-muted">
    </div>
    </div>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Imagen</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($proyectos as $proyecto){ ?>
                        <tr>
                            <td><?php echo $proyecto['id']; ?></td>
                            <td><?php echo $proyecto['nombre']; ?></td>
                            <td><img width="100" src="imagenes/<?php echo $proyecto['imagen']; ?>" alt="" srcset="" ></td>
                            <td><?php echo $proyecto['descripción']; ?></td>
                            <th><a class="btn btn-danger" href="?borrar=<?php echo $proyecto['id']; ?>">Eliminar</a></th>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php include("pie.php"); ?>