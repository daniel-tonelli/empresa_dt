<?php
foreach ($campos as $key => $encabezado) {
	$$key = "";
	if (isset($dataToView["data"][$key])) $$key = $dataToView["data"][$key];
}
?>
<div class="form-control">
	<?php
	if (isset($_GET["response"]) and $_GET["response"] === true) {
	?>
		<div class="alert alert-success">
			Operación realizada correctamente. <a href="index.php?controller=<?= $_GET["controller"] ?>&action=list">Volver al listado</a>
		</div>
	<?php
	}
	?>

	<form class="form" action="index.php?controller=<?= $_GET["controller"] ?>&action=save" method="POST">
		<?php

		foreach ($campos as $key => $encabezado) {
			if ($key == "id_cliente") {
		?> <div class="form-group">
					<label class="fw-bold"><?= $encabezado ?></label>
					<select name="<?= $key ?>" id="<?= $key ?>" required>
						<?php foreach ($dataToView["dataRel1"] as $rel1) { ?>
							<option value="<?= $rel1["id"] ?>" <?= $rel1["id"]==$$key?"selected":"" ?>>
								<?= $rel1["apellido"] ?>, <?= $rel1["nombre"] ?>
							</option>
						<?php } ?>
					</select>
				</div>
			<?php
			} else {
			?><input type="hidden" name="<?= $key ?>" value="<?= $$key ?>" /><?php
		}
	}
			?> <p></p>
		<input type="submit" value="Guardar" class="btn btn-primary" />
		<a class="btn btn-primary" href="index.php?controller=<?= $_GET["controller"] ?>&action=list">Cancelar</a>
	</form>
</div>