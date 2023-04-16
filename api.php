<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header('content-type: application/json; charset=utf-8');
require_once 'models/canal.php';
require_once 'models/hijuela.php';
require_once 'models/rama.php';
require_once 'models/turno.php';
require_once 'models/regante.php';
require_once 'config/db.php';
require_once 'vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

if(isset($_POST['canal'])){
  $canal=$_POST['canal'];
  $rama=new Rama();
  $ramas=$rama->ObtenerRamasPorCanal($canal);
  echo json_encode($ramas);

}
    

if(isset($_POST['rama'])){
  $rama=$_POST['rama'];
  $hijuela=new Hijuela();
  $hijuelas=$hijuela->ObtenerHijuelasPorRama($rama);
  echo json_encode($hijuelas);
}
if(isset($_POST['clave'])){
  $clave=$_POST['clave'];
  $turno=new Turno();
  $turnos=$turno->imprimirPorRegante($clave);
  echo json_encode($turnos);
}
if(isset($_POST['busquedaregante'])){
  $busqueda=$_POST['busquedaregante'];
  $regante=new Regante();
  $regantes=$regante->buscarregante($busqueda);
echo json_encode($regantes);
}
if(isset($_POST['canalimprimir'])){
  $clave=$_POST['canalimprimir'];
  $turno=new Turno();
  $turnos=$turno->imprimirPorFiltro($clave);
  $regantes=$turno->ObtenerRegantesImprimir($clave);
  $pdf="";
foreach($regantes as $regante){
  $pdf.="<div class=\"row\"><div class=\"col-4\"><div class=\"row\"><div class=\"col-12\">ASOCIACION NUEVA ALVEAR <br>CANAL:".$regante['canal'].'<br>RAMA:'.$regante['rama']."<br>HIJUELA:".$regante['hijuela'];
  $pdf.="<br>NOMBRE:".$regante['regante']."<br>HECTAR. :".$regante['hectareas']."<br>MIN.HECTAR. :".$regante['hshectareas']."<br><br><br><br><br><br><br><br></div></div></div><div class=\"col-4\">HS.HECTAR.:".$regante['hshectareas']."<br>RECORRIDO.:".$regante['hectareas']."<br>DESCYEL.: ".$regante['hectareas']."<br>AGUA DEMANDA:".$regante['hectareas']."<br>AGUA OFERTA:".$regante['hectareas']."<br>REFUERZO:".$regante['hectareas']."<br>CORTE:".$regante['hectareas']."<br>TOTAL:".$regante['hectareas']."</div></div><hr>";
  
  $pdf.='<div class="row"><div class="col-12"><div class="row"><div class="col-4">FECHA</div><div class="col-4">DESDE(Hora)</div><div class="col-4">HASTA (Hora)</div></div></div></div></div><hr>';
  $clave=$regante['clave'];  
  $turnos=$turno->imprimirPorFiltro($clave);
  foreach($turnos as $turn) {
    $pdf.= '<div class="row"><div class="col-12"><div class="row"><div class="col-4">'.$turn['fechaturno'].'</div><div class="col-4">'.$turn['hsdesde'].'</div><div class="col-4">'.$turn['hshasta'].'</div></div></div></div></div>';  
  }
  $pdf.='<div class="row"><div class="col-12"><hr></div></div>';
  $pdf.='<div class="row"><div class="col-4 offset-8">- - - - - - - - - - - - - - - - - - - - - -</div></div>';
  $pdf.='<div class="row"><div class="col-12">NOTA: EL TENEDOR DEL PRESENTE TURNO ES DIRECTAMENTE RESPONSABLE DE TODO PERJUICIO (DERRAMES DE AGUA, DERRUMBES, ETC.) OCASIONADOS DURANTE LA DURACION DEL TURNO.<br>EL INTERESADO QUE VIOLACE EL TURNO O SACARA AGUA EN LOS PERIODOS QUE NO LE CORRESPONDA SERA PENADO DE ACUERDO A LA LEY DE AGUAS ART. 27.</div></div>';
  
}



  echo json_encode($pdf);
}

