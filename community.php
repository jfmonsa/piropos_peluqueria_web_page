<?php 
//6 comentarios en una pagina
    $numberOfComments=6;
    if(empty($_GET['index']) || !isset($_GET['index']) || $_GET['index']<1){$actualPage=1;}
    else{$actualPage=(int)$_GET['index'];}
    //----Query to Know the total number of comments
        $query='SELECT COUNT(id_citaAgendada) AS total FROM comentarios WHERE estado=1;';
        $result=mysqli_query($cnx,$query);
        $row=mysqli_fetch_assoc($result);
        $maxPage=(int)ceil($row['total']/$numberOfComments);
    //----Query to Know the total number of comments
    if($maxPage < $actualPage) $actualPage=$maxPage;
    $startQuery=($actualPage-1)*$numberOfComments;
    mysqli_free_result($result);
//------------ Comments structures ----------------------------
    $query='SELECT nombre,ruta_imagen,comentario FROM comentarios WHERE estado=1 limit '.skap($startQuery).','.skap($numberOfComments).';';
    $result=mysqli_query($cnx,$query);
    //Block of comments ?>
        <div class="flex-3-col comment-container">
           <?php $i=0; while($rows=mysqli_fetch_assoc($result)){ $i++ 
            //individual comment
            ?>
                <div class="flex-3-col__col <?php if($i%2!=0) echo  'col-main' ?> comment-item">
                    <h3 class="m__Art__h3"><?php echo $rows['nombre'];?></h3>
                    <img 
                        class="flex-3-col__img" 
                        src="<?php echo $rows['ruta_imagen'];?>" 
                        alt="Imagen de usuario de <?php echo $rows['nombre'];?>" 
                        loading="lazy"
                    >
                    <p><?php echo $rows['comentario'];?></p>
                </div>
            <?php } ?>
    </div><?php 
  mysqli_free_result($result);
  //--------------------------- botonera ----------------------
?>
<form class="flex-3-col" action="<?php echo $_SERVER['PHP_SELF'].'?page=community#1' ?>" method="post" id="form">    <div class="flex-3-col__col"><?php
        if($actualPage>1){
            $previousPage=$actualPage-1;
            btn('a','normal',"ant ({$previousPage})",' href="'.$_SERVER['PHP_SELF'].'?page=community&index='.$previousPage.'" rel="prev" ','anterior');
        }
    ?></div>
    <div class="flex-3-col__col col-main"><?php
        btn('button','callToAction',"comentar",' type="submit" name="submited" ','comenta');
    ?></div>
    <div class="flex-3-col__col"><?php
        if($actualPage<$maxPage){
            $nextPage=$actualPage+1;
            btn('a','normal',"sig ({$actualPage})",'  href="'.$_SERVER['PHP_SELF'].'?page=community&index='.$nextPage.'" rel="next" ','siguiente');
        }
    ?></div>
  </form>
<?php
// ================================== ESTRUCTURA INICIAL DE LA PAGINA ===========================================










// ================================== DESPLEGANDO EL CUADRO DE DIALOGO ===========================================
if(isset($_POST['submited'])){
    $components=
        function(){
        //-------------
            //Verificacion para no vaciar el campo
            if(isset($_POST['id'])){
                $value='value="'.$_POST['id'].'" ';
            }else $value="null";
            //Verificacion para no vaciar el campo
            generalInput(
                'id  de tu cita',
                'id',
                ' type="text" name="id" '.$value.' inputmode="numeric" autofocus placeholder="El codigo id de tu cita" ');
        //-------------
        //-------------
            //Verificacion para no vaciar el campo
            if(isset($_POST['name'])){
                $value='value="'.$_POST['name'].'" ';
            }else $value="null";
            //Verificacion para no vaciar el campo
            generalInput(
                'Nombre',
                'name',
                ' type="text" name="name" '.$value.'  autocapitalize="words" placeholder="Nombre" ');
        //-------------
            //Verificacion para no vaciar el campo
            if(isset($_POST['comment'])){ 
                $value=$_POST['comment'];
            }else $value=null;
            //Verificacion para no vaciar el campo
            textarea(
                'Deja tu comentario',
                'comment',
                ' cols="32" rows="8" name="comment" autocapitalize="sentences"',
                $value,
            'Ingresa tu comentario'
            );
            inputFile(
                'Sube tu foto',
                'profileImage',
                ' accept="image/*" name="profileImage" capture="user"',
                "callToAction",
                ' Divin@ ');
        //-------------
        ?>
        <div class="d__flatBtnContainer">
        <?php
            btn('button','error','Cancelar','type="submit" name="cancel"',' Cancelar ');
            btn('button','ok','Comentar','type="submit" name="commented"','¡Comenta ya!');
        };
        ?>
        </div>
        <?php
  dialog (
      "Deja tu comentario",
      null,
      $components,
      ' method="post" enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'?page=community#2" id="1"',);
}
// ================================== DESPLEGANDO EL CUADRO DE DIALOGO ===========================================






// ========================================= PROCESING THE DATA =================================================
require_once('validateArray.php');
while(isset($_POST['commented'])){
    //------------ Verify the id ---------------
    if(empty($_POST['id'])){$errorName="noId";break;}
    else{
        $query='SELECT id from citasAgendadas WHERE id="'.$_POST['id'].'" AND isCommented=0';
        $result=mysqli_query($cnx,$query);
        $row=mysqli_fetch_assoc($result);
        if(empty($row['id']) || !$row['id']==trim($_POST['id'])){$errorName='invalidId';break;}
        mysqli_free_result($result);
    }
    // ------------ Verify the that the name is recived ---------------
        //Whe no name is set
            if(empty($_POST['name'])){$errorName = "nameError";break;}
        //To long name
            elseif(strlen($_POST['name']) > 30){$errorName = "longNameError";break;}
        //when name is right
            else $name = trim($_POST['name']);
    // ------------ Verify the that the name is recived ---------------
    // ------------ Verify the that the Comment is recived ---------------
        if(empty($_POST['comment'])){$errorName = "noComment";break;}
            elseif(strlen($_POST['comment']) > 200){$errorName = "longComment";break;}
            else{
                $comment='"'.skap(trim($_POST['comment'])).'"';
            }
  // ------------ Verify the that the Comment is recived ---------------
  //--- Verify the image ------
        if(isset($_FILES['profileImage'])){
            $ext = pathinfo($_FILES['profileImage']["name"],PATHINFO_EXTENSION);
            switch ($ext) {
                case "svg": 
                case "png":
                case "jpg":
                case "jpeg":
                case "webp":
                case "gif":
                        break 2;
                default:
                //Whe isnt a image
                    $errorName="noImageFormat";
                    break 2;
            }
        }else {$errorName="noImage";break;} //When the imagen not exits
//--- Verify the image ------
}
// ========= SAVE THE DATA =================================================
// ========= SHOW THE DIALOG =================================================
if(isset($_POST['commented'])){
    dataToBeOutput();
    $action=' action="'.$_SERVER['PHP_SELF'].'?page=community" method="post" id="2"';
      if(!isset($errorName)){ 
        //calling the array
        $components=
        function(){
                    btn('button','ok','Aceptar',' autofocus type="submit" ','Aceptar');
                  };
        dialog(
        //Form completely right the launches the succes dialog box
        $okForm["comment"]["title"],
        $okForm["comment"]["msj"],
        $components,
        $action  
      );
      //Saving the photo
      $tmpPath=$_FILES['profileImage']["tmp_name"];
      $finalPath="uploads/comments/".$_POST['id'].".".$ext;
      move_uploaded_file($tmpPath,$finalPath);
      //---------- query -------
        //Data for query
            $_POST['id']; //id
            $_POST['name']; //name
            $finalPath;
            $comment; //comment
        //The query
            $query=
            'INSERT INTO comentarios (id_citaAgendada,nombre,ruta_imagen,comentario,estado) VALUES("'.skap($_POST['id']).'","'.skap($_POST['name']).'","'.$finalPath.'",\''.$comment.'\',1);';
            mysqli_query($cnx,$query);
            $query='UPDATE citasAgendadas SET isCommented=1 where id="'.$_POST['id'].'";';
            mysqli_query($cnx,$query);
      }else{
        // An error exits
        $components=
          function(){
                    echo "
                    <input type=\"hidden\" name=\"submited\"> 
                    <input type=\"hidden\" name=\"id\" value=\"".$_POST['id']."\">
                    <input type=\"hidden\" name=\"name\" value=\"".$_POST['name']."\">
                    <input type=\"hidden\" name=\"comment\" value=\"".$_POST['comment']."\">
                    ";              
                      btn('button','error','Reintentar',' autofocus type="submit" ','Reintentar');
                    };
        dialog(
          $errorForm[$errorName]["title"], 
          $errorForm[$errorName]["msj"],
          $components,
          $action
        );
      }
  }
// ========================================= PROCESING THE DATA =================================================
