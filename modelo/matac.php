<?php
class mtac{
public function inspag($idtac,$nomtac, $deptac){
$modelo=new conexion();
$conexion=$modelo->get_conexion();
$sql="INSERT INTO tipacto (idtac, nomtac, deptac) VALUES (:idtac, :nomtac, :deptac)";
//echo $sql;
$result=$conexion->prepare($sql);
$result->bindParam(':idtac', $idtac);
$result->bindParam(':nomtac', $nomtac);
$result->bindParam(':deptac', $deptac);
if(!$result)
echo "<script>alert('ERROR AL REGISTRAR')</script>";
else
$result->execute();

}
public function selpag($filtro,$rvalini,$rvalfin){

$resultado=null;
$modelo=new conexion();
$conexion=$modelo->get_conexion();
$sql="SELECT idtac, nomtac, deptac FROM tipacto";
if ($filtro){
$filtro = "%".$filtro."%";
$sql .= " WHERE nomtac LIKE :filtro";
}

$sql .= " ORDER BY idtac LIMIT $rvalini, $rvalfin;";
//echo $sql;
$result=$conexion->prepare($sql);
$result->bindParam(':filtro', $filtro);
$result->execute();
while($f=$result->fetch()){
$resultado[]=$f;
}
return $resultado;
}


public function sqlcount($filtro){
$sql="SELECT count(idtac) AS Npe FROM tipacto";
if ($filtro)
$sql .= " WHERE nomtac LIKE '%$filtro%';";
return $sql;


}
public function selpag1($idtac){
$resultado=null;
$modelo=new conexion();
$conexion=$modelo->get_conexion();

$sql="SELECT * FROM tipacto WHERE idtac= :idtac";
$result=$conexion->prepare($sql);
$result->bindParam(':idtac', $idtac);
$result->execute();
while($f=$result->fetch()){
$resultado[]=$f;
}
return $resultado;

}
public function updpag($campo, $valor, $idtac){
$modelo=new conexion();
$conexion=$modelo->get_conexion();
$sql="UPDATE tipacto SET $campo= :valor WHERE idtac= :idtac";
$result=$conexion->prepare($sql);
$result->bindParam(':valor', $valor);
$result->bindParam(':idtac', $idtac);
if(!$result)
echo "<script>alert('ERROR AL MODIFICAR')</script>";
else
$result->execute();
}
public function elipag($idtac){
$modelo=new conexion();
$conexion=$modelo->get_conexion();
$sql="DELETE FROM tipacto WHERE idtac= :idtac";
$result=$conexion->prepare($sql);
$result->bindParam(':idtac', $idtac);
if (!$result)
echo "<script>alert('ERROR AL ELIMINAR')</script>";
else
$result->execute();
}
public function seltipd(){
$resultado=null;
$modelo=new conexion();
$conexion=$modelo->get_conexion();
$sql="SELECT idtac, nomtac, deptac FROM tipacto WHERE deptac='0';";
$result=$conexion->prepare($sql);
$result->execute();
while($f=$result->fetch()){
$resultado[]=$f;
}
return $resultado;

}
}
?>
