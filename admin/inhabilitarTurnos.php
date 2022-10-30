<h2 class="m__Art__h2">Selecciona la fecha que quierea Inabilitar</h2>
<form action="<?php echo $_SERVER['PHP_SELF'].'?page=cancelSchedule' ?>" method="post">
<?php
{
     //Evitando que se limpien los campos
     /*if(isset($_POST['day'])) $value=$_POST['day'];
     else $value=null;*/
   $options=['text'=>[],'value'=>[]];
     //query to the db
       $query=
         'SELECT 
           DATE_FORMAT(id_fecha,"%d/%m/%Y -- %h:%i %p") AS fecha_formateada,
           id_fecha,
           DATE_FORMAT(id_fecha,"%w") AS week_day,
           (select id_fecha from fechasDisponibles where isdisponible=1 AND id_fecha > NOW() order by id_fecha asc limit 1)
         FROM fechasDisponibles
         WHERE 
           isDisponible=1 AND 
           id_fecha between
           (select id_fecha from fechasDisponibles where isdisponible=1 AND id_fecha > NOW() order by id_fecha asc limit 1)
           and DATE_ADD((select id_fecha from fechasDisponibles where isdisponible=1 AND id_fecha > NOW() order by id_fecha asc limit 1), INTERVAL 7 DAY)
           order by isDisponible  DESC;';
       $result=mysqli_query($cnx,$query);
       while($queryRow=mysqli_fetch_assoc($result)){
         //Agregando el dia de la semana en Español
         $weekDay=$queryRow['week_day'];
         switch ($weekDay) {
           case 0:$weekDay='Domingo'; break;
           case 1:$weekDay='Lunes';break;
           case 2:$weekDay='Martes';break;
           case 3:$weekDay='Miercoles';break;
           case 4:$weekDay='Jueves';break;
           case 5:$weekDay='Viernes';break;
           case 6:$weekDay='Sabado';break;
         }
         array_push($options['text'],$weekDay.' '.$queryRow['fecha_formateada']);
         array_push($options['value'],$queryRow['id_fecha']);
       } 
       mysqli_free_result($result);
       select('Fecha y hora','day',' name="day"',$options,$value=null);
}
btn('button','callToAction','Enviar',' type="submit" name="submited"',' Enviar ');
?></form>
<?php
if(isset($_POST['submited'])){
    $components=function(){ ?>

    <div class="d__flatBtnContainer"><?php
        ?>
        <input type="hidden" name="day" value="<?php echo $_POST['day'] ?>">
        <?php
        btn('button','error','Cancelar',' name="cancel1" type="submit"',' Cancelar ');
        btn('button','ok','Aceptar',' name="confirm1" type="submit"',' Aceptar ');
        ?>
    </div><?php
    };
    dialog('¿Estas segur@?',
        'Estas segura que deseas inhabilitar este turno, si lo haces la fecha no aparecera disponible paara tus clientes'
        ,$components,
        'action="'.$_SERVER['PHP_SELF'].'?page=cancelSchedule" method="post"');
}



if(isset($_POST['confirm1'])){
    $components=function(){
        btn('button','ok','Aceptar',' type="submit"',' Aceptar ');
    };
    dialog('Proceso exitoso',
        'La fecha seleccionada se ha desabilitado para los clientes correctamente',
        $components,
        'action="'.$_SERVER['PHP_SELF'].'?page=cancelSchedule" method="post"');
    //doing the query
    $query='UPDATE fechasDisponibles set isdisponible=0 WHERE id_fecha="'.skap($_POST['day']).'";';
    mysqli_query($cnx,$query);
}elseif(isset($_POST['cancel1'])){
    $components=function(){
        btn('button','error','Aceptar',' name="cancel1" type="submit"',' Aceptar ');
    };
    dialog('Proceso cancelado',
        'No se ha inhabilitado ninguna fecha',
        $components,
        'action="'.$_SERVER['PHP_SELF'].'?page=cancelSchedule" method="post"');
}