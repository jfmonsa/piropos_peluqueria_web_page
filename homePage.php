<article class="m__Art m-services">
  <h2 class="m__Art__h2" id="services">Servicios</h2>
  <div class="flex-3-col">
    <div class="flex-3-col__col">
      <h3 class="m__Art__h3">Damas</h3><img class="flex-3-col__img" src="./img/m__Art--Services-1.jpg" alt="Imagen de referencia de un corte de una dama" loading="lazy">
    </div>
    <div class="flex-3-col__col col-main">
      <h3 class="m__Art__h3">Niños y niñas</h3><img class="flex-3-col__img" src="./img/m__Art--Services-2.jpg" alt="Imagen de referencia de un corte de caballeros" loading="lazy">
    </div>
    <div class="flex-3-col__col">
      <h3 class="m__Art__h3">Caballeros</h3><img class="flex-3-col__img" src="./img/m__Art--Services-3.jpg" alt="Imagen de referencia de un corte de niños y niñas" loading="lazy">
    </div>
  </div>
</article>
<article class="m__Art m-why">
  <h2 class="m__Art__h2" id="why">¿Por que nosotros?</h2>
  <div class="flex-3-col">
    <div class="flex-3-col__col">
      <p><span class="m__Art--why__top">20</span><span class="m__Art--why__bottom">Años de experiencia</span></p>
    </div>
    <div class="flex-3-col__col col-main">
      <p><span class="m__Art--why__top">$</span><span class="m__Art--why__bottom">Contamos con unos precios excelentes, aun así manteniendo la calidad de los cortes</span></p>
    </div>
    <div class="flex-3-col__col">
      <p><span class="m__Art--why__top">A</span><span class="m__Art--why__bottom">Amabilidad como misión de marca</span></p>
    </div>
  </div>
</article>
<article class="m__Art m-people">
  <h2 class="m__Art__h2">Atendemos personas no clientes</h2>
  <div class="g-2col">
    <div class="g-2col--cell"><img src="./img/m__Art--people.jpg" alt="Foto de la peluqueria de Jhoana Piedrahita, fundadora y dueña de la peluqueria piropos" loading="lazy"></div>
    <div class="g-2col--cell">
      <p>Hola, mi nombre es Jhoana, Soy la fundadora de esta maravillosa empresa que he construido con amor y dedicación, hoy 20 años después estoy muy feliz de ver todo lo que he crecido y lo que me falta por crecer, gracias a esta empresa pude criar a mis dos hijos y construir mi casa propia.</p>
      <p>Nuestras acciones como empresa siempre estarán guiados por la amabilidad y la cercanía con nuestros clientes. nuestro mayor objetivo es prestarle el mejor servicio a mis clientes.</p>
      <p>¿Estás listo para conocer el lugar más amable de Tuluá y de el Valle entero? Agenda una cita y no te arrepentirás ¡Nunca!</p>
    </div>
  </div>