if(isset($_POST['ramaimprimir'])){
  $clave=$_POST['ramaimprimir'];
  $turno=new Turno();  
$regantes=$turno->ObtenerRegantesImprimir($clave);
$pdf="";
foreach($regantes as $regante){
  $objspipu= new html2pdf('H','A3','es', false, 'UTF-8');
  $pdf.="<div class=\"row h-100 \"><div class=\"col-12\">";
  $pdf.="<div class=\"row\"><div class=\"col-4\"><div class=\"row\"><div class=\"col-12\">ASOCIACION NUEVA ALVEAR <br>CANAL:".$regante['canal'].'<br>RAMA:'.$regante['rama']."<br>HIJUELA:".$regante['hijuela'];
  $pdf.="<br>NOMBRE:".$regante['regante']."<br>HECTAR. :".$regante['hectareas']."<br>MIN.HECTAR. :".$regante['hshectareas']."<br><br><br><br><br><br><br><br></div></div></div><div class=\"col-4\">HS.HECTAR.:".$regante['hshectareas']."<br>RECORRIDO.:".$regante['hectareas']."<br>DESCYEL.: ".$regante['hectareas']."<br>AGUA DEMANDA:".$regante['hectareas']."<br>AGUA OFERTA:".$regante['hectareas']."<br>REFUERZO:".$regante['hectareas']."<br>CORTE:".$regante['hectareas']."<br>TOTAL:".$regante['hectareas']."</div></div><hr>";
  $pdf.='<div class="row"><div class="col-12"><div class="row"><div class="col-4">FECHA</div><div class="col-4">DESDE(Hora)</div><div class="col-4">HASTA (Hora)</div></div></div></div><hr>';
$pdfarchivo="";
  $pdfarchivo.="<div class=\"row h-100 \"><div class=\"col-12\">";
  $pdfarchivo.="<div class=\"row\"><div class=\"col-4\"><div class=\"row\"><div class=\"col-12\">ASOCIACION NUEVA ALVEAR <br>CANAL:".$regante['canal'].'<br>RAMA:'.$regante['rama']."<br>HIJUELA:".$regante['hijuela'];
  $pdfarchivo.="<br>NOMBRE:".$regante['regante']."<br>HECTAR. :".$regante['hectareas']."<br>MIN.HECTAR. :".$regante['hshectareas']."<br><br><br><br><br><br><br><br></div></div></div><div class=\"col-4\">HS.HECTAR.:".$regante['hshectareas']."<br>RECORRIDO.:".$regante['hectareas']."<br>DESCYEL.: ".$regante['hectareas']."<br>AGUA DEMANDA:".$regante['hectareas']."<br>AGUA OFERTA:".$regante['hectareas']."<br>REFUERZO:".$regante['hectareas']."<br>CORTE:".$regante['hectareas']."<br>TOTAL:".$regante['hectareas']."</div></div><hr>";
  $pdfarchivo.='<div class="row"><div class="col-12"><div class="row"><div class="col-4">FECHA</div><div class="col-4">DESDE(Hora)</div><div class="col-4">HASTA (Hora)</div></div></div></div><hr>';
  $clave=$regante['clave'];  
  $turnos=$turno->imprimirPorFiltro($clave);
  foreach($turnos as $turn) {
    $pdf.= '<div class="row"><div class="col-12"><div class="row"><div class="col-4">'.$turn['fechaturno'].'</div><div class="col-4">'.$turn['hsdesde'].'</div><div class="col-4">'.$turn['hshasta'].'</div></div></div></div>';  
    $pdfarchivo.= '<div class="row"><div class="col-12"><div class="row"><div class="col-4">'.$turn['fechaturno'].'</div><div class="col-4">'.$turn['hsdesde'].'</div><div class="col-4">'.$turn['hshasta'].'</div></div></div></div>';  
  }
  $pdf.='<div class="row"><div class="col-12"><hr></div></div>';
  $pdf.='<div class="row"><div class="col-4 offset-8">- - - - - - - - - - - - - - - - - - - - - -</div></div>';
  $pdf.='<div class="row"><div class="col-12">NOTA: EL TENEDOR DEL PRESENTE TURNO ES DIRECTAMENTE RESPONSABLE DE TODO PERJUICIO (DERRAMES DE AGUA, DERRUMBES, ETC.) OCASIONADOS DURANTE LA DURACION DEL TURNO.<br>EL INTERESADO QUE VIOLACE EL TURNO O SACARA AGUA EN LOS PERIODOS QUE NO LE CORRESPONDA SERA PENADO DE ACUERDO A LA LEY DE AGUAS ART. 27.</div></div></div></div>';
  
  $pdfarchivo.='<div class="row"><div class="col-12"><hr></div></div>';
  $pdfarchivo.='<div class="row"><div class="col-4 offset-8">- - - - - - - - - - - - - - - - - - - - - -</div></div>';
  $pdfarchivo.='<div class="row"><div class="col-12">NOTA: EL TENEDOR DEL PRESENTE TURNO ES DIRECTAMENTE RESPONSABLE DE TODO PERJUICIO (DERRAMES DE AGUA, DERRUMBES, ETC.) OCASIONADOS DURANTE LA DURACION DEL TURNO.<br>EL INTERESADO QUE VIOLACE EL TURNO O SACARA AGUA EN LOS PERIODOS QUE NO LE CORRESPONDA SERA PENADO DE ACUERDO A LA LEY DE AGUAS ART. 27.</div></div></div></div>';
  $objspipu->writeHTML($pdfarchivo);
  $nombrearchivo=$regante['regante'];
  $objspipu->output(__DIR__.'./turnoscarpeta/'.$nombrearchivo.'.pdf', 'F');
}
$objspipu= new html2pdf('H','A3','es', false, 'UTF-8');
$objspipu->writeHTML($pdf);
$objspipu->output(__DIR__.'./turnoscarpeta/todos.pdf', 'F');

  echo $pdf;
}

if(isset($_POST['hijuelaimprimir'])){
  $clave=$_POST['hijuelaimprimir'];
  $turno=new Turno();
  $turnos=$turno->imprimirPorFiltro($clave);
  
  $regantes=$turno->ObtenerRegantesImprimir($clave);




$pdf="";
foreach($regantes as $regante){
  $pdf.="<div class=\"row\"><div class=\"col-4\"><div class=\"row\"><div class=\"col-12\">ASOCIACION NUEVA ALVEAR <br>CANAL:".$regante['canal'].'<br>RAMA:'.$regante['rama']."<br>HIJUELA:".$regante['hijuela'];
  $pdf.="<br>NOMBRE:".$regante['regante']."<br>HECTAR. :".$regante['hectareas']."<br>MIN.HECTAR. :".$regante['hshectareas']."<br><br><br><br><br><br><br><br></div></div></div><div class=\"col-4\">HS.HECTAR.:".$regante['hshectareas']."<br>RECORRIDO.:".$regante['hectareas']."<br>DESCYEL.: ".$regante['hectareas']."<br>AGUA DEMANDA:".$regante['hectareas']."<br>AGUA OFERTA:".$regante['hectareas']."<br>REFUERZO:".$regante['hectareas']."<br>CORTE:".$regante['hectareas']."<br>TOTAL:".$regante['hectareas']."</div></div><hr>";
  
  $pdf.='<div class="row"><div class="col-12"><div class="row"><div class="col-4">FECHA</div><div class="col-4">DESDE(Hora)</div><div class="col-4">HASTA (Hora)</div></div></div></div></div><hr>';
  $clave=$regante['clave'];  
  $turnos=$turno->imprimirPorFiltro($clave);
  foreach($turnos as $turn) {
    $pdf.= '<div class="row"><div class="col-12"><div class="row"><div class="col-4">'.$turn['fechaturno'].'</div><div class="col-4">'.$turn['hsdesde'].'</div><div class="col-4">'.$turn['hshasta'].'</div></div></div></div></div>';  
  }
  $pdf.='<div class="row"><div class="col-12"><hr></div></div>';
  $pdf.='<div class="row"><div class="col-4 offset-8">- - - - - - - - - - - - - - - - - - - - - -</div></div>';
  $pdf.='<div class="row"><div class="col-12">NOTA: EL TENEDOR DEL PRESENTE TURNO ES DIRECTAMENTE RESPONSABLE DE TODO PERJUICIO (DERRAMES DE AGUA, DERRUMBES, ETC.) OCASIONADOS DURANTE LA DURACION DEL TURNO.<br>EL INTERESADO QUE VIOLACE EL TURNO O SACARA AGUA EN LOS PERIODOS QUE NO LE CORRESPONDA SERA PENADO DE ACUERDO A LA LEY DE AGUAS ART. 27.</div></div>';
  
}



  echo json_encode($pdf);
}


    

    