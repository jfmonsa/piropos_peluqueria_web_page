<?php
if(isset($_GET['id']) && !empty($_GET['id'])){
  $query='SELECT id FROM citasAgendadas WHERE id='.skap($_GET['id']).' LIMIT 1;';
  $result=mysqli_query($cnx,$query);
  if($row=mysqli_fetch_assoc($result)){
    $blogEntryFound=true;$id=$row['id'];
    mysqli_free_result($result);
  }
}
//---- VERIFICACION INICIAL -------------------------------------------------------
//---DESPLEGANDO PANEL CON TODOS LOS BLOGS SI NO ES ENCONTRADO EL ARTICULO POR SU ID EN LA DB------
if(!isset($blogEntryFound) && !isset($_GET['new'])){
    //---- PAGINADOR -------------------------------------------------------
      //------------------------- Trayendo el total de coincidencias ---------------
          $query='SELECT COUNT(id) AS total FROM citasAgendadas ;';
            //Cuando no se ha realizado una busqueda
          $result=mysqli_query($cnx,$query);
          $row=mysqli_fetch_assoc($result);
          $totalOfCoincidences=(int)$row['total']; //Cantidad total de registros
          mysqli_free_result($result);
      //------------------------- Trayendo el total de coincidencias ---------------
    //Revisando que el punto de referencia del paginador no comienze a contar desde 1
      if(!isset($_GET['index']) || $_GET['index']<1) $actualPage=1; 
      else $actualPage=(int)$_GET['index'];
      $numberOfComments=10;
      $maxPage=(int)ceil($totalOfCoincidences/$numberOfComments);
      //----Query to Know the total number of comments
    $startQuery=($actualPage-1)*$numberOfComments;
    if($maxPage < $actualPage) $actualPage=$maxPage;
    //---- PAGINADOR -------------------------------------------------------
    ?>
<article class="filterContainer">
<h2>Filtrar los registros por:</h2>
<div class="filterContainer__btnsContainer"><?php
  btn('a','normal','Fecha ASC',' href="'.$_SERVER['PHP_SELF'].'?&order=0"',' Fecha ASC '); //0 = fecha ASC
  btn('a','normal','Fecha DESC',' href="'.$_SERVER['PHP_SELF'].'?&order=1"',' Fecha DESC '); //1 = fecha DESC
  btn('a','normal','nombre ABC...',' href="'.$_SERVER['PHP_SELF'].'?&order=2"',' autor ABC... '); //3 = autor abc
  ?></div>
</article>
<?php
if(!isset($_GET['order']) || $_GET['order']=='0') $order=' ORDER BY fecha_inicio ASC ';
elseif($_GET['order']=='1') $order=' ORDER BY fecha_inicio DESC ';
elseif($_GET['order']=='2') $order=' ORDER BY nombre ';
$query='SELECT id,nombre,tel,CONCAT(DATE_FORMAT(fecha_inicio,"%d/%m/%Y -- %h:%i %p"),DATE_FORMAT(fecha_finalizado," a %h:%i %p"))  AS fecha,services,genero FROM citasAgendadas WHERE fecha_inicio > NOW() '.skap($order).' limit '.skap($startQuery).','.skap($numberOfComments).';';
//------------ HTML STRUCTURE ----------------------------
?>
<article class="table__container">
  <table>
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Servicio(s)</th>
        <th>Fecha</th>
        <th>Genero</th>
        <th>Telefono</th> 
        <th>Acciones</th> 
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Crear un nuevo turno</td>
        <td> --- </td>
        <td> --- </td>
        <td> --- </td>
        <td> --- </td>
        <td>
            <?php 
            btn('a','ok','Crear'," href=\"../index.php#form\" target=\"blank\"",'Crear');
            ?>
        </td>
      </tr>
      <?php
      $result=mysqli_query($cnx,$query);
      while ($row=mysqli_fetch_assoc($result)) { 
          if($row['genero']=='m') $genero='Hombre';
          else $genero="Mujer";
          //Reemplazando por el nombre de los servicios
          $services=preg_replace('/3/','Peinados',
          preg_replace('/2/','Cepillado',
            preg_replace('/0/','Corte Caballero',
              preg_replace('/1/','Corte Dama',$row['services'])
              )   
            )
          );
          ?>
        <tr>
        <td><?php echo $row['nombre'] ?></td>
        <td><?php echo $services ?></td>
        <td><?php echo $row['fecha'] ?></td>
        <td><?php echo $genero ?></td>
        <td><?php echo $row['tel'] ?></td>
        <td class="table__td--btnContainer">
          <form action="<?php echo $_SERVER['PHP_SELF']."?page=citas" ?>" 
          method="post">
          <input type="hidden" name="idToDelete" value="<?php echo $row['id'] ?>" >
          <?php 
          btn(
            'a',
            'ok',
            'WhatsApp',
            " href=\"https://api.whatsapp.com/send?phone=+57".$row['tel']."\" target=\"_blank\"",
            "WhatsApp"); 
          btn(
            'button',
            'error',
            'Eliminar',
          'type="submit" name="deleted"',
            "Eliminar") ;
          ?>
          </form>         
        </td>
      </tr><?php 
      } mysqli_free_result($result);
      ?>
    </tbody>
  </table>
</article>
<div class="flex-3-col" id="form">    <div class="flex-3-col__col"><?php
      if($actualPage>1){
          $previousPage=$actualPage-1;
          btn('a','normal',"ant ({$previousPage})",' href="'.$_SERVER['PHP_SELF'].'?page=admin/admin-blog.php&index='.$previousPage.'" rel="prev" ','anterior');
      }
  ?></div>
  <div class="flex-3-col__col"><?php
      if($actualPage<$maxPage){
          $nextPage=$actualPage+1;
          btn('a','normal',"sig ({$actualPage})",'  href="'.$_SERVER['PHP_SELF'].'?page=admin/admin-blog.php&index='.$nextPage.'" rel="next" ','siguiente');
      }
  ?></div>
</div>
<?php  
//-------------- ELIMINANDO UN ARTICULO EXISTENTE -------------------------------------





//-------------- PIDIENDO CONFIRMACION AL USUARIO MEDIANTE  UN POP-UP -------------------------------------
if(isset($_POST['deleted'])){
$query='SELECT id,nombre FROM citasAgendadas WHERE id="'.skap($_POST['idToDelete']).'";';
$result=mysqli_query($cnx,$query);
$row=mysqli_fetch_assoc($result);
$components=function(){
  global $row;
 echo '<input type="hidden" name="idToDelete" value="'.$row['id'].'" >';
  ?><div class="d__flatBtnContainer"><?php
    btn('button','error','Cancelar','type="submit" name="cancel1"',' Cancelar ');
    btn('button','ok','Eliminar','type="submit" name="confirm1" ',' Eliminar ');
  ?></div><?php
};
mysqli_free_result($result);
$action=' action="'.$_SERVER['PHP_SELF'].'#dialog" method="post"';
dialog(
  "¿Estas segur@?",
  "¿Estas seguro que deseas cancelar la cita de este cliente ".$row['nombre']."?",
  $components,
  $action
);
}
//---------------------- CUANDO SE CONFIRMA QUE SE VA A ELIMINAR EL ARTICULO--------------------
  if(isset($_POST['confirm1']) && isset($_POST['idToDelete'])){
    $query='UPDATE fechasDisponibles SET isDisponible=1 WHERE isDisponible=0 AND id_fecha BETWEEN 
    (SELECT fecha_inicio FROM citasAgendadas WHERE id="'.skap($_POST['idToDelete']).'") AND
    (SELECT fecha_finalizado FROM citasAgendadas WHERE id="'.skap($_POST['idToDelete']).'");';
    mysqli_query($cnx,$query);
    $query='DELETE FROM citasAgendadas WHERE id="'.skap($_POST['idToDelete']).'"';
    mysqli_query($cnx,$query);

    $components=function(){
      btn('button','ok','Aceptar','type="submit" name="confirm" ',' Aceptar ');
    };

    dialog(
      "Proceso Existoso",
    "La cita ha sido eliminada correctamente",
    $components,
    ' action="'.$_SERVER['PHP_SELF'].'?page=citas" method="post" id="dialog"'
    );
  }elseif(isset($_POST['cancel1']) && isset($_POST['idToDelete'])){
    $components=function(){
      btn('button','ok','Aceptar','type="submit" name="confirm" ',' Aceptar ');
    };

    dialog(
      "Cancelacion Existosa",
    "El proceso ha sido cancelado exitosamente la cita no ha sido cancelada",
    $components,
    ' action="'.$_SERVER['PHP_SELF'].'?page=citas" method="post" id="dialog"'
    );
  }
//-------------- ELIMINANDO UN ARTICULO EXISTENTE -------------------------------------

}




