<?php 
require_once('config.php'); //The basic config
require_once('metatags.php'); 
require_once('components.php'); //the functions that generates components
//================== Metatags =================================================
if(!$cnx){
  //When the connection to the data base falls
  $metatags=[
    '<link rel="stylesheet" href="css/pages/404.css">'
  ];
  metatags("Peluquería Piropos - Estamos teniendo problemas",$metatags);
}else{
  //When the connection to the Data Base is OK
  if(!isset($_GET['page']) || empty($_GET['page'])){
      $metatags = [
      '<link rel="stylesheet" href="css/pages/homePage.css">',
      '<link rel="canonical" href="http://piropos.great-site.net">'
    ];
    metatags("Peluquería Piropos - Inicio",$metatags);
  }
  else{
        //Cuando hay conexion con la database
          switch ($_GET['page']) {
            //PAGES FOR THE USER
              case 'community':
                $metatags = [
                  '<link rel="stylesheet" href="css/pages/community.css">',
                ];
                metatags("Peluquería Piropos - Communidad",$metatags);
                break;
              case 'blog':
                $metatags=[
                  '<link rel="stylesheet" href="css/pages/blog.css">'
                ];
                metatags("Peluquería Piropos - blogs",$metatags);
                break;
              case 'pp':
                $metatags=[
                  '<link rel="stylesheet" href="css/pages/pp.css">'
                ];
                metatags("Peluquería Piropos - Politica de tratamiento de datos",$metatags);
                break;
  
              // ERROS
                case 404:
                default:
                $metatags = [
                  '<link rel="stylesheet" href="css/pages/404.css">',
                ];
                metatags("Peluquería Piropos - Enlace roto",$metatags);
                  break;
      }
  }
}
//================== Metatags =================================================
//================== header =================================================
require_once('header.php');
//================== header =================================================
//================== CONTENT =================================================
?><main class="m"><?php
  //To load the content we evaluated the $_GET['page'] variable
if(!$cnx){
  //When the connection to the Data Base falls
  include_once('NoBD.php');
}else{
  //When the connection to the database is right
  if(!isset($_GET['page']) || empty($_GET['page'])){
    require_once('homePage.php');
  }else{
    switch ($_GET['page']) {
      //PAGES FOR THE USER
        case 'community':
          include_once('community.php');
          break;
        case 'blog':
          include_once('blogs.php');
          break;
        case 'pp':
          include('pp.html');
          break;
      
      //ERROR PAGES
      case 404:
      default:
        include('404.php');
        break;
    }
  }

}
    ?></main><?php
//================== CONTENT =================================================
//================== FOOTER =================================================
require_once('footer.php'); 
?>
