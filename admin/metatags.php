<?php 
/*
metatags($title,$arrayMetatags=[]);
  Funcion que genera las metaetiquetas de cada pagina

  $title = titulo que queremos que tenga cada pagina del sitio
  $arrayMetatags=[]
    Un array que tiene strigs que contienen metaetiquetas personalizadas para cada sitio web
    utilidad
      Se puede usar para añadir hojas de estilo personalizadas para cada sitio

*/
function metatags($title,$arrayMetatags=[]){?>
  <!DOCTYPE html>
  <html lang="es">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?php echo $title ?></title>
      <link rel="stylesheet" href="css/base/normalize.css">
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link 
        href="https://res.cloudinary.com/dr6lvwubh/raw/upload/v1581441981/Anicons/anicons-regular.css" 
        rel="stylesheet"
      >
      <link 
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" 
        rel="stylesheet"
      >
      <script src="https://kit.fontawesome.com/56327736b1.js" crossorigin="anonymous" async defer> </script><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" integrity="sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni" crossorigin="anonymous">
    <?php //Styles ?>
      <?php // basic ----------------?>
        <link rel="stylesheet" href="/css/base/normalize.css">
        <link rel="stylesheet" href="/css/base/variables.css">
        <link rel="stylesheet" href="/css/base/basicDocument.css">
      <?php // layout ----------------?>
        <link rel="stylesheet" href="/css/layout/footer.css">
        <link rel="stylesheet" href="/css/layout/header.css">
        <link rel="stylesheet" href="/css/layout/layoutStructures.css">
      <?php // components ----------------?>
      <link rel="stylesheet" href="/css/components/button.css">
      <link rel="stylesheet" href="/css/components/form.css">
      <link rel="stylesheet" href="/css/components/modal.css">
      <link rel="stylesheet" href="/css/base.css">
    <?php //Icons ?>
      <link rel="apple-touch-icon" sizes="180x180" href="/ico-180.png" />
      <link rel="apple-touch-icon" sizes="153x153" href="/ico-152.png" />
      <link rel="apple-touch-icon" sizes="121x121" href="/ico-120.png" />
      <link rel="apple-touch-icon" sizes="76x76" href="../ico-76.png" />
      <link rel="icon" type="image/x-icon" sizes="180x180" href="/ico-180.ico" />
      <link rel="icon" type="image/x-icon" sizes="153x153" href="/ico-152.ico" />
      <link rel="icon" type="image/x-icon" sizes="121x121" href="/ico-120.ico" />
      <link rel="icon" type="image/x-icon" sizes="76x76" href="/ico-76.ico" />
      <meta name="theme-color" content="#851472" />
    <?php //Custom metatags ?>
      <?php 
      $lenght = count($arrayMetatags);
      for ($i=0; $i < $lenght; $i++) { 
        echo $arrayMetatags[$i]."\n\t";
      }
      ?>
      <link rel="stylesheet" href="../css/pages/admin.css">
      <link rel="stylesheet" href="../css/layout/tables.css">
    </head>
<?php }



