<?php
require_once "controllers/clientsController.php";

$mensaje = "";
$clase = "alert alert-success";
$visibilidad = "hidden";
$mostrarDatos = false;
$controlador = new ClientsController();
$campo = "idFiscal";
$metodo = "contiene";
$texto = "";

if (isset($_REQUEST["evento"])) {
    $mostrarDatos = true;
    switch ($_REQUEST["evento"]) {
        case "todos":
            $clients = $controlador->listar();
            $mostrarDatos = true;
            break;
        case "filtrar":
            $campo = ($_REQUEST["campo"]) ?? "idFiscal";
            $metodo = ($_REQUEST["metodoBusqueda"]) ?? "contiene";
            $texto = ($_REQUEST["busqueda"]) ?? "";
            //es borrable Parametro con nombre
            $clients = $controlador->buscar($campo, $metodo, $texto);
            break;
        case "borrar":
            $visibilidad = "visibility";
            $mostrarDatos = true;
            $clase = "alert alert-success";
            //Mejorar y poner el nombre/idFiscal
            $mensaje = "El Cliente con id: {$_REQUEST['id']} Borrado correctamente";
            if (isset($_REQUEST["error"])) {
                $clase = "alert alert-danger ";
                $mensaje = "ERROR!!! No se ha podido borrar el Cliente con id: {$_REQUEST['id']}";
            }
            break;
    }
}
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Buscar Cliente</h1>
    </div>
    <div id="contenido">
        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
            <?= $mensaje ?>
        </div>
        <div>
            <form action="index.php?accion=buscar&tabla=client&evento=filtrar" method="POST">
                <div class="form-group">
                    <select class="form-select" name="campo" id="campo">
                        <option value="id" <?= $campo == "id" ? "selected" : "" ?>>ID</option>
                        <option value="idFiscal" <?= $campo == "idFiscal" ? "selected" : "" ?>>CIF/NIF</option>
                        <option value="contact_name" <?= $campo == "contact_name" ? "selected" : "" ?>>Nombre de Contacto</option>
                        <option value="contact_email" <?= $campo == "contact_email" ? "selected" : "" ?>>Email de Contacto</option>
                    </select>
                    <select class="form-select" name="metodoBusqueda" id="metodoBusqueda">
                        <option value="empieza" <?= $metodo == "empieza" ? "selected" : "" ?>>Empieza Por</option>
                        <option value="acaba" <?= $metodo == "acaba" ? "selected" : "" ?>>Acaba En </option>
                        <option value="contiene" <?= $metodo == "contiene" ? "selected" : "" ?>>Contiene </option>
                        <option value="igual" <?= $metodo == "igual" ? "selected" : "" ?>>Es Igual A</option>

                    </select>
                </div>
                <input type="text" required class="form-control" id="busqueda" name="busqueda" value="<?= $texto ?>" placeholder="texto a Buscar">
                <button type="submit" class="btn btn-success" name="Filtrar">Buscar</button>
                <a href="index.php?accion=buscar&tabla=client&evento=todos" class="btn btn-info" name="Todos" role="button">Ver todos</a>
            </form>

        </div>
        <?php
        if ($mostrarDatos) {
        ?>
            <table class="table table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">CIF/NIF</th>
                        <th scope="col">Persona de Contacto</th>
                        <th scope="col">Email Contacto</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client) :
                        $id = $client->id;
                    ?>
                        <tr>
                            <th scope="row"><?= $client->id ?></th>
                            <td><?= $client->idFiscal ?></td>
                            <td><?= $client->contact_name ?></td>
                            <td><?= $client->contact_email ?></td>
                            <td><a class="btn btn-danger" href="index.php?tabla=client&accion=borrar&id=<?= $id ?>"><i class="fa fa-trash"></i> Borrar</a></td>
                            <td><a class="btn btn-success" href="index.php?tabla=client&accion=editar&id=<?= $id ?>"><i class="fas fa-pencil-alt"></i> Editar</a></td>
                        </tr>
                    <?php
                    endforeach;

                    ?>
                </tbody>
            </table>
        <?php
        }
        ?>
    </div>
</main>