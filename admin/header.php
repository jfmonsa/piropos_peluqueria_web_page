
  <body>
    <input class="btn-chk" id="btn-menu-chk" type="checkbox">
    <header> <a href="<?php echo $_SERVER['PHP_SELF'] ?>"> 
        <div class="logo" title="Ir a Inicio">
          <div class="logo__wp"><img class="logo__img top" src="../img/logo-sahpe-top.svg" alt="Parte superior del logo de Peluqueria Piropos"><img class="logo__img bottom" src="../img/logo-shape-bottom.svg" alt="Parte superior del logo de Peluqueria Piropos"></div>
          <h1 class="logo__title"><span class="one">Peluquería</span><br><span class="two">Piropos</span></h1>
        </div></a></header>
    <nav class="menu">
      <?php
         if(!isset($_SESSION['user']) && !isset($_SESSION['pasword'])){
           //When the user isnt loged ?>
            <h2><a class="menu__item" href="/index.php#services">Servicios</a></h2>
            <div class="menu__hr"> </div>
            <h2><a class="menu__item" href="/index.php#why">¿Por que nosotros?</a></h2>
            <div class="menu__hr">  </div>
            <h2><a class="menu__item" href="/index.php#schedule">Horarios</a></h2>
            <div class="menu__hr"></div>
            <h2><a class="menu__item" href="/index.php#form">Agenda tu cita</a></h2>
            <div class="menu__hr"></div>
            <h2><a class="menu__item blog" href="/index.php?page=blog">Blog</a></h2>
            <p class="blog__description">Ingresa a nuestro blog para ver consejos de belleza y cuidado personal, para damas y caballeros</p>
            <div class="menu__hr"></div>
            <h2><a class="menu__item opinion" href="/index.php?page=community">Comentarios</a></h2>
            <div class="menu__hr"></div>
         <?php }else{
           //When the user are loged ?>
           <h2><a class="menu__item" href="index.php?page=citas">citas agendadas</a></h2>
            <div class="menu__hr"> </div>
            <h2><a class="menu__item" href="index.php?page=fechas">Cargar fechas disponibles</a></h2>
            <div class="menu__hr"> </div>
            <h2><a class="menu__item" href="index.php?page=blog">editar articulos del blog</a></h2>
            <div class="menu__hr"> </div>
            <h2><a class="menu__item" href="index.php?page=cancelSchedule">Inhabilitar horarios de los turnos</a></h2>
            <div class="menu__hr"> </div>
            <h2><a class="menu__item" href="index.php?page=exit">Cerrar sesion</a></h2>
            <div class="menu__hr"> </div>
         <?php }
      ?>
    </nav>
    <label class="btn-menu icon" for="btn-menu-chk" tabindex="0" title="Menu">A</label>