<?php
require_once('modelo/conexion.php');
require_once('modelo/mtac.php');
require_once("modelo/mpagina.php");
$pg = 514;
$arc = "home.php";
$mtac = new mtac();
$idtac = isset($_POST['idtac']) ? $_POST['idtac']:NULL;
if(!$idtac)
$idtac = isset($_GET['idtac']) ? $_GET['idtac']:NULL;
$nomtac = isset($_POST['nomtac']) ? $_POST['nomtac']:NULL;
$deptac = isset($_POST['deptac']) ? $_POST['deptac']:NULL;
$filtro = isset($_GET["filtro"]) ? $_GET["filtro"]:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;
//Insertar
if($opera=="insertar"){
if ($idtac && $nomtac){
$result=$mtac->inspag($idtac, $nomtac, $deptac);

$idtac = "";
}
else{
echo "<script>alert('FAVOR LLENAR TODOS LOS CAMPOS')</script>";
}
$opera = "";
}
//Actualizar
if($opera=="actualizar"){
if ($idtac && $nomtac){
$result=$mtac->updpag("nomtac", $nomtac, $idtac);
$result=$mtac->updpag("deptac", $deptac, $idtac);
$idtac = "";
}
else{
echo "<script>alert('HAY CAMPOS VACIOS')</script>";
}
$opera = "";
}
//Eliminar
if($opera=="eliminar"){
if ($idtac){
$result=$mtac->elipag($idtac);
$idtac = "";
}
else{
echo "<script>alert('ERROR AL ELIMINAR')</script>";
}
$opera = "";
}
//paginacion
$bo="";
$nreg = 10;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mtac->sqlcount($filtro);
function cargar($conp,$nreg,$pg,$bo,$filtro,$arc){
$mtac=new mtac();
$pa = new mpagina($nreg);
$txt = '<div align="center" style="padding-bottom: 20px;">';
$txt .= '<table>';
$txt .= '<tr>';
$txt .= '<td>';
$txt .= '<form id="formfil" name="frmfil" method="GET" action="'.$arc.'" class="txtbold">';
$txt .= '<input name="pg" type="hidden" value="'.$pg.'" />';
$txt .= '<input class="form-control" type="text" name="filtro" value="'.$filtro.'" placeholder="Nombre de tipo de acto"
onChange="this.form.submit();">';
$txt .= '</form>';
$txt .= '</td>';
$txt .= '<td align="right" style="padding-left: 10px;">';
$bo = "<input type='hidden' name='filtro' value='".$filtro."' />";
$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
$result = $mtac->selpag($filtro, $pa->rvalini(), $pa->rvalfin());
$txt .= '</td>';
$txt .= '</tr>';

$txt .= '</table>';
$txt .= '</div>';
if ($result){
$txt .= "<table class='table table-hover'>
<tr>
<th class='success'>Id</th>
<th class='success'>Tipo de Acto</th>
<th class='success'>Depende</th>
<th class='success'></th>
</tr>";
foreach ($result as $f){
$txt .= "<tr>";
$txt .= "<td class='active' align='center'>".$f['idtac']."</td>";
$txt .= "<td class='active'>".utf8_encode($f['nomtac'])."</td>";
$txt .= "<td class='active'>".$f['deptac']."</td>";
$txt .= "<td class='warning' align='center'><a href='home.php?idtac=".$f['idtac']."&pg=".$pg."'><img src='image/new.png'
title='Actualizar'></a>";
$txt .= "&nbsp;&nbsp;&nbsp;";
$txt .= "<a href='home.php?idtac=".$f['idtac']."&opera=eliminar&pg=".$pg."' onclick='return eliminar();'><img
src='image/trash.png' title='Eliminar'></a></td>";
$txt .= "</tr>";
}
$txt .= "</table>";
echo $txt;
}
}
function seleccionar($idtac, $pg){
$mtac=new mtac();
if($idtac){
$result=$mtac->selpag1($idtac);
}
$dttipd = $mtac->seltipd();
$txt = '<form action="home.php?pg='.$pg.'" method="POST">
<div class="container">';
$txt .= '<label>C&oacute;digo</label>';
$txt .= '<input type="number" name="idtac" value="';
if($idtac) $txt .= $result[0]['idtac'];
$txt .= '"';
if($idtac) $txt .= ' readonly';
$txt .= ' required class="form-control">';
$txt .= '<label>Nombre</label>';
$txt .= '<input type="text" name="nomtac" value="';
if($idtac){ $txt .= $result[0]['nomtac']; }
$txt .= '" required class="form-control">';
$txt .= '<label>Depende</label>';
$txt .= '<select name="deptac" class="form-control">';
$txt .= '<option value="0">Seleccione</option>';
$txt .= '<option value="0">Sin dependencia</option>';
foreach($dttipd as $dttpd){
$txt .= '<option value="'.$dttpd["idtac"].'"';
if($idtac AND $result[0]['deptac']==$dttpd["idtac"]){ $txt .= " selected "; }
$txt .= '>'.utf8_encode($dttpd["nomtac"]).'</option>';
}
$txt .= '</select>';
$txt .= '<input type="hidden" name="opera" value="';
if($idtac){ $txt .= "actualizar"; } else { $txt .= "insertar"; }
$txt .= '"><br><center><button type="submit" class="btn btn-success">';
if($idtac){ $txt .= "Actualizar"; } else { $txt .= "Registrar"; }
$txt .= '</button>';
$txt .= '&nbsp;&nbsp;&nbsp;';
$txt .= '<input type="reset" class="btn btn-success" value="';
if($idtac){ $txt .= "Cancelar"; } else { $txt .= "Limpiar"; }
$txt .= '"';
if($idtac) $txt .= " onclick='window.history.back();' ";
$txt .= ' />';
$txt .= '</center>
</div>
</form>';
echo $txt;
}
?>
