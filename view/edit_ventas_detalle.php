<?php
foreach ($campos as $key => $encabezado) {
	$$key = "";
	if (isset($dataToView["data"][$key])) $$key = $dataToView["data"][$key];
}
if (isset($_GET["id_venta"])) {
	$id_venta = $_GET["id_venta"];
}
?>
<div class="form-control">
	<?php
	if (isset($_GET["response"]) and $_GET["response"] === true) {
	?>
		<div class="alert alert-success">
			Operación realizada correctamente. <a href="index.php?controller=venta&action=list">Volver al listado</a>
		</div>
	<?php
	}
	?>
	<script>
		function chg(o) {
			let f = o.form;
			if (o.name == "id_producto") {
				f.precio_unitario.value = o.options[o.selectedIndex].dataset.precio;
			}
			f.subtotal.value = Number(f.cantidad.value) * Number(f.precio_unitario.value);
		}
	</script>
	<form class="form" action="index.php?controller=<?= $_GET["controller"] ?>&action=save" method="POST">
		<input type="hidden" name="id" value="<?= $id ?? '' ?>" />
		<div class="form-container">
			<?php
			$precio_unitario = 0;
			foreach ($campos as $key => $encabezado) {
				if ($key == "id_producto") {
			?> <div class="form-group">
						<label for="<?= $key ?>" class="fw-bold"><?= $encabezado ?></label>
						<select name="<?= $key ?>" id="<?= $key ?>" onchange="chg(this)">
							<?php foreach ($dataToView["dataRel1"] as $rel1) {
								if ($precio_unitario == 0) {
									$precio_unitario = $rel1["precio"];
								}
							?>
								<option data-precio="<?= $rel1["precio"] ?>" value="<?= $rel1["id"] ?>" <?php
								if ($rel1["id"] == $$key) {
									echo "selected";
									$precio_unitario = $rel1["precio"];
								}
								?>>
								<?= $rel1["nombre"] ?> ($ <?= $rel1["precio"] ?>)
								</option>
							<?php } ?>
						</select>
					</div>
				<?php
				} else if ($key == "id_venta") {
				?><input type="hidden" name="id_venta" value="<?= $id_venta ?>" />
					<div class="form-group">
						<label class="fw-bold">Venta Nº</label>
						<?= $id_venta ?>
					</div>
				<?php
				} else if ($encabezado !== "" && $encabezado !== "ID") {
				?>
					<div class="form-group">
						<label for="<?= $key ?>" class="fw-bold"><?= $encabezado ?></label>
						<input class="form-control"
							<?php if ($key == "cantidad") {
								if ($$key == "") {
									$cantidad = 1;
								}
							?>
							type='number' step='1' min='0' value="<?= $cantidad ?>" onchange="chg(this)"
							<?php } else { ?>
							type="number" step='0.01' min='0.00' value="<?php
							if ($$key != "") {
								echo $$key;
							} else if ($key == "precio_unitario") {
								echo $precio_unitario;
							} else if ($key == "subtotal") {
								echo $precio_unitario * $cantidad;
							}
							?>" onchange="chg(this)"
							<?php
							} ?> name="<?= $key ?>" id="<?= $key ?>" />
					</div>
			<?php
				}
			}
			?><p></p>
			<input type="submit" value="Guardar" class="btn btn-primary" />
			<a class="btn btn-primary" href="index.php?controller=venta&action=list">Cancelar</a>
	</form>
</div>
</div>