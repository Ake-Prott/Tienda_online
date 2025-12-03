<?php
// Lista todos los archivos de la carpeta img
foreach(glob("assets/img/*.*") as $archivo) {
    echo "<img src='$archivo' width='200'><br>";
    echo $archivo . "<br><br>";
}
?>