<?php
//================================== DATA TO BE OUTPUT ===========================
$okForm=[];
$errorForm=[];
$GenericMsjPhrase=null;
$name=null;
function dataToBeOutput(){
  global $okForm, $GenericMsjPhrase, $errorForm, $name;
  //This data contents the information of that dialog(); needs to generate the dialog box
    //The array bellow contents the data when all form is right
    $okTitle="Proceso exitoso";
    $okForm = array(
      "appointment" => [
        "title" => $okTitle, 
        "msj" => "{$name}, tu cita ha sido agendada correctamente, si presentas 
                  algún problema o deseas cancelar tu cita puedes comunicarnolo a
                  nuestro <a class=\"normalLink\" href=\"https://api.whatsapp.com/send?phone=+573166183543\">Whatsapp 316 6183543</a>
                  ",
      ],
      "comment" => [
        "title" => $okTitle, 
        "msj" => "{$name}, Tu comentario ha sido subido correctamente",
      ],
    "ArticleEdited" => [
        "title" => $okTitle, 
        "msj" => "{$name}, El articulo ha sido editado de manera exitosa",
      ],
      "ArticleCreated" => [
        "title" => $okTitle, 
        "msj" => "{$name}, El articulo ha sido editado de manera exitosa",
      ],
      //-------------------------- login -------
      /*"logedOk" => [
        "title" => $okTitle, 
        "msj" => "{$name}, Inicio de sesion exitoso",
      ],*/
    );
    //The arrays and vars bellows save the data error
    $GenericMsjPhrase = ", no te preocupes solo presiona reintentar";
    $errorForm = array(
      "nameError" => array( 
        //When the name is forbidden
        "title" => "¿Y tu nombre?",
        "msj" => "Se te olvido colocar tu nombre{$GenericMsjPhrase}",
      ),
      //When the name is too long
      "longNameError" => array( 
        "title" => "Tu nombre es demasiado largo",
        "msj" => "El nombre que ingresaste debe ser menor a 30 caracteres{$GenericMsjPhrase}",
      ),
      //Whe the cell phone is wrong
      "noTel" => array( 
        "title" => "Y tu Numero",
        "msj" => "{$name}, Has olvidado colocar tu numero Celular{$GenericMsjPhrase}",
      ),
      //when the cell phone is uncorrect format
      "noTelFormat" => array( 
        "title" => "Por favor ingresa un numero de celular valido",
        "msj" => "{$name}, Ingresa un numero de celular valido ej: 3126788909{$GenericMsjPhrase}",
      ),
      //Whe the privacy-policy is uncheked
      "noPP" => array( 
        "title" => "¡Olvidas algo!",
        "msj" => "{$name}, Debes aceptar la política de tratamiento de datos, si deseas leerla esta disponible 
              en <a href='#' target='_blank'>este enlace</a>",
      ),
      //Whe Men a women type services is cheked
      "undefined" => array( 
        "title" => "Uno de dos",
        "msj" => "{$name}, No puedes seleccionar servicios para damas y caballeros en una misma cita, 
                  si deseas puedes agendar una nueva, o corregir tu error",
      ),
      //When none service is cheked
      "noneServiceError" => array( 
        "title" => "No has seleccionado ningun servicio",
        "msj" => "{$name}, debes seleccionar al menos un servico{$GenericMsjPhrase}",
      ),
      //When none day is selected
      "noDay" => array( 
        "title" => "¿Y la fecha?",
        "msj" => "{$name}, has olvidado seleccionar en que fecha vas a agendar tu cita{$GenericMsjPhrase}",
      ),
      //Date non Avaible
      "nonAvaibleDate"=>[
        "title" => "No disponible",
        "msj" => "{$name}, La fecha que elegiste no esta disponible, elige otra{$GenericMsjPhrase}",
      ],
      //comment
      "noComment" => [
        "title" => "¿Y tu comentario?",
        "msj" => "{$name}, Has olvidado ingresar tu comentario{$GenericMsjPhrase}"
      ],
      //To long comment
      "longComment"=>[
        "title" => "Demasiado largo",
        "msj" => "{$name}, Tu comentario es demasiado largo por favor intentalo de nuevo{$GenericMsjPhrase}"
      ],
      //Id no existe en la DB
      'invalidId'=>[
        "title" => "ID Incorrecto",
        "msj" => "{$name}, El codigo ID que ingresaste es invalido, el codigo id fue el que recibiste al agendar la cita{$GenericMsjPhrase}"
      ],
      //empty id
      'noId'=>[
        "title" => "¿Y el Codigo ID?",
        "msj" => "{$name}, SE te ha olvidado colocar el codigo ID.{$GenericMsjPhrase}"
      ],
      //No image sended
      "noImage" => [
        "title" => "No hay imagen",
        "msj" => "{$name}, No has subido ninguna imagen{$GenericMsjPhrase}"
      ],
      //Image File Extencion error
      "noImageFormat" => [
        "title" => "formato incorrecto",
        "msj" => "{$name}, el archivo que has seleccionado no tiene un formato valido de imagen{$GenericMsjPhrase}",
      ],
      //No body article body
      "noBody" => [
        "title" => "¿Y el contenido?",
        "msj" => "{$name}, Se te olvido escribir el cuerpo del blog{$GenericMsjPhrase}",
      ],
      //No Autor
      "noAutor"=>[
        "title" => "¿Y tu nombre?",
        "msj" => "{$name}, Olvidaste llenar em el que pondrias tu nombre como el autor/a del el articulo{$GenericMsjPhrase}",
      ],
      //Articulo sin nombre
      "noArticleName"=>[
        "title" => "Articulo sin nombre",
        "msj" => "{$name}, Has olvidado pornerle el tiulo a tu articulo{$GenericMsjPhrase}",
      ],
      //Too long Article Name
      "tooLongArticleName"=>[
        "title" => "Titulo muy largo",
        "msj" => "{$name}, El nombre de articulo que has ingresado es muy largo, intenta que sea menor a 90 caracteres{$GenericMsjPhrase}",
      ],
      //The name of the article already exist
      'articleNameAlreadyExist'=>[
        "title" => "Ya Existe",
        "msj" => "{$name}, El nombre que has ingresado como nombre de articulo ya existe, intenta con uno diferente{$GenericMsjPhrase}",
      ],
      //Too long Author name
      "tooLongAutor"=>[
        "title" => "Tu nombre es muy largo",
        "msj" => "{$name}, El nombre de autor/a que has ingresado es muy largo, intenta que sea menor a 90 caracteres{$GenericMsjPhrase}",
      ],
      //The status isnt set
      "noStatusPublication"=>[
        "title" => "Olvidaste colocar cual es el estado de la publicacion",
        "msj" => "{$name}, Debes elegir entre borrador y publicado, Cuando das en borrador solo lo podras ver tu mientras lo editas, cuando le das a usuarios solo lo podran ver tus usuarios{$GenericMsjPhrase}",
      ],

      //-------------------------- login -------
      "noUserName"=>[
        "title" => "¿Y tu user name?",
        "msj" => "Has olvidado colocar tu nombre de usuario{$GenericMsjPhrase}",
      ],
      "noPasword"=>[
        "title" => "¿Y tu user name?",
        "msj" => "Has olvidado colocar tu nombre de usuario{$GenericMsjPhrase}",
      ],
      "incorretUserNameOrPasword"=>[
        "title" => "Te has equivocado",
        "msj" => "Nombre de usuario o contraeña incorrectxs{$GenericMsjPhrase}",
      ],
      
  );
  //
}
// ================================== DATA TO BE OUTPUT ===========================
