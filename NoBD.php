<?php
$components=
    function(){
        btn('a','ok','Contactanos',
        ' href="https://api.whatsapp.com/send?phone=+573166183543" target="_blank" ');
    };
dialog(
"Lo Sentimos",
"Por ahora estamos teniendo problemas, por favor ingresa mas tarde, estamos haciendo todo lo posible por solucionar
estos problemas
<br><br>
Si deseas contactarnos urgentemente presiona este boton que te dirigira a nuestro Whatsapp y con gusto te atenderemos",
$components,
);