</article>
<article class="m__Art m-comunity">
  <h2 class="m__Art__h2">Comunidad</h2>
  <?php
  // -------------- trayendo los comentarios de la DB ---------------------------
    $query='SELECT nombre,ruta_imagen,comentario FROM comentarios WHERE estado=1 ORDER BY RAND() LIMIT 3;';
    $result=mysqli_query($cnx,$query); ?>
      <div class="flex-3-col comment-container">
            <?php $i=1; while($rows=mysqli_fetch_assoc($result)){ $i++ 
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
      </div>
    <?php 
  // -------------- trayendo los comentarios de la DB ---------------------------
  mysqli_free_result($result);
  btn('a','callToAction','Agenda tu cita',' href="#form" ')?>
</article>
<article class="m__Art m-schedule">
  <div class="g-2col">
    <div class="g-2col--cell">
      <h2 class="m__Art__h2" id="schedule">Horario</h2>
      <p class="custom-p-fize m-schedule__p1">Nuestras puertas están abiertas:</p>
      <p class="custom-p-fize m-schedule__p2">Lunes a Sabado</p>
      <p class="custom-p-fize m-schedule__p3"> <span class="m-schedule__p3__sp">9:00 a 12:00 AM </span><span class="m-schedule__p3__sp sp-bottom">2:00 a 6:30 PM</span></p>
      <p class="custom-p-fize m-schedule__p2">Domingos y Festivos</p>
      <p class="custom-p-fize m-schedule__p3"> <span class="m-schedule__p3__sp">9:00 a 2:00 PM </span></p>
    </div>
    <div class="g-2col--cell">
      <h2 class="m__Art__h2">Celular</h2>
      <p class="custom-p-fize m-schedule__p1">Llamanos con confianza, con gusto te atenderemos</p>
      <p class="custom-p-fize m-schedule__p3">+57 3166183543</p>
      <?php 
      btn('a',
      'normal',
      'Contactanos',
      ' href="https://api.whatsapp.com/send?phone=+573166183543" target="_blank" ');
?>
    </div>
  </div>
</article>
<article class="m__Art m-form" id="form">
  <h2 class="m__Art__h2">Agenda tu cita</h2>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'#dialog') ?>" method="post">
    <div class="g-2col">
      <div class="g-2col--cell">
        <h3 class="m-form__p3">Tipo de servicio</h3>
        <div class="g-2col">
          <div class="g-2col--cell m-form__stp">
            <h4 class="m__Art__h3">Damas</h4>
            <?php  checkbox("corteDama","servicesWomen","1","Corte",true) ?>
            <?php //checkbox("cepilladoDama","servicesWomen","2","Cepillado",true) ?>
            <?php //checkbox("peinadoDama","servicesWomen","3","Peinado",true) ?>
          </div>
          <div class="g-2col--cell">
            <h4 class="m__Art__h3">Caballeros</h4>
            <?php checkbox("corteCaballero","servicesMen","0","Corte",true) ?>
          </div>
        </div>
      </div>
      <div class="g-2col--cell">
      <?php
      //Evitando que se limpien los campos
        if(isset($_POST['name'])) $value=$_POST['name'];
        else $value=null;
        generalInput(
        'Nombre',
        'name',
        ' type="text" name="name" autocapitalize="words" value="'.$value.'"',
        'Tu nombre completo'
      );
      //Evitando que se limpien los campos
        if(isset($_POST['tel'])) $value=$_POST['tel'];
        else $value=null;
        generalInput(
          'Telefono celular',
          'tel',
          ' type="tel" name="tel" inputmode="tel" value="'.$value.'"',
          'Ingresa tu numero celular'
        );
      //Avaible days
        {
          //Evitando que se limpien los campos
            if(isset($_POST['day'])) $value=$_POST['day'];
            else $value=null;
          $options=['text'=>[],'value'=>[]];
          if($cnx){
            //query to the db
              $query=
                'SELECT 
                  DATE_FORMAT(id_fecha,"%d/%m/%Y -- %h:%i %p") AS fecha_formateada,
                  id_fecha,
                  DATE_FORMAT(id_fecha,"%w") AS week_day,
                  (select id_fecha from fechasDisponibles where isdisponible=1 /*AND id_fecha > NOW() order by id_fecha asc limit 1*/)
                FROM fechasDisponibles
                WHERE 
                  isDisponible=1 AND 
                  id_fecha between
                  (select id_fecha from fechasDisponibles where isdisponible=1 /*AND id_fecha > NOW() order by id_fecha asc limit 1*/)
                  and DATE_ADD((select id_fecha from fechasDisponibles where isdisponible=1 /*AND id_fecha > NOW() order by id_fecha asc limit 1), INTERVAL 7 DAY*/)
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
              //query to the db
          }
          select('Fecha y hora','day',' name="day"',$options,$value);
        }
        checkbox(
          "privacyPolicy",
          "privacyPolicy",
          "",
          'Acepto la <a class="normalLink" href="'.$_SERVER['PHP_SELF'].'?page=pp" target="_blank">política de tratamiento de datos</a>'
        ) ?>
      </div>
    </div>
    <?php
          btn('button',
          'callToAction',
          'Agendar',
          ' name="submited" type="submit" ',
          '¡Adelante!'
        ); ?>
  </form>
  <?php
  // ================================== Validation conditionals ===========================
  while(isset($_POST['submited'])){
    require_once('validateArray.php');
      // ------------ Verify the that the name is recived ---------------
          //No name
          if(empty($_POST['name'])){$errorName="nameError";break;}
          //To long name
            elseif(strlen($_POST['name']) > 30){$errorName="longNameError";break;}
          //when name is right
            else $name = trim($_POST['name']);
      // ------------ Verify the services are recived ---------------
          if(isset($_POST['servicesWomen']) || isset($_POST['servicesMen'])){
            //when one or more services are checked
            if( isset($_POST['servicesWomen']) && isset($_POST['servicesMen']) ){
              //Whe womens and mens services are checked at the same petition
              $errorName="undefined";break;
            }
            else{
    
            }  //when the services is right
          }
          //Whe none of the services are selected
          else {$errorName="noneServiceError";break;}
      // ------------ Verify the tel ---------------
          //No Tel
          if(empty($_POST['tel'])){$errorName="noTel";break;}
          //Verificar el correcto formato del telefono
            elseif(strlen($_POST['tel']) !== 10 || !is_numeric($_POST['tel'])){$errorName="noTelFormat";break;}
          //when the tel is right
            else;
      // ------------ Verify the Date ---------------
          if(empty($_POST['day'])){$errorName="noDay";break;}
          else{
           $query='SELECT Isdisponible FROM fechasDisponibles WHERE id_fecha="'.skap($_POST['day']).'";';
            $result=mysqli_query($cnx,$query);
            $row=mysqli_fetch_assoc($result);
            if($row['Isdisponible']==0){$errorName='nonAvaibleDate';break;}
            mysqli_free_result($result);
          }//when the day is right
      // ------------ Verify the acceptation of the privacy Policy ---------------
        if(!isset($_POST['privacyPolicy'])){$errorName="noPP";break;}
        else; //privacy right
        break;
    }
  // ================================== Validation conditionals ===========================
  

  
  // ================================== DIALOG BOXES ===========================
    if(isset($_POST['submited'])){
      dataToBeOutput();
      $action=' action="'.$_SERVER['PHP_SELF'].'?form#form" method="post" id="dialog"';
    //Para evitar de que se limpie el inut automaticamente
      $values="
        <input type=\"hidden\" name=\"name\" value=\"".$_POST['name']."\">
        <input type=\"hidden\" name=\"tel\" value=\"".$_POST['tel']."\">
        <input type=\"hidden\" name=\"day\" value=\"".$_POST['day']."\">
      ";
      //Services
      if(isset($_POST['servicesWomen'])){
        foreach ($_POST['servicesWomen'] as $value) {
          $values.="<input type=\"hidden\" name=\"servicesWomen[]\" value=\"".$value."\">";
        }
      }
      //Services
      if(isset($_POST['servicesMen'])){
        foreach ($_POST['servicesMen'] as $value) {
          $values.="<input type=\"hidden\" name=\"servicesMen\" value=\"".$value."\">";
        }
      }
      $values.="<input type=\"hidden\" name=\"privacyPolicy\">";
      //Privacy policy
      if(isset($_POST['privacyPolicy'])) $values.="<input type=\"hidden\" name=\"privacyPolicy\">";
    //Para evitar de que se limpie el inut automaticamente
        if(!isset($errorName)){ 
        //Form all right!
          //Data to INSERT on citasagendadas --------------------------------------------
            // The id 
              $firstLetterName=ucfirst(substr($_POST['name'],0,1));
              $lastTelDigits=substr($_POST['tel'],-4);
              $actualTime=time();
              $idCita=$firstLetterName.'-'.$actualTime.'-'.$lastTelDigits;
            //Name
              $_POST['name'];
            //telephone
              $_POST['tel'];
          //Fechas && Servicios
            //fecha en que fue agendada AA-MM-DD
              $actualTimeFormated= date('Y-m-d h:i:s',$actualTime);
            // Fecha inicio
                $_POST['day'];
            //Fecha de finalizado y inavilitando las fechas en la tabla fechasDisponibles
              //Men or women
                if(isset($_POST['servicesMen'])){
                  $gender='m'; //Men
                  $services=$_POST['servicesMen'];
                }else{
                  $gender='w'; //Women
                  $services=$_POST['servicesWomen'];
                }
                //Is the last service on the day?
                  $numberOfServices=count($services);
                /* Si es el ultimo servicio del dia devolvera 1 (true) sino devolvera 0 (false)*/
                switch ($numberOfServices) {
                  case 1:
                    //inhabilitando fecha
                      $query='UPDATE fechasDisponibles SET isDisponible=0 WHERE id_fecha="'.skap($_POST['day']).'";';
                      mysqli_query($cnx,$query);
                    //Selecionando fecha de finalizado
                      $query='SELECT DATE_ADD("'.$_POST['day'].'",INTERVAL 30 MINUTE) AS fecha_finalizado;';
                      $fechaFinalizadoResult=mysqli_query($cnx,$query);
                      $fechaFinalizado=mysqli_fetch_assoc($fechaFinalizadoResult);
                    break;
                  case 2:
                    //inhabilitando fecha
                      $query='UPDATE fechasDisponibles 
                      SET isDisponible=0 WHERE id_fecha BETWEEN "'.skap($_POST['day']).'" AND 
                      DATE_ADD("'.$_POST['day'].'",INTERVAL 30 MINUTE);';
                      mysqli_query($cnx,$query);
                    //Selecionando fecha de finalizado
                      $query='SELECT DATE_ADD("'.skap($_POST['day']).'",INTERVAL 60 MINUTE) AS fecha_finalizado;';
                      $fechaFinalizadoResult=mysqli_query($cnx,$query);
                      $fechaFinalizado=mysqli_fetch_assoc($fechaFinalizadoResult);
                    break;
                  case 3:
                    //inhabilitando fecha
                      $query='UPDATE fechasDisponibles 
                      SET isDisponible=0 WHERE id_fecha BETWEEN "'.skap($_POST['day']).'" AND 
                      DATE_ADD("'.skap($_POST['day']).'",INTERVAL 60 MINUTE);';
                      mysqli_query($cnx,$query);
                    //Selecionando fecha de finalizado
                      $query='SELECT DATE_ADD("'.skap($_POST['day']).'",INTERVAL 90 MINUTE) AS fecha_finalizado;';
                      $fechaFinalizadoResult=mysqli_query($cnx,$query);
                      $fechaFinalizado=mysqli_fetch_assoc($fechaFinalizadoResult);
                      break;
                  }
            //Services
            $services=implode(',',$services);
          //Data to INSERT on citasagendadas --------------------------------------------
        //INSERTANDO
        $query=
        'INSERT INTO 
          citasAgendadas
          (id,
          isCommented,
          nombre,
          tel,
          fecha_inicio,
          fecha_finalizado,
          genero,
          fecha_en_que_fue_agendada,
          services
          )
          VALUES(
            "'.skap($idCita).'", 
          0,
          "'.skap($_POST['name']).'",
          "'.skap($_POST['tel']).'",
          "'.skap($_POST['day']).'",
          "'.skap($fechaFinalizado['fecha_finalizado']).'",
          "'.skap($gender).'",
          "'.skap($actualTimeFormated).'",
          "'.skap($services).'"
          );';
          
          var_dump($query);
         mysqli_query($cnx,$query);
         mysqli_free_result($fechaFinalizadoResult);
          $components=
          function(){ 
                      global $values;
                      echo $values;
                      btn('button','ok','Aceptar',' autofocus type="submit" ','Aceptar');
                    };
          dialog(
          $okForm["appointment"]["title"],
          $okForm["appointment"]["msj"].="<br><br> Tu cita esta programada para: ".date('d/m/Y \a \l\a\s h:i A',strtotime($_POST['day'])).
          ' Si quieres darle una reseña a nuestros servicios puedes crear un comentario en el menu>Comentarios>comentar se te solicitara
          el codigo de tu cita, ese codigo es '.$idCita ,
          $components,
          $action 
        );
        }else{
          //An  error ocurs :(
          $components=
            function(){ global $values;
                        echo $values;
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
  // ================================== DIALOG BOXES ===========================
      ?>
</article>
