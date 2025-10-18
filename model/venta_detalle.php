<?php

require_once 'model/db.php';

class VentaDetalle {

	private $tabla = 'ventas_detalle';
	private $conection;
	private $campos;

	public function __construct() {
		$this->campos = [
			"id" => "ID",
			"id_venta" => "",
			"id_producto" => "Producto",
			"cantidad" => "Cantidad",
			"precio_unitario" => "Precio ($)",
			"subtotal" => "SubTotal ($)"
		];
	}

	/* Set conection */
	public function getConection(){
		$dbObj = new Db();
		$this->conection = $dbObj->conection;
	}

	/* Get all */
	public function getTabla($id){
		$this->getConection();
		$sql = "SELECT a.*, b.nombre, b.precio 
			FROM ".$this->tabla." a
			INNER JOIN productos b
			ON a.id_producto=b.id
			WHERE id_venta=".$id;
		$stmt = $this->conection->prepare($sql);
		$stmt->execute();
		$resultado = $stmt->get_result();

		return $resultado->fetch_all(MYSQLI_ASSOC);
	}

	/* Get by id */
	public function getTablaById($id){
		if(is_null($id)) return false;
		$this->getConection();
		$sql = "SELECT * FROM ".$this->tabla." WHERE id = ?";
		$stmt = $this->conection->prepare($sql);
		$stmt->bind_param('i', $id); // 'i' para entero
		$stmt->execute();
		$resultado = $stmt->get_result();
		return $resultado->fetch_assoc();
	}

	/* Save */
	public function save($param){
		$this->getConection();

		/* Check if exists */
		$exists = false;
		if(isset($param["id"]) and $param["id"] !=''){
			$actual = $this->getTablaById($param["id"]);
			if(isset($actual["id"])){
				$exists = true;
				/* Actual values */
				foreach ($this->campos as $key => $value) {
					$$key = $actual[$key];
				}
			}
		}

		/* Received values */
		foreach ($this->campos as $key => $value) {
			if (isset($param[$key])) $$key = $param[$key];
		}

		/* Database operations */
		if($exists){
			$sql  = "UPDATE ".$this->tabla. " SET ";
			$data=[];
			foreach ($this->campos as $key => $value) {
				if ($value!=="ID") {
					if (count($data) > 0) $sql .= ", ";
					$sql .= $key . " = ?";
					$data[] = $$key;
				}
				else {
					$id= $$key;
				}
			}
			$data[] = $id;
			$sql .= " WHERE id = ?";
			$stmt = $this->conection->prepare($sql);
			$res = $stmt->execute($data);
		}else{
			$sql = "INSERT INTO ".$this->tabla." (";
			$data = [];
			foreach ($this->campos as $key => $value) {
				if (count($data) > 0) $sql .= ", ";
				$sql .= $key;
				$data[] = $$key;
			}
			$sql .= ") VALUES (";
			for ($i=0; $i<count($data);$i++){
				if ($i > 0) $sql .= ", ";
				$sql .= "?";
			}
			$sql .= ")";
			$stmt = $this->conection->prepare($sql);
			$stmt->execute($data);
			$id = $this->conection->insert_id;
		}
		$this->updateTotalVentaById($id_venta);
		return $id;	
	}

	/* Delete by id */
	public function deleteTablaById($id)
	{
		$this->getConection();
		$id_venta= $this->getIdVentaById($id);
		$sql = "DELETE FROM " . $this->tabla . " WHERE id = ?";
		$stmt = $this->conection->prepare($sql);
		$stmt->execute([$id]);
		$this->updateTotalVentaById($id_venta);
		return true;
	}

	/* Actualizar Total de Venta x id_venta */
	public function updateTotalVentaById($id_venta) {
		$this->getConection();
		$sql  = "UPDATE ventas SET total = (
		select sum(subtotal) from ventas_detalle 
		where ventas.id=ventas_detalle.id_venta)
		where id=?";
		$stmt = $this->conection->prepare($sql);
		$stmt->bind_param('i', $id_venta); // 'i' para entero
		$stmt->execute();
		return true;
	}

	public function getIdVentaById($id)	{
		if (is_null($id)) return false;
		$this->getConection();
		$sql = "SELECT id_venta FROM " . $this->tabla . " WHERE id = ?";
		$stmt = $this->conection->prepare($sql);
		$stmt->bind_param('i', $id); // 'i' para entero
		$stmt->execute();
		$resultado = $stmt->get_result();
		return $resultado->fetch_assoc();
	}

	public function getCampos(){
		return $this->campos;
	}

}
?>