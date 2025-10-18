<?php

require_once 'model/venta_detalle.php';
require_once 'model/producto.php';

class Venta_detalleController{
	public $page_title;
	public $view;
	private $tabla = "ventas_detalle";
	public $tablaObj;
	public $tablaObj1;

	public function __construct() {
		$this->view = 'listar';
		$this->page_title = '';
		$this->tablaObj = new VentaDetalle();
		$this->tablaObj1 = new Producto();
	}

	/* Lista */
	public function list($id){
		$this->page_title = 'Listado de '. $this->tabla;
		return $this->tablaObj->getTabla($id);
	}

	/* trae para editar */
	public function edit($id=null){
		$this->page_title = 'Editar '. $this->tabla;
		$this->view = 'edit_'. $this->tabla;
		if (isset($_GET["id"])) {
			$id = $_GET["id"];
		}
		else {
			$this->page_title = 'Crear ' . $this->tabla;
		}
		return $this->tablaObj->getTablaById($id);
	}

	/* Create or update */
	public function save(){
		$this->view = 'edit_'. $this->tabla;
		$this->page_title = 'Editar '. $this->tabla;
		$id = $this->tablaObj->save($_POST);
		$result = $this->tablaObj->getTablaById($id);
		$_GET["response"] = true;
		return $result;
	}

	/* Confirm to delete */
	public function confirmDelete(){
		$this->page_title = 'Eliminar '. $this->tabla;
		$this->view = 'confirm_delete';
		return $this->tablaObj->getTablaById($_GET["id"]);
	}

	/* Delete */
	public function delete(){
		$this->page_title = 'Listado de '. $this->tabla;
		$this->view = 'delete';
		return $this->tablaObj->deleteTablaById($_POST["id"]);
	}

	/* Campos con su descripción */
	public function getCampos(){
		return $this->tablaObj->getCampos();
	}

	/* Listado de la tabla relacionada */
	public function getTablaRel1()
	{
		return $this->tablaObj1->getTabla();
	}
}

?>