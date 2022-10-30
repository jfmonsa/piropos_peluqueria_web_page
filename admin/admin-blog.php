<?php
//---- VERIFICACION INICIAL -------------------------------------------------------
if(isset($_GET['documentEdit']) && !empty($_GET['documentEdit'])){
  $query='SELECT id FROM blogs WHERE id='.skap( $_GET['documentEdit']).' LIMIT 1;';
  $result=mysqli_query($cnx,$query);
  if($row=mysqli_fetch_assoc($result)){
    $blogEntryFound=true;$id=$row['id'];
    mysqli_free_result($result);
  }
}
//---- VERIFICACION INICIAL -------------------------------------------------------







//---DESPLEGANDO PANEL CON TODOS LOS BLOGS SI NO ES ENCONTRADO EL ARTICULO POR SU ID EN LA DB------
if((!isset($_GET['documentEdit']) || empty($_GET['documentEdit'])) && !isset($blogEntryFound)  && !isset($_GET['new'])){
      //---- PAGINADOR -------------------------------------------------------
        //------------------------- Trayendo el total de coincidencias ---------------
            $query='SELECT COUNT(id) AS total FROM blogs ;';
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
    btn('a','normal','Fecha ASC',' href="'.$_SERVER['PHP_SELF'].'?page=blog&order=0"',' Fecha ASC '); //0 = fecha ASC
    btn('a','normal','Fecha DESC',' href="'.$_SERVER['PHP_SELF'].'?page=blog&order=1"',' Fecha DESC '); //1 = fecha DESC
    btn('a','normal','titulo ABC...',' href="'.$_SERVER['PHP_SELF'].'?page=blog&order=2"',' titulo ABC... '); //2 = titulo abc
    btn('a','normal','autor ABC...',' href="'.$_SERVER['PHP_SELF'].'?page=blog&order=3"',' autor ABC... '); //3 = autor abc
    ?></div>
</article>
<?php
  if(!isset($_GET['order']) || $_GET['order']=='0') $order=' ORDER BY fecha_publicacion ASC ';
  elseif($_GET['order']=='1') $order=' ORDER BY fecha_publicacion DESC ';
  elseif($_GET['order']=='2') $order=' ORDER BY titulo ';
  elseif($_GET['order']=='3') $order=' ORDER BY autor ';
  $query='SELECT id,titulo,DATE_FORMAT(fecha_publicacion,"%d/%m/%Y -- %h:%i %p") AS fecha_publicacion FROM blogs '.skap($order).' limit '.skap($startQuery).','.skap($numberOfComments).';';
//------------ HTML STRUCTURE ----------------------------
  ?>
  <article class="table__container">
    <table>
      <thead>
        <tr>
          <th>Nombre del archivo</th>
          <th>Fecha de modificacion del archivo</th>
          <th>Acciones</th> 
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Crear un nuevo Articulo</td>
          <td><?php echo date('d/m/Y - h:i a') ?></td>
          <td>
          <?php 
          btn('a','ok','Crear'," href=\"".$_SERVER['PHP_SELF']."?page=blog&new#new\" ",'Crear');
          ?>
          </td>
        </tr>
        <?php
        $result=mysqli_query($cnx,$query);
        while ($row=mysqli_fetch_assoc($result)) { ?>
          <tr>
          <td><?php echo $row['titulo'] ?></td>
          <td><?php echo $row['fecha_publicacion'] ?></td>
          <td class="table__td--btnContainer">
            <form action="<?php echo $_SERVER['PHP_SELF']."?page=blog" ?>" 
            method="post">
            <input type="hidden" name="articleToDelete" value="<?php echo $row['id'] ?>" >
            <?php 
            btn(
              'a',
              'callToAction',
              'Editar',
              " href=\"".$_SERVER['PHP_SELF']."?page=blog&documentEdit=".$row['id']."\"",
              "Editar"); 
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
            btn('a','normal',"ant ({$previousPage})",' href="'.$_SERVER['PHP_SELF'].'?page=blog&index='.$previousPage.'" rel="prev" ','anterior');
        }
    ?></div>
    <div class="flex-3-col__col"><?php
        if($actualPage<$maxPage){
            $nextPage=$actualPage+1;
            btn('a','normal',"sig ({$actualPage})",'  href="'.$_SERVER['PHP_SELF'].'?page=blog&index='.$nextPage.'" rel="next" ','siguiente');
        }
    ?></div>
  </div>
<?php  
//-------------- ELIMINANDO UN ARTICULO EXISTENTE -------------------------------------
  //-------------- PIDIENDO CONFIRMACION AL USUARIO MEDIANTE  UN POP-UP -------------------------------------
  if(isset($_POST['deleted'])){
  $query='SELECT id,titulo FROM blogs WHERE id='.skap($_POST['articleToDelete']).';';
  $result=mysqli_query($cnx,$query);
  $row=mysqli_fetch_assoc($result);
  $components=function(){
    global $row;
   echo '<input type="hidden" name="articleToDelete" value="'.$row['id'].'" >';
    ?><div class="d__flatBtnContainer"><?php
      btn('button','error','Cancelar','type="submit" name="cancel"',' Cancelar ');
      btn('button','ok','Eliminar','type="submit" name="confirm" ',' Eliminar ');
    ?></div><?php
  };
  mysqli_free_result($result);
  $action=' action="'.$_SERVER['PHP_SELF']. '?page=blog" method="post"';
  dialog(
    "¿Estas seguro?",
    "¿Estas seguro que quieres eliminar el articulo ".$row['titulo']."?",
    $components,
    $action
  );
  }
  //---------------------- CUANDO SE CONFIRMA QUE SE VA A ELIMINAR EL ARTICULO--------------------
    if(isset($_POST['confirm'],$_POST['articleToDelete'])){
      $query='SELECT ruta_imagen FROM blogs WHERE id='.skap($_POST['articleToDelete']).';';
      $result=mysqli_query($cnx,$query);
      $row=mysqli_fetch_assoc($result);
      unlink($row['ruta_imagen']);
      mysqli_free_result($result);
      $query='DELETE FROM blogs WHERE id='.skap($_POST['articleToDelete']).';';
      mysqli_query($cnx,$query);

      $components=function(){
        btn('button','ok','Aceptar','type="submit" name="confirm" ',' Aceptar ');
      };

      dialog(
        "Proceso Existoso",
      "El articulo ha sido eliminado correctamente",
      $components,
      ' action="'.$_SERVER['PHP_SELF'].'?page=blog" method="post"'
      );
    }
//-------------- ELIMINANDO UN ARTICULO EXISTENTE -------------------------------------

 }
  
