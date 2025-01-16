<?php
require_once "models/clientModel.php";

class ClientsController
{
    private $model;

    public function __construct()
    {
        $this->model = new ClientModel();
    }

    public function crear(array $arrayCliente¡): void
    {
        $id = $this->model->insert($arrayCliente¡);
        ($id == null) ? header("location:index.php?tabla=client&accion=crear&error=true&id={$id}") : header("location:index.php?tabla=client&accion=ver&id=" . $id);
        exit();
    }
    public function ver(int $id): ?stdClass
    {
        return $this->model->read($id);
    }
    public function listar()
    {
        return $this->model->readAll();
    }
    public function borrar(int $id): void
    {
        $clientBorrar=$this->ver ($id);
        $borrado = $this->model->delete($id);
        $redireccion = "location:index.php?accion=listar&tabla=client&evento=borrar&id={$id}&idFiscal={$clientBorrar->idFiscal}&contact_name={$clientBorrar->contact_name}";

        if ($borrado == false) $redireccion .=  "&error=true";
        header($redireccion);
        exit();
    }
    public function editar(int $id, array $arrayCliente¡): void
    {
        $editadoCorrectamente = $this->model->edit($id, $arrayCliente¡);
        //lo separo para que se lea mejor en el word
        $redireccion = "location:index.php?tabla=client&accion=editar";
        $redireccion .= "&evento=modificar&id={$id}";
        $redireccion .= ($editadoCorrectamente == false) ? "&error=true" : "";
        //vuelvo a la pagina donde estaba
        header($redireccion);
        exit();
    }
    public function buscar(string $campo = "id", string $metodo = "contiene", string $texto = ""): array
    {
        $clients = $this->model->search($campo, $metodo, $texto);
        return $clients;
    }
}
