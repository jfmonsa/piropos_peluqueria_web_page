<?php
$components=
    function(){
        btn('a','ok','Ir al inicio',"href='index.php'","Regresar");
    };
dialog(
"Enlace roto",
"El enlace que buscas esta roto, presiona el botón para regresar en la pagina de inicio donde seguro 
encontraras lo que buscabas",
$components,
);
