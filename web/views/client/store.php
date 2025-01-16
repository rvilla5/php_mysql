<?php
require_once "controllers/clientsController.php";
//recoger datos
if (!isset ($_REQUEST["idFiscal"])){
   header('location:index.php?tabla=client&accion=crear' );
   exit();
}

$id= ($_REQUEST["id"])??"";//el id me servirá en editar

$aDatos = [
    "id" => $$id,
    "idFiscal"=>$_REQUEST["idFiscal"],
    "contact_name"=>$_REQUEST["contact_name"],
    "contact_email"=>$_REQUEST["contact_email"],
    "contact_phone_number"=>$_REQUEST["contact_phone_number"],
    "company_name"=>$_REQUEST["company_name"],
    "company_address"=>$_REQUEST["company_address"],
    "company_phone_number"=>$_REQUEST["company_phone_number"],
];


//pagina invisible
$controlador= new ClientsController();
// var_dump($aDatos);
// die();

if ($_REQUEST["evento"]=="crear"){
    $controlador->crear ($aDatos);
}

if ($_REQUEST["evento"]=="modificar"){
    $controlador->editar ($id, $aDatos);
}