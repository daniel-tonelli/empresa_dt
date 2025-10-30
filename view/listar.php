	<table class="table">
		<thead class="table-dark">
			<tr>
				<?php
				foreach ($campos as $key => $encabezado) {
					if ($encabezado !== "" && $encabezado !== "ID" && $encabezado !== "Contraseña") {
						echo "<th>" . $encabezado . "</th>";
					}
				}
				?>
				<th colspan=" 2">Funciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($dataToView["data"] as $tabla): ?>
				<tr>
					<?php
					foreach ($campos as $key => $encabezado) {
						if ($encabezado !== "" && $encabezado !== "ID" && $encabezado !== "Contraseña") {
							echo "<td>";
							if ($key == "id_cliente") {
								echo "(" . $tabla[$key] . ") " . $tabla["apellido"] . ", " . $tabla["nombre"];
							} else if ($key == "id_producto") {
								echo "(" . $tabla[$key] . ") " . $tabla["nombre"];
							} else if ($key == "id_rol") {
								echo "(" . $tabla[$key] . ") " . $tabla["rol"];
							} else {
								echo $tabla[$key];
							}
							echo "</td>";
						} elseif ($encabezado == "ID") {
							$id = $tabla[$key];
						}
					}
					?>
					<td>
						<a href="index.php?controller=<?= $_GET["controller"] ?>&action=edit&id=<?php echo $id; ?>" class="btn btn-primary">Editar</a>
					</td>
					<td>
						<a href="index.php?controller=<?= $_GET["controller"] ?>&action=confirmDelete&id=<?php echo $id; ?>" class="btn btn-danger">Eliminar</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php if (count($dataToView["data"]) == 0): ?>
		<div class="alert alert-info">
			Actualmente no existen <?= $_GET["controller"] ?>s.
		</div>
	<?php endif; ?>