<form action="" method="post">
    <label for="onlydate">Fecha</label>
    <input type="date" 
    min="<?php 
    //Valor minimo para elegir en el rango de fechas puede ser:
        //Dia actual
            //date('Y-m-d',time()) ;
        //Ultima Fecha registrada
            $query="select * from fechasdisponibles order by ID_FECHA DESC LIMIT 1;";
            $result=mysqli_query($cnx,$query);
            $row=mysqli_fetch_assoc($result);
            $min=substr($row['id_fecha'],0,10) ;
            echo $min;
        //Estan las dos opciones para que sea mas comodo elegir la fecha en caso de elegir una comentar la otra
    ?>"
    max="<?php 
        $year=intval(date('Y',time()))+1;
        $month=date('m',time());
        $day=date('d',time());
        echo $year.'-'.$month.'-'.$day;
        ?>" 
    name="onlydate" 
    id="onlydate"
    >
    <input type="submit" value="enviar">
</form>
<?php
if(isset($_POST['onlydate']) && !empty($_POST['onlydate'])){
    $dateInTheDay=[
        // Turnos por la mañana
        $_POST['onlydate'].' 8:00',
        $_POST['onlydate'].' 8:30',
        $_POST['onlydate'].' 9:00',
        $_POST['onlydate'].' 9:30',
        $_POST['onlydate'].' 10:00',
        $_POST['onlydate'].' 10:30',
        $_POST['onlydate'].' 11:00',
        $_POST['onlydate'].' 11:30',

        //Turnos por la tarde
        $_POST['onlydate'].' 14:00',
        $_POST['onlydate'].' 14:30',
        $_POST['onlydate'].' 15:00',
        $_POST['onlydate'].' 15:30',
        $_POST['onlydate'].' 16:00',
        $_POST['onlydate'].' 16:30',
        $_POST['onlydate'].' 17:00',
        $_POST['onlydate'].' 17:30',
    ];
    echo '<p>Las fechas para turnos que se han gurdado en la base de datos son las siguientes';
    foreach ($dateInTheDay as $date) {
        //Consulta
            $query='insert into fechasdisponibles (id_fecha,isdisponible) values (\''.skap($date).'\',1);';
            var_dump($query);
            mysqli_query($cnx,$query);
            echo '<br>'.$date.'<br></p>'; 
        
    }
} 
?>
<!-- <script defer>alert("Cada Año se deben ingresar, las fechas de los turnos");
</script> -->
