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
		<input type="hidden" name="id" value="<?= $id ?? '' ?>" />
		<div class="form-container">
			<?php

			foreach ($campos as $key => $encabezado) {
				if ($key == "id_producto") {
			?> <div class="form-group">
						<label class="fw-bold"><?= $encabezado ?></label>
						<select name="<?= $key ?>" id="<?= $key ?>" required>
							<?php foreach ($dataToView["dataRel1"] as $rel1) { ?>
								<option value="<?= $rel1["id"] ?>" <?= $rel1["id"] == $$key ? "selected" : "" ?>>
									<?= $rel1["nombre"] ?> ($ <?= $rel1["precio"] ?>)
								</option>
							<?php } ?>
						</select>
					</div>
				<?php
				} else if ($encabezado == "Venta") {
				?><input type="hidden" name="id_venta" value="<?= $id_venta ?>" />
				<?php
				} else if ($encabezado !== "" && $encabezado !== "ID") {
				?>
					<div class="form-group">
						<label class="fw-bold"><?= $encabezado ?></label>
						<input class="form-control"
							<?php if ($key == "cantidad") { ?>
							type='number' step='1' min='0' value="0"
							<?php } else { ?>
							type="number" step='0.01' min='0.00' value="0.00"
							<?php } ?>
							name="<?= $key ?>" value="<?= $$key ?>" />
					</div>
			<?php
				}
			}
			?><p></p>
			<input type="submit" value="Guardar" class="btn btn-primary" />
			<a class="btn btn-primary" href="index.php?controller=<?= $_GET["controller"] ?>&action=list">Cancelar</a>
	</form>
</div>
</div>