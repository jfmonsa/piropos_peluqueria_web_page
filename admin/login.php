<h2 class="m__Art__h2">Login</h2>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <?php
        if(isset($_POST['user']))$value=' value="'.$_POST['user'].'"'; else $value=null;
    generalInput('Nombre de usuario','user',' type="text" name="user"'.$value,'Ingrese su nombre de usuario');
        if(isset($_POST['pasword']))$value=' value="'.$_POST['pasword'].'"'; else $value=null;
    generalInput('contraseña','pasword',' type="text" name="pasword"'.$value,'Ingrese su contraseña');
    btn('button','callToAction','Iniciar Sesion',' type="submited" name="submited"',' Iniciar Sesion ');
    ?>
</form>







<?php
/*
user: admin
pasword:123456789
*/
while(isset($_POST['submited'])){
    require_once('../validateArray.php');
    // ------------ Verify the user name ---------------
    //No user name
        $name=trim($_POST['user']);
        if(empty($name)){$errorName="noUserName";break;}
    //password
        if(empty($name)){$errorName="noPasword";break;}
    //encripting
        $pasword=sha1(trim($_POST['pasword']));
    //Doing the query
        $query='SELECT COUNT(usuario) AS total FROM administrador WHERE usuario="'.skap($name).'" AND contrasenia="'.skap($pasword).'";';
        $result=mysqli_query($cnx,$query);
        $row=mysqli_fetch_assoc($result);
        //mysqli_free_result($result);
    //incorret?
        if($row['total']=='0'){$errorName='incorretUserNameOrPasword';break;}
        break;
}

if(isset($_POST['submited'])){
        dataToBeOutput();
        $action=' action="'.$_SERVER['PHP_SELF'].'?form" method="post" id="dialog"';
      //Para evitar de que se limpie el inut automaticamente
        $values="
          <input type=\"hidden\" name=\"user\" value=\"".$name."\">
          <input type=\"hidden\" name=\"pasword\" value=\"".$_POST['pasword']."\">
        ";
        if(!isset($errorName)){
            //Ok form
            $_SESSION['user']=$name;
            $_SESSION['pasword']=$pasword;
            $components=
                function(){ global $values;
                            echo $values;
                            btn('button','ok','Aceptar',' autofocus type="submit" ','Aceptar');
                          };
            dialog(
                'Proceso exitoso', 
                'Usuario y contraseñas correctxs',
                $components,
                $action
              );
        }
        else{
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