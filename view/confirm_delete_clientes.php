<div class="row">
	<form class="form" action="index.php?controller=<?= $_GET["controller"] ?>&action=delete" method="POST">
		<input type="hidden" name="id" value="<?= $dataToView["data"]["id"] ?>">
		<?php
		if ($dataToView["data"]["id"] == $dataToView["data"]["id_cliente"]) {
		?>
		<div class="alert alert-danger">
			<p><b>No es posible eliminar este cliente porque registra <?=
			 	$dataToView["data"]["cant_ventas"] 
			 ?> ventas</b></p>
			<?php
			foreach ($campos as $key => $encabezado) {
				echo "<p><b>" . $encabezado . ":</b>" . $dataToView["data"][$key] . "</p>";
			}
			?>
		</div>
		<?php
		} else {
		?>
			<div class="alert alert-warning">
				<p><b>¿Confirma que desea eliminar este/a <?= $_GET["controller"] ?>?</b></p>
				<?php
				foreach ($campos as $key => $encabezado) {
					echo "<p><b>" . $encabezado . ":</b>" . $dataToView["data"][$key] . "</p>";
				}
				?>
			</div>
			<input type="submit" value="Eliminar" class="btn btn-danger" /><?php
																		}
																			?>
		<a class="btn btn-primary" href="index.php?controller=<?= $_GET["controller"] ?>&action=list">Cancelar</a>
	</form>
</div>