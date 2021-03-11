<?php
require_once('controlador/ctac.php');
?>
<div class="dtit">
<span class="titu">Tipo de acto</span>
</div>
<hr class="section-divider">
<?php seleccionar($idtac, "514"); ?>
<br><br>
<center><div>
<?php cargar($conp,$nreg,$pg,$bo,$filtro,$arc); ?>
</div></center>
