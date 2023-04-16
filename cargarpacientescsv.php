<?php

	$planillarecibida=fopen("C:\Users\mauricio\Desktop\pacientes_listo.csv",'r');

	$db = new mysqli('localhost', 'root', 'ROOT', 'reprocan');
		$db->query("SET NAMES 'utf8'");
      $c=0;

      while ($data = fgetcsv ($planillarecibida, 100000, "|")) {
   $data[0]=utf8_encode($data[0]);
   $data[1]=utf8_encode($data[1]);
   $data[2]=utf8_encode($data[2]);
   $data[3]=utf8_encode($data[3]);
   $data[4]=utf8_encode($data[4]);
   $data[5]=utf8_encode($data[5]);
   $data[6]=utf8_encode($data[6]);
   $data[7]=utf8_encode($data[7]);
   $data[8]=utf8_encode($data[8]);
   $data[9]=utf8_encode($data[9]);
   $data[10]=utf8_encode($data[10]);
   $data[11]=utf8_encode($data[11]);
   $data[12]=utf8_encode($data[12]);
   $data[13]=utf8_encode($data[13]);
      $sql="INSERT INTO pacientes VALUES(".$data[0].",'".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."',".$data[12].",'".$data[13]."');";
      $resultado=$db->query($sql);
      if($resultado){
         $c=$c+1;
      }
      echo $c."<br>";  
    }

 fclose($planillarecibida);


