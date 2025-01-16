<?php
require_once "controllers/projectsController.php";

$mensaje = "";
$clase = "alert alert-success";
$visibilidad = "hidden";
$mostrarDatos = false;
$controlador = new ProjectsController();
$campo = "projects.name";
$metodo = "contiene";
$texto = "";

if (isset($_REQUEST["evento"])) {
    $mostrarDatos = true;
    switch ($_REQUEST["evento"]) {
        case "todos":
            $projects = $controlador->listar(comprobarSiEsBorrable: true);
            $mostrarDatos = true;
        break;
            //Modificamos el filtrar    
        case "filtrar":
            $campo = ($_REQUEST["campo"]) ?? "projects.name";
            $metodo = ($_REQUEST["metodoBusqueda"]) ?? "contiene";
            $texto = ($_REQUEST["busqueda"]) ?? "";
            //es borrable Parametro con nombre
            if (!isset ($_REQUEST["misProyectos"]))$projects= $controlador->buscar($campo, $metodo, $texto, comprobarSiEsBorrable: true); 
            else $projects= $controlador->buscarPorUsuarioSesion($_SESSION["usuario"],$campo, $metodo, $texto, comprobarSiEsBorrable: true); //solo añadimos esto
            break;
        case "borrar":
            $visibilidad = "visibility";
            $mostrarDatos = true;
            $clase = "alert alert-success";
            //Mejorar y poner el nombre/usuario
            $mensaje = "El proyecto o {$_REQUEST['id']} -  {$_REQUEST['name']} Borrado correctamente";
            if (isset($_REQUEST["error"])) {
                $clase = "alert alert-danger ";
                $mensaje = "ERROR!!! No se ha podido borrar el proyecto {$_REQUEST['id']} -  {$_REQUEST['name']}";
            }
            $projects = $controlador->listar(comprobarSiEsBorrable: true);
            break;
    }
}
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Buscar Proyecto</h1><a class="btn btn-dark" href="index.php?tabla=project&accion=crear"><i class="fa fa-plus"></i> Nuevo Proyecto</a>
    </div>
    <div id="contenido">
        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert"> <?= $mensaje ?>
        </div>
        <div>
            <form action="index.php?accion=buscar&tabla=project&evento=filtrar" method="POST">
                <div class="form-group">
                    <select class="form-select" name="campo" id="campo">
                        <option value="id" <?= $campo == "id" ? "selected" : "" ?>>ID</option>
                        <option value="projects.name" <?= $campo == "projects.name" ? "selected" : "" ?>>Nombre Proyecto</option>
                        <option value="description" <?= $campo == "description" ? "selected" : "" ?>>Descripcion </option>
                        <option value="user_id" <?= $campo == "user_id" ? "selected" : "" ?>>Id de Usuario</option>
                        <option value="users.name" <?= $campo == "users.name" ? "selected" : "" ?>>Nombre de Usuario</option>
                        <option value="users.usuario" <?= $campo == "users.usuario" ? "selected" : "" ?>>Nick de Usuario</option>
                        <option value="clients.contact_name" <?= $campo == "clients.contact_name" ? "selected" : "" ?>>Nombre Contacto Cliente</option>
                        <option value="clients.idFiscal" <?= $campo == "clients.idFiscal" ? "selected" : "" ?>> Id Fiscal de Cliente de Usuario </option>
                        <option value="clients.company_name" <?= $campo == "clients.company_name" ? "selected" : "" ?>>Nombre Empresa Cliente </option>
                    </select>
                    <select class="form-select" name="metodoBusqueda" id="metodoBusqueda">
                        <option value="empieza" <?= $metodo == "empieza" ? "selected" : "" ?>>Empieza Por</option>
                        <option value="acaba" <?= $metodo == "acaba" ? "selected" : "" ?>>Acaba En </option>
                        <option value="contiene" <?= $metodo == "contiene" ? "selected" : "" ?>>Contiene </option>
                        <option value="igual" <?= $metodo == "igual" ? "selected" : "" ?>>Es Igual A</option>

                    </select>
                    <input type="text"  class="form-control" id="busqueda" name="busqueda" value="<?= $texto ?>" placeholder="texto a Buscar">
                    <input class="form-check-input" type="checkbox" value="checked" name="misProyectos" id="misProyectos" <?= $_REQUEST["misProyectos"]??"" ?> >
                    <label class="form-check-label" for="misProyectos">
                        Mis Proyectos 
                    </label>
                <DIV>
                <button type="submit" class="btn btn-success" name="Filtrar">Buscar</button>
                <a href="index.php?accion=buscar&tabla=project&evento=todos" class="btn btn-info" name="Todos" role="button">Ver todos</a>
            </form>

        </div>
        <?php
        if ($mostrarDatos) {
            if (count($projects) <= 0) :
                echo "No hay Datos a Mostrar";
            else :
        ?>
                <table class="table table-light table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Fecha Finalización</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Eliminar</th>
                            <th scope="col">Ver Proyecto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project) :
                            $id = $project->id;
                            $disable = "";
                            $rutaBorrar = "index.php?tabla=project&accion=borrar&id={$id}";
                            if (isset($project->esBorrable) && $project->esBorrable == false) {
                                $disable = "disabled";
                                $rutaBorrar = "#";
                            }
                                             ?>
                            <tr>
                                <th scope="row"><?= $project->id ?></th>
                                <td><?= $project->name ?></td>
                                <td><?= $project->description ?></td>
                                <td><?= date('d-m-Y', strtotime($project->deadline)) ?></td>
                                <td><?= $project->status ?></td>
                                <td><?= "{$project->user_id} - {$project->usuario_user} {$project->name_user} " ?></td>
                                <td><?= "$project->client_id - {$project->contact_name_client} {$project->company_name_client} " ?></td>
                                <td><a class="btn btn-danger <?=$disable?>" href="<?= $rutaBorrar?>"><i class="fa fa-trash"></i> Borrar</a></td>
                                <td><a class="btn btn-warning" href="index.php?tabla=project&accion=ver&id=<?= $id ?>"><i class="fas fa-eye"></i> Ver </a></td>
                            </tr>
                        <?php
                        endforeach;

                        ?>
                    </tbody>
                </table>
        <?php
            endif;
        }
        ?>
    </div>
</main>