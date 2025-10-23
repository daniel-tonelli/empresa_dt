<div class="row">
	<?php
	if ($dataToView["data"] == "1") {
	?>
		<div class="alert alert-success">
			<?= $_GET["controller"] ?> eliminado correctamente.
			<a href="index.php?controller=<?= $_GET["controller"] ?>&action=list"></a>
		</div>
	<?php
	} else {
	?>
		<div class="alert alert-danger">
			<?= $_GET["controller"] ?> NO eliminado.
			<p>
				<?= $dataToView["data"] ?>
			</p>
			<a href="index.php?controller=<?= $_GET["controller"] ?>&action=list"></a>
		</div>
	<?php

	}
	?>
</div>