<?php
//---- VERIFICACION INICIAL -------------------------------------------------------
if(isset($_GET['blog'])){
  $query='SELECT id FROM blogs WHERE estado=1 AND id='.skap($_GET['blog']).' LIMIT 1;';
  $result=mysqli_query($cnx,$query);
  if($row=mysqli_fetch_assoc($result)){
    $blogEntryFound=true;$id=$row['id'];
    mysqli_free_result($result);
  }
}
//---- VERIFICACION INICIAL -------------------------------------------------------


















//======== LISTANDO TODAS LAS ENTRADAS CUANDO NO SE HA SELECCIONADO UN ARTICULO ESPECIFICO ========
if((!isset($_GET['blog']) || empty($_GET['blog'])) && !isset($blogEntryFound)){
    //Mostrando la barra de busqueda
    ?>
    <section>
      <article class="searchContainer">
        <form  action="<?php echo $_SERVER['PHP_SELF'] ?>"   class="d__flatBtnContainer">
              <input type="hidden" name="page" value="blog">
                <?php
                  if(isset($_POST['q'])) $value='value="'.$_POST['q'].'"'; else $value=null;
                  generalInput('Buscar un articulo','q','type="search" name="q" '.$value,'Busca por una palabra clave');
                ?>
              <div class="d__flatBtnContainer">
                <?php
                  btn('button','callToAction','Buscar',' name="searched"',' Buscar ');
                  btn('button','error','cancelar',' name="cancel"',' cancelar ');
                ?>
              </div>
            </form>
      </article>
      </article>
    </section>
    <?php
    //Mostrando la barra de busqueda
  //---- PAGINADOR -------------------------------------------------------
        //------------------------- Trayendo el total de coincidencias ---------------
            $query='SELECT COUNT(id) AS total FROM blogs ';
            if(isset($_GET['searched'],$_GET['q']) && !empty($_GET['q']) ){
              //Cuando se realiza una busqueda
              $where='WHERE MATCH(titulo,texto) AGAINST("'.$_GET['q'].'")  AND estado=1';
              $query.=$where;
              $wasASearch=true;
            }else{
              //Cuando no se ha realizado una busqueda
              $where='WHERE estado=1';
              $query.=$where;
            }
            $result=mysqli_query($cnx,$query);
            $row=mysqli_fetch_assoc($result);
            $totalOfCoincidences=(int)$row['total']; //Cantidad total de registros
            mysqli_free_result($result);
        //------------------------- Trayendo el total de coincidencias ---------------
      //Revisando que el punto de referencia del paginador no comienze a contar desde 1
        if(!isset($_GET['blog']) || $_GET['blog']<1) $actualPage=1; 
        else $actualPage=(int)$_GET['blog'];
        $numberOfComments=8;
        $maxPage=(int)ceil($totalOfCoincidences/$numberOfComments);
        //----Query to Know the total number of comments
          $startQuery=($actualPage-1)*$numberOfComments;
          if($maxPage < $actualPage) $actualPage=$maxPage;
      //---- PAGINADOR -------------------------------------------------------
        if(isset($wasASearch) && $wasASearch && $totalOfCoincidences==0){ ?>
          <h2 class="m__Art__h2">No se han econtrado resultados sobre tu busqueda :"<?php echo $_GET['q'] ?>". Te puede interesar</h2>
        <?php }




      //Trayendo las diferentes coincidencias en tarjetas para cada entrada del blog
          //doing the query
          $query=
            'SELECT id,titulo,fecha_publicacion,ruta_imagen,SUBSTRING_INDEX(texto," ",50) AS descripcion
            FROM blogs
            '.$where.'
            LIMIT '.$startQuery.','.$numberOfComments.';';
            $result=mysqli_query($cnx,$query);



          //HTML structure
      ?>
        <section class="m__grid">
        <?php
          while($row=mysqli_fetch_assoc($result)){ ?>
          <article class="cardContainer inactive">
                <a href="<?php echo $_SERVER['PHP_SELF'].'?page=blog&blog='.$row['id'] ?>" class="card">
                  <div class="side front">
                    <div class="img img1" style="background-image: url('<?php echo $row['ruta_imagen'] ?>');"></div>
                    <div class="card__infoContainer">
                      <h2 class="card__title"><?php echo $row['titulo'] ?></h2>
                      <h3 class="card__date"><?php echo date('d M Y - h:i A',strtotime($row['fecha_publicacion'])) ?></h3>
                      <p class="card__description"><?php echo $row['descripcion'].'...' ?></p>
                    </div>
                  </div>
                </a>
              </article>
          <?php }
          mysqli_free_result($result);

        

      //------------------------ Botonera del paginador ----------------------
       ?> 
 <div class="flex-3-col">    <div class="flex-3-col__col"><?php
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
 <?php
}
//======== LISTANDO TODAS LAS ENTRADAS CUANDO NO SE HA SELECCIONADO UN ARTICULO ESPECIFICO ========
















//======== CUANDO SE A SELECCINADO UN ARTICULO EN ESPECIFICO ESTE SE DESPLEGARA PARA SU LECTURA ========
elseif(isset($blogEntryFound)){
  $query='SELECT titulo,autor,fecha_publicacion,ruta_imagen,texto FROM blogs WHERE id='.$id.' AND estado=1;';
  $result=mysqli_query($cnx,$query);
  $row=mysqli_fetch_assoc($result);
  ?>
  <h2 class="m__Art__h2"><?php echo $row['titulo'] ?></h2>
  <picture>
    <img class="articule__image" src="<?php echo $row['ruta_imagen'] ?>" alt="imagen alusiva de el articulo <?php echo $row['titulo'] ?>">
    <figcaption class="blog__date">
      <h3 class="blog__date"> 
        <span>Escrito por: <?php echo $row['autor'] ?></span>
        <span> | </span>
        <span>Escrito en: <?php echo date('d M Y - h:i A',strtotime($row['fecha_publicacion'])) ?></span>
      </h3>
    </figcaption>
  </picture>
  <p class="blog__bodyContent">
    <?php echo $row['texto'] ?>
  </p>
  <?php
}
//======== CUANDO SE A SELECCINADO UN ARTICULO EN ESPECIFICO ESTE SE DESPLEGARA PARA SU LECTURA ========
?>
