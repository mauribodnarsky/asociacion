<?php
function controllers_autoload($classname){
	

$env= getenv("ENVIRONMENT");
if($env=="produccion"){
	require_once 'controllers/' . ucfirst($classname) . '.php';

}else{
	include 'controllers/' . $classname . '.php';
}
}	

spl_autoload_register('controllers_autoload');