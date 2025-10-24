<?php
foreach ($campos as $key => $encabezado) {
	$$key = "";
	if (isset($dataToView["data"][$key])) $$key = $dataToView["data"][$key];
}
?>
<div class="form-control-dark">
	<?php
	if (isset($_GET["response"]) and $_GET["response"] === true) {
	?>
		<div class="alert alert-success">
			Operación realizada correctamente. <a href="index.php?controller=<?= $_GET["controller"] ?>&action=list">Volver al listado</a>
		</div>
	<?php
	}
	$id_venta = $id;
	?>
	<fieldset>
		<form class="form" action="index.php?controller=<?= $_GET["controller"] ?>&action=save" method="POST">
			<div class="row align-items-center">
				<?php
				foreach ($campos as $key => $encabezado) {
					if ($key == "id_cliente") {
				?><div class="col-md-3 mb-2">
							<label class="form-label"><?= $encabezado ?></label>
							<select name="<?= $key ?>" id="<?= $key ?>" required>
								<?php foreach ($dataToView["dataRel1"] as $rel1) { ?>
									<option value="<?= $rel1["id"] ?>" <?= $rel1["id"] == $$key ? "selected" : "" ?>>
										<?= $rel1["apellido"] ?>, <?= $rel1["nombre"] ?>
									</option>
								<?php } ?>
							</select>
						<?php
					} else if ($key == "fecha") {
						if ($$key=="") {
							$$key = date("Y-m-d H:m:s");
						}
						?><div class="col-md-3 mb-2">
								<label class="form-label"><?= $encabezado ?></label>
								<input type="datetime" name="<?= $key ?>" value="<?= $$key ?>" />
							<?php
						} else if ($key == "total") {
				?><div class="col-md-2 mb-1">
						<label class="form-label"><?= $encabezado ?></label>
						<input type="hidden" name="<?= $key ?>" value="<?= $$key ?>" />
					<?php
					echo $$key;
				} else {
					?><div class="col-md-1 mb-1">
							<label class="form-label"><?= $encabezado ?></label>
							<input type="hidden" name="<?= $key ?>" value="<?= $$key ?>" />
						<?php
						echo $$key;
					}
						?>
						</div>
					<?php
				}
					?><div class="col-md-3 mb-2"><input type="submit" value="Guardar" class="btn btn-primary" />
						<a class="btn btn-primary" href="index.php?controller=<?= $_GET["controller"] ?>&action=list">Cancelar</a>
					</div>
					</div>
		</form>
	</fieldset>
	<?php
	$_GET["controller"] = "venta_detalle";
	$controller_path = 'controller/' . $_GET["controller"] . '.php';
	require_once $controller_path;
	$controllerName = $_GET["controller"] . 'Controller';
	$controller = new $controllerName();
	$campos = $controller->getCampos();
	$dataToView["data"] = $controller->list($id);
	require_once "listar.php";
	if (isset($id_venta) && $id_venta!="") {
	?>
	<a href="index.php?controller=<?= $_GET["controller"] ?>&action=edit&id=0&id_venta=<?= $id_venta ?>"
		class="btn btn-outline-primary">➕Nuevo Detalle de Venta</a>
	<?php
	}
	?>
</div>