//---DESPLEGANDO PANEL CON TODOS LOS BLOGS SI NO ES ENCONTRADO EL ARTICULO POR SU ID EN LA DB------























//-------------- PAGINA PARA CREAR UN ARTICULO NUEVO -------------------------------------
elseif( isset($_GET['new']) && (!isset($blogEntryFound) || (!isset($_GET['documentEdit']) && empty($_GET['documentEdit']))) && !isset($_POST['deleted'])){ ?>
  <h2 class="m__Art__h2">Redacta un nuevo articulo</h2> 
  <p>En el siguiente campo deberas escribir el contenido que quieres que tenga este articulo
      lo ideal es que sea un texto mayor a 300 palabras pero no muy largo, recuerdad que debe ser interesante para tu audiencia,
          lo ideal es tratar tips de cuidado personal, nuevos cortes o cualquier otro tema que te pueda atraer mas clientes
          o te pueda fidelizar aun mas los que tienes
      </p>
<form 
action="<?php echo $_SERVER['PHP_SELF'].'?page=blog&new#dialog' ?>" 
method="post"
enctype="multipart/form-data"
>
<div>
  <input type="radio" id="0" name="estado" value="0" 
    <?php if(isset($_POST['estado']) && $_POST['estado']=='0') echo 'checked';
    elseif(!isset($_POST['estado'])) echo 'checked';
    ?>
  >
  <label for="0">Borrador</label>
</div>
<div>
  <input type="radio" id="1" name="estado" value="1"
  <?php if(isset($_POST['estado']) && $_POST['estado']=='1') echo 'checked' ?>
  >
  <label for="1">Publicado</label>
</div>
<?php
  if(isset($_POST['articleName'])) $value='value="'.$_POST['articleName'].'"';else $value=null;
  generalInput('Nombre del articulo','title',' type="text" name="articleName" '.$value);
  if(isset($_POST['autor'])) $value='value="'.$_POST['autor'].'" '.$value;else $value=null;
  generalInput('Autor/a','autor',' type="text" name="autor"'.$value);
  inputFile(
    'Foto del articulo',
    'articleImage',
    ' accept="image/*" name="articleImage"',
    "callToAction",
    '¡Subir!');
    //Evitando que se limpien los campos
    if( isset($_POST['body'])){
      $descriptionContent=$_POST['body'];
    }else $descriptionContent =null; 
  textarea(
    'Cuerpo del blog',
    'body',
    '     cols="200" 
          rows="25" 
          name="body" 
          autocapitalize="sentences"
      ',
      $descriptionContent 
  );
  ?><div class="d__flatBtnContainer"><?php
  btn('a','error','Cancelar',' href="'.$_SERVER['PHP_SELF'].'?page=blog"',' Cancelar ');
  btn('button','ok','Crear','type="submit" name="newArticle"','Crear articulo');
  ?></div>
</form> <?php






// ------------ Verificaciones cuando es creado el articulo ----------------------------------
    while(isset($_POST['newArticle'])){
      //--- The name of the article
      if(!isset($_POST['articleName']) || empty($_POST['articleName'])){$errorName="noArticleName";break;}
      elseif(strlen($_POST['articleName'])>90){$errorName="tooLongArticleName";break;}
      else{
        $query='SELECT titulo FROM blogs WHERE titulo="'.skap($_POST['articleName']).'";';
        $result=mysqli_query($cnx,$query);
        if(!$result)$errorName='articleNameAlreadyExist'; else mysqli_free_result($result);
      }
      //---- The autor
      if(!isset($_POST['autor']) || empty($_POST['autor'])){$errorName="noAutor";break;}
      elseif(strlen($_POST['autor'])>90){$errorName="tooLongAutor";break;}
      //---- Verificando el estado de la publicacion
      if(!isset($_POST['estado']) || ((empty($_POST['estado']) && !$_POST['estado']=='0')) || 
      (!$_POST['estado']=='1' && !$_POST['estado']=='0')){
        $errorName="noStatusPublication";break;}
      //-----Verificando la imagen
      if(isset($_FILES['articleImage'])){
        $ext = pathinfo($_FILES['articleImage']["name"],PATHINFO_EXTENSION);
        if(!empty($ext)){
          switch ($ext) {
            case "svg": 
            case "png":
            case "jpg":
            case "jpeg":
            case "webp":
            case "gif":
                    $theImageIsChange=true;
                    break 1;
            default:
            //Whe isnt a image
                $errorName="noImageFormat";
                break 1;
        }
      }
    }elseif(isset($_GET['new'])) {$errorName="noImage";break;} //When the imagen not exits
    //Verificando el comentario
    if(!isset($_POST['body']) || empty($_POST['body'])){$errorName="noBody";break;}
    break;
  }







  if((isset($_POST['newArticle']))){
      //---------------------------------- Desplegando Array con los datos --------------------------
    require_once('../validateArray.php');
    $name=$_POST['autor'];
    dataToBeOutput();
    $values="
    <input type=\"hidden\" name=\"estado\" value=\"".$_POST['estado']."\">
    <input type=\"hidden\" name=\"articleName\" value=\"".$_POST['articleName']."\">
    <input type=\"hidden\" name=\"autor\" value=\"".$_POST['autor']."\">
    <input type=\"hidden\" name=\"body\" value=\"".$_POST['body']."\">
    ";
  //---------------------------------- Desplegando Array con los datos --------------------------
  if(!isset($errorName)){
    //Se ejecuta si no hay ningun error
    $tmpPath=$_FILES['articleImage']["tmp_name"];
    $imageFileName=preg_replace('/([^A-Za-z0-9 ]|\s)/','_',$_POST['articleName']).'_'.date('Y-m-d_h_m_s');
    $finalPath="../blogs/images/".$imageFileName.".".$ext;
    move_uploaded_file($tmpPath,$finalPath);
    //---------- query -------
    $query='INSERT INTO blogs (titulo,autor,fecha_publicacion,ruta_imagen,texto,estado) 
    VALUES("'.skap(htmlspecialchars($_POST['articleName'])).'","'.skap(htmlspecialchars($_POST['autor'])).'","'.date('Y-m-d - h:i:s').'","'.$finalPath.'","'.htmlspecialchars(skap($_POST['body'])).'",'.skap($_POST['estado']).');';
    mysqli_query($cnx,$query);
    //Showing the modal box
    $components=
          function(){ 
            global $values;
                      echo $values;
                      btn('button','ok','Aceptar',' autofocus type="submit" ','Aceptar');
                    };
          $action=' action="'.$_SERVER['PHP_SELF'].'?page=blog" method="post" id="dialog"';
          dialog(
          $okForm["ArticleEdited"]["title"],
          $okForm["ArticleEdited"]["msj"],
          $components,
          $action 
        );
  }else{
    $components=
          function(){ 
                      global $values;
                      echo $values;
                      btn('button','error','Reintentar',' autofocus type="submit" ',' Reintentar ');
                    };
          $action=' action="'.$_SERVER['PHP_SELF'].'?page=blog&new" method="post" id="dialog"';
          dialog(
          $errorForm[$errorName]["title"],
          $errorForm[$errorName]["msj"],
          $components,
          $action 
        );
  }
  }
}
//-------------- PAGINA PARA CREAR UN ARTICULO NUEVO -------------------------------------



















//-------------- PAGINA PARA EDITAR UN ARTICULO EXISTENTE -------------------------------------
elseif(isset($blogEntryFound) && isset($_GET['documentEdit']) && !isset($_POST['deleted'])){ 
  $query='SELECT titulo,ruta_imagen,autor,texto,estado FROM blogs WHERE id='.skap($_GET['documentEdit']).';';
  $result=mysqli_query($cnx,$query);
  $row=mysqli_fetch_assoc($result);
  ?>
  <h2 class="m__Art__h2">Editar el articulo: <?php echo $row['titulo'] ?></h2> 
  <p>Puedes continuar con la edicion del archivo</p>
<form 
action="<?php echo $_SERVER['PHP_SELF'].'?page=blog&documentEdit='.$_GET['documentEdit'].'#dialog' ?>" 
method="post"
enctype="multipart/form-data"
>
  <div>
    <input type="radio" id="0" name="estado" value="0"
      <?php if($row['estado']=='0') echo 'checked';?>
    >
    <label for="0">Borrador</label>
  </div>
  <div>
    <input type="radio" id="1" name="estado" value="1"
    <?php if($row['estado']=='1') echo 'checked' ?>
    >
    <label for="1">Publicado</label>
  </div>
  <?php
    $value='value="'.$row['titulo'].'"';
    generalInput('Nombre del articulo','title',' type="text" name="articleName" '.$value);
    $value='value="'.$row['autor'].'" '.$value;
    generalInput('Autor/a','autor',' type="text" name="autor"'.$value);
    ?><img src="<?php echo $row['ruta_imagen'] ?>" alt="imagen principal del articulo del blog <?php ?>"><?php
    inputFile(
      'Cambiar Foto',
      'articleImage',
      ' accept="image/*" name="articleImage"',
      "callToAction",
      'Solo presiona si deseas cambiar la foto');
    textarea(
      'Cuerpo del blog',
      'body',
      '     cols="200" 
            rows="25" 
            name="body" 
            autocapitalize="sentences"
        ',
        strip_tags($row['texto'])
    );
    ?><div class="d__flatBtnContainer"><?php
    btn('a','error','Cancelar',' href="'.$_SERVER['PHP_SELF'].'?page=blog"',' Cancelar ');
    btn('button','ok','Guardar','type="submit" name="edited"','Guardar cambios');
    mysqli_free_result($result);
    ?></div>
</form> <?php




//-------------- REALIZANDO TODAS LAS VERIFICACIONES -------------------------------------
  while(isset($_POST['edited'])){
    //--- The name of the article
    if(!isset($_POST['articleName']) || empty($_POST['articleName'])){$errorName="noArticleName";break;}
    elseif(strlen($_POST['articleName'])>90){$errorName="tooLongArticleName";break;}
    else{
      $query='SELECT count(id) AS n FROM blogs WHERE titulo="'.skap($_POST['articleName']).'";';
      $result=mysqli_query($cnx,$query);
      if($row=mysqli_fetch_assoc($result)){
        $n=(int)$row['n'];
        if($n>=2)$errorName='articleNameAlreadyExist';
      }
      if($result)mysqli_free_result($result);
    }
    //---- The autor
    if(!isset($_POST['autor']) || empty($_POST['autor'])){$errorName="noAutor";break;}
    elseif(strlen($_POST['autor'])>90){$errorName="tooLongAutor";break;}
    //---- Verificando el estado de la publicacion
    if(!isset($_POST['estado']) || ((empty($_POST['estado']) && !$_POST['estado']=='0')) || 
    (!$_POST['estado']=='1' && !$_POST['estado']=='0')){
      $errorName="noStatusPublication";break;}
    //-----Verificando la imagen
    if(isset($_FILES['articleImage'])){
      $ext = pathinfo($_FILES['articleImage']["name"],PATHINFO_EXTENSION);
      if(!empty($ext)){
        switch ($ext) {
          case "svg": 
          case "png":
          case "jpg":
          case "jpeg":
          case "webp":
          case "gif":
                  $theImageIsChange=true;
                  break 1;
          default:
          //Whe isnt a image
              $errorName="noImageFormat";
              break 1;
      }
    }
  }
  //Verificando el comentario
  if(!isset($_POST['body']) || empty($_POST['body'])){$errorName="noBody";break;}
  break;
  }




  //-------------- GUARDANDO LOS CAMBIOS------------------ -------------------------------------
  if((isset($_POST['edited']))){
    //---------------------------------- Desplegando Array con los datos --------------------------
  require_once('../validateArray.php');
  $name=$_POST['autor'];
  dataToBeOutput();
  $values="
  <input type=\"hidden\" name=\"estado\" value=\"".$_POST['estado']."\">
  <input type=\"hidden\" name=\"articleName\" value=\"".$_POST['articleName']."\">
  <input type=\"hidden\" name=\"autor\" value=\"".$_POST['autor']."\">
  <input type=\"hidden\" name=\"body\" value=\"".$_POST['body']."\">
  ";
    //---------------------------------- Desplegando Array con los datos --------------------------
    if(!isset($errorName)){
      if(isset($theImageIsChange) && $theImageIsChange){
        //Se ejecuta si no hay ningun error
        echo "Se cambio imagen";
          //Eliminando imagen antigua
            $query='SELECT ruta_imagen FROM blogs WHERE id='.skap($_GET['documentEdit']).';';
            $result=mysqli_query($cnx,$query);
            $row=mysqli_fetch_assoc($result);
            unlink($row['ruta_imagen']);
          //Guardando nueva imagen
            $tmpPath=$_FILES['articleImage']["tmp_name"];
            $imageFileName=preg_replace('/([^A-Za-z0-9 ]|\s)/','_',$_POST['articleName']).'_'.date('Y-m-d_h_m_s');
            $finalPath="../blogs/images/".$imageFileName.".".$ext;
            move_uploaded_file($tmpPath,$finalPath);
      }else{
        $query='SELECT ruta_imagen FROM blogs WHERE id='.skap($_GET['documentEdit']).';';
        $result=mysqli_query($cnx,$query);
        $row=mysqli_fetch_assoc($result);
        $finalPath=$row['ruta_imagen'];
        mysqli_free_result($result);
      }
    //---------- query -------
    $query='UPDATE blogs SET 
      titulo="'.htmlspecialchars(skap($_POST['articleName'])).'",
      autor="'.skap(htmlspecialchars($_POST['autor'])).'",
      ruta_imagen="'.skap(htmlspecialchars($finalPath)).'",
      texto="'.nl2br(strip_tags(skap($_POST['body']))).'",
      estado='.skap(htmlspecialchars($_POST['estado'])).'
      WHERE id='.skap($_GET['documentEdit']).';';
    mysqli_query($cnx,$query);
    //Showing the modal box
    $components=
          function(){ 
            global $values;
                      echo $values;
                      btn('button','ok','Aceptar',' autofocus type="submit" ','Aceptar');
                    };
          $action=' action="'.$_SERVER['PHP_SELF'].'?page=blog" method="post" id="dialog"';
          dialog(
          $okForm["ArticleEdited"]["title"],
          $okForm["ArticleEdited"]["msj"],
          $components,
          $action 
        );
    }else{
    $components=
          function(){ 
                      global $values;
                      echo $values;
                      btn('button','error','Reintentar',' autofocus type="submit" ',' Reintentar ');
                    };
          $action=' action="'.$_SERVER['PHP_SELF'].'?page=blog&documentEdit='.$_GET['documentEdit'].'" method="post" id="dialog"';
          dialog(
          $errorForm[$errorName]["title"],
          $errorForm[$errorName]["msj"],
          $components,
          $action 
        );
    }
  }
//-------------- GUARDANDO LOS CAMBIOS------------------ -------------------------------------
}
//-------------- PAGINA PARA EDITAR UN ARTICULO EXISTENTE -------------------------------------
