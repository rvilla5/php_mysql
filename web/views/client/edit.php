<?php
require_once "controllers/clientsController.php";
//recoger datos
if (!isset($_REQUEST["id"])) {
    header('location:index.php?accion=listar');
    exit();
}
$id = $_REQUEST["id"];
$controlador = new ClientsController();
$client = $controlador->ver($id);

$visibilidad = "hidden";
$mensaje = "";
$clase = "alert alert-success";
$mostrarForm = true;
if ($client == null) {
    $visibilidad = "visbility";
    $mensaje = "El Cliente con id: {$id} no existe. Por favor vuelva a la pagina anterior";
    $clase = "alert alert-danger";
    $mostrarForm = false;
} else if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "modificar") {
    $visibilidad = "vibility";
    $mensaje = "Cliente {$client->idFiscal} con id {$id} - {$client->contact_name} Modificado con éxito";
    if (isset($_REQUEST["error"])) {
        $mensaje = "No se ha podido modificar Cliente {$client->idFiscal} con id {$id} - {$client->contact_name} ";
        $clase = "alert alert-danger";
    }
}
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Editar Cliente con Id: <?= $id ?></h1>
    </div>
    <div id="contenido">
        <div id="msg" name="msg" class="<?= $clase ?>" <?= $visibilidad ?>> <?= $mensaje ?> </div>
        <?php
        if ($mostrarForm) {
        ?>
            <form action="index.php?tabla=client&accion=guardar&evento=modificar" method="POST">
                <input type="hidden" id="id" name="id" value="<?= $client->id ?>">
                <div class="form-group">
                    <label for="idFiscal">CIF/NIF </label>
                    <input type="text" required class="form-control" id="idFiscal" name="idFiscal" value="<?= $client->idFiscal ?>" aria-describedby="usuario" placeholder="Introduce DNI o CIF">
                    <small id="" class="form-text text-muted">Compartir tu DNI/CIF lo hace menos seguro.</small>
                </div>
                <div class="form-group">
                    <label for="contact_name">Nombre Contacto Cliente</label>
                    <input type="text" required class="form-control" id="contact_name" name="contact_name" value="<?= $client->contact_name ?>" placeholder="contact_name">
                </div>
                <div class="form-group">
                    <label for="contact_email">Email Contacto</label>
                    <input type="email" required class="form-control" id="contact_email" name="contact_email" value="<?= $client->contact_email ?>" placeholder="contact_email">
                </div>
                <div class="form-group">
                    <label for="contact_phone_number">Telefono Persona Contacto </label>
                    <input type="tel" class="form-control" id="contact_phone_number" name="contact_phone_number" value="<?= $client->contact_phone_number ?>" placeholder="contact_phone_number">
                </div>
                <div class="form-group">
                    <label for="company_name">Nombre Empresa</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" value="<?= $client->company_name ?>" placeholder="company_name">
                </div>
                <div class="form-group">
                    <label for="company_address">Dirección Empresa</label>
                    <input type="text" class="form-control" id="company_address" name="company_address" value="<?= $client->company_address ?>" placeholder="company_address">
                </div>
                <div class="form-group">
                    <label for="company_phone_number">Telefono Empresa</label>
                    <input type="tel" class="form-control" id="company_phone_number" name="company_phone_number" value="<?= $client->company_phone_number ?>" placeholder="company_phone_number">
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a class="btn btn-danger" href="index.php?tabla=client&accion=listar">Cancelar</a>
            </form>
        <?php
        } else {
        ?>
            <a href="index.php" class="btn btn-primary">Volver a Inicio</a>
        <?php
        }
        ?>
    </div>
</main>