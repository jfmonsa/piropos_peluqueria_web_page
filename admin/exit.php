<?php
if(!isset($_POST['confirm1']) && !isset($_POST['cancel1'])){
    $components= function(){ ?>
        <div class="d__flatBtnContainer"><?php
        btn('button','error','Cancelar',' type="submit" name="cancel1"',' Cancelar ');
        btn('button','ok','Aceptar',' type="submit" name="confirm1"',' Aceptar ');
    ?></div><?php
      };
        dialog('¿Cerrar sesion?',
        ' Estas seguro que quieres cerrar sesion',$components,
        'action="'.$_SERVER['PHP_SELF'].'?page=exit" method="post"'
      );
}
elseif(isset($_POST['confirm1'])){        
    $components= function(){
        btn('button','ok','Aceptar',' type="submit" name="confirm1"',' Aceptar ');
      };
        dialog('Proceso exitoso',' La sesion se cerro correctamente, hasta luego',$components,'action="'.$_SERVER['PHP_SELF'].'" method="post"');
        session_destroy(); // destruyo la sesión    
    
}elseif(isset($_POST['cancel1'])){
    $components=function(){ 
        btn('button','ok','Aceptar',' type="submit" name="confirm1"',' Aceptar ');
      };
    dialog('Proceso cancelado',' La sesion no ha se cerrado',$components,'action="'.$_SERVER['PHP_SELF'].'" method="post"');
}