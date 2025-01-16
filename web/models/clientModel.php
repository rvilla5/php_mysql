<?php
require_once('config/db.php');

class ClientModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }

    public function insert(array $client): ?int //devuelve entero o null
    {

        try {
            $sql = "INSERT INTO clients(idFiscal, contact_name, contact_email, contact_phone_number, company_name, company_address,company_phone_number) ";
            $sql.=" VALUES (:idFiscal, :contact_name, :contact_email, :contact_phone_number, :company_name, :company_address,:company_phone_number);";
            $sentencia = $this->conexion->prepare($sql);
            $arrayDatos = [
                ":idFiscal"=>$client["idFiscal"],
                ":contact_name"=>$client["contact_name"],
                ":contact_email"=>$client["contact_email"],
                ":contact_phone_number"=>$client["contact_phone_number"],
                ":company_name"=>$client["company_name"],
                ":company_address"=>$client["company_address"],
                ":company_phone_number"=>$client["contact_phone_number"],

            ];
            $resultado = $sentencia->execute($arrayDatos);

            /*Pasar en el mismo orden de los ? execute devuelve un booleano. 
        True en caso de que todo vaya bien, falso en caso contrario.*/
            //Así podriamos evaluar
            return ($resultado == true) ? $this->conexion->lastInsertId() : null;
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "<bR>";
            return null;
        }
    }
    public function read(int $id): ?stdClass
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM clients WHERE id=:id");
        $arrayDatos = [":id" => $id];
        $resultado = $sentencia->execute($arrayDatos);
        // ojo devuelve true si la consulta se ejecuta correctamente
        // eso no quiere decir que hayan resultados
        if (!$resultado) return null;
        //como sólo va a devolver un resultado uso fetch
        // DE Paso probamos el FETCH_OBJ
        $client = $sentencia->fetch(PDO::FETCH_OBJ);
        //fetch duevelve el objeto stardar o false si no hay persona
        return ($client == false) ? null : $client;
    }

    public function readAll(): array
    {
        $sentencia = $this->conexion->query("SELECT * FROM clients;");
        //usamos método query
       $clients = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $clients;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM clients WHERE id =:id";
        try {
            $sentencia = $this->conexion->prepare($sql);
            //devuelve true si se borra correctamente
            //false si falla el borrado
            $resultado = $sentencia->execute([":id" => $id]);
            return ($sentencia->rowCount() <= 0) ? false : true;
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function edit(int $idAntiguo, array $aClientes): bool
    {
        try {
            $sql = "UPDATE clients SET idFiscal = :idFiscal, contact_name=:contact_name, ";
            $sql .= "contact_email = :contact_email, contact_phone_number= :contact_phone_number, ";
            $sql .= "company_name = :company_name, company_address= :company_address, company_phone_number=:company_phone_number ";
            $sql .= " WHERE id = :id;";
            $arrayDatos = [
                ":id" => $idAntiguo,
                ":idFiscal"=>$aClientes["idFiscal"],
                ":contact_name"=>$aClientes["contact_name"],
                ":contact_email"=>$aClientes["contact_email"],
                ":contact_phone_number"=>$aClientes["contact_phone_number"],
                ":company_name"=>$aClientes["company_name"],
                ":company_address"=>$aClientes["company_address"],
                ":company_phone_number"=>$aClientes["company_phone_number"],
            ];
            $sentencia = $this->conexion->prepare($sql);
            return $sentencia->execute($arrayDatos);
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function search(string $campo = "id", string $metodo = "contiene", string $dato = ""): array
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM clients WHERE $campo LIKE :dato");
        //ojo el si ponemos % siempre en comillas dobles "
        switch ($metodo) {
            case "contiene":
                $arrayDatos = [":dato" => "%$dato%"];
                break;
            case "empieza":
                $arrayDatos = [":dato" => "$dato%"];
                break;
            case "acaba":
                $arrayDatos = [":dato" => "%$dato"];
                break;
            case "igual":
                $arrayDatos = [":dato" => "$dato"];
                break;
            default:
                $arrayDatos = [":dato" => "%$dato%"];
                break;
        }

        $resultado = $sentencia->execute($arrayDatos);
        if (!$resultado) return [];
        $clients = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $clients;
    }
}
