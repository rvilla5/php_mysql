<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Añadir Cliente</h1>
  </div>
  <div id="contenido">
    <?php

    $cadena = (isset($_REQUEST["error"])) ? "Error, ha fallado la inserción" : "";
    $visibilidad = (isset($_REQUEST["error"])) ? "visible" : "invisible";
    ?>
    <div class="alert alert-danger <?= $visibilidad ?>"><?= $cadena ?></div>
    <form action="index.php?tabla=client&accion=guardar&evento=crear" method="POST">
      <div class="form-group">
        <label fo r="idFiscal">CIF/NIF </label>
        <input type="text" required class="form-control" id="idFiscal" name="idFiscal" aria-describedby="usuario" placeholder="Introduce DNI o CIF">
        <small id="" class="form-text text-muted">Compartir tu DNI/CIF lo hace menos seguro.</small>
      </div>
      <div class="form-group">
        <label for="contact_name">Nombre Contacto Cliente</label>
        <input type="text" required class="form-control" id="contact_name" name="contact_name" placeholder="contact_name">
      </div>
      <div class="form-group">
        <label for="contact_email">Email Contacto</label>
        <input type="email" required class="form-control" id="contact_email" name="contact_email" placeholder="contact_email">
      </div>
      <div class="form-group">
        <label for="contact_phone_number">Telefono Persona Contacto </label>
        <input type="tel" class="form-control" id="contact_phone_number" name="contact_phone_number" placeholder="contact_phone_number">
      </div>
      <div class="form-group">
        <label for="company_name">Nombre Empresa</label>
        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="company_name">
      </div>
      <div class="form-group">
        <label for="company_address">Dirección Empresa</label>
        <input type="text" class="form-control" id="company_address" name="company_address" placeholder="company_address">
      </div>
      <div class="form-group">
        <label for="company_phone_number">Telefono Empresa</label>
        <input type="tel" class="form-control" id="company_phone_number" name="company_phone_number" placeholder="company_phone_number">
      </div>
      <button type="submit" class="btn btn-primary">Guardar</button>
      <a class="btn btn-danger" href="index.php">Cancelar</a>
    </form>
  </div>
</main>