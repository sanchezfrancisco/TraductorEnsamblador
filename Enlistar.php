<?php
/////////////ENLISTAR LOS FICHEROS EXISTENTES///////////////////////////////////////////////
$listar = null;
$directorio=opendir("docs/");

while ($elemento = readdir($directorio))
{
  if ($elemento != '.' && $elemento != '..')
  {
  if (is_dir("docs/".$elemento))
  {
    $listar .="<a class=' col-md-6' href='docs/$elemento' target='_blank'> 
    $elemento/</a>
    <br><br>";
  }
  else
  {
     $listar .="<a class=' col-md-6' href='docs/$elemento' target='_blank'> 
    $elemento</a>
    <br><br>";
  }
  }
}
?>