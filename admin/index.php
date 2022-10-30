<?php 
require_once('../config.php'); //The basic config
require_once('metatags.php'); 
require_once('../components.php'); //the functions that generates components
session_start();
//================== Metatags =================================================
if(!$cnx){
  //When the connection to the data base falls
  $metatags=[
    '<link rel="stylesheet" href="../css/pages/404.css">'
  ];
  metatags("Peluquería Piropos - Estamos teniendo problemas",$metatags);
}else{
  //When the connection to the Data Base is OK
  if(!isset($_GET['page']) || empty($_GET['page'])){
      $metatags = [
      '<link rel="stylesheet" href="../css/pages/homePage.css">'
    ];
    metatags("Peluquería Piropos - Inicio",$metatags);
  }
  else{
        //Cuando hay conexion con la database
          switch ($_GET['page']) {  
            //ADMIN PAGES  
              case 'citas':
                $metatags=[];
                metatags("Panel de administracion | Citas agendadas");
                break;
              case 'blog':
                $metatags=[
                  '<link rel="stylesheet" href="../css/pages/adminBlog.css">'
                ];
                metatags("Panel de administracion | blogs",$metatags);
                break;
              case 'fechas':
                $metatags=[];
                metatags("Panel de administracion | Fechas",$metatags);
                break;
              
              //Logout
              case 'exit':
                $metatags = [
                  '<link rel="stylesheet" href="../css/pages/404.css">',
                ];
                metatags("La sesion ha sido cerrada correctamente",$metatags);
                  break;
  
              // ERROS
                case 404:
                default:
                $metatags = [
                  '<link rel="stylesheet" href="../css/pages/404.css">',
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
  include_once('../NoBD.php');
}else{
  if(!isset($_SESSION['user']) && !isset($_SESSION['pasword'])){
    //The user isnt loged
    require_once('login.php');
  }else{
    //The user is loged
    if(!isset($_GET['page']) || empty($_GET['page'])){
      require_once('citas.php');
    }else{
      switch ($_GET['page']) {
        //citas,blog,fechas,exit
        //PAGES FOR THE USER
          case 'citas':
            require_once('citas.php');
            break;
          case 'blog':
            require_once('admin-blog.php');
            break;
          case 'fechas':
            include_once('admin-fechas.php');
            break;
          case 'cancelSchedule':
            include('inhabilitarTurnos.php');
            break;


        //LOGOUT
        case 'exit':
          require_once('exit.php');
            break;

        //ERROR PAGES
        case 404:
        default:
          include('../404.php');
          break;
      }
    }
  }
  
}
    ?></main><?php
//================== CONTENT =================================================
//================== FOOTER =================================================
require_once('footer.php'); 
  //When the connection to the database is right
?>