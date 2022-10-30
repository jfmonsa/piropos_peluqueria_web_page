<?php

/*btn()

This function generate button with the tag <button></button><a>
btn($tag,$typeBtn,$initialMsg,[$hoverMsg='Ver mas',$href='#',$formBtn=false])
$tag
    'button' --> <button></button>
    'a' --> <a></a>
$typeBtn
    'normal' --> generic btn
    'ok' --> green btn for indicate that the before action was correct
    'error' --> red btn for indicate that the before action was wrong
    'callToAction' --> a different button more atractive to the user
$initialMsg
    is a string with the initial Msg that the button will show when is not hover
$hoverMsg
    (optional) string with the Msg that will show when the mouse is hover the component
    by default is equal to 'Ver mas'
$attrBtn atributos que queremos que este en la etiqueta, 
    $attrBtn=
        //for links
        ' href="#" target="_blank"  ';
    $attrBtn=
        //for form buttons
        ' type="submit" value="submited" formaction="/action_page2.php"';
*/
function btn($tag,$typeBtn,$initialMsg,$attrBtn=null,$hoverMsg='Ver mas'){?>
    <<?php echo $tag.' '.$attrBtn.' class="btn  btn--'.$typeBtn.'"' ?> >
        <span class="btn--normalContent"><?php echo $initialMsg ?></span>
        <span class="btn--hoverContent"><?php echo $hoverMsg; ?></span>
    </<?php echo $tag ?>>
<?php
}
/*inputFile($labelN,$id,$attr,$typeBtn,$labelH=null)

    Genera un input de type="file", que en su parte grafica es indentica a un boton
    $labelN
        (string)
        Contenido que tenga el boton que es visible sin pasar el mouse
    $id 
        (string)
        stirng con el nombre de id que le queremos dar a la etiqueta input
    $attr
        (string)
        contine todos los atributos del <input type="file">
        ej:
        ' accept="image/*"'
    $typeBtn
        (string)
        'normal' --> generic btn
        'ok' --> green btn for indicate that the before action was correct
        'error' --> red btn for indicate that the before action was wrong
        'callToAction' --> a different button more atractive to the user
    $labelH
        (strign) [optional]
        Contenido que es visible al pasar el mouse, por default es el mismo contenido que $labelH
          */
function inputFile($labelN,$id,$attr,$typeBtn,$labelH=null){?>
    <input id="<?php echo $id?>" type="file" <?php echo $attr ?>>
    <label for="<?php echo $id?>" class="btn btn--<?php echo $typeBtn ?>">
      <span class="btn--normalContent"><?php echo $labelN ?></span>
      <span class="btn--hoverContent"><?php  if($labelH==null) echo $labelN; else echo $labelH ?></span>
    </label>
  <?php }

    /*FUNCIONES PARA COMPOENTES DE FORMULARIO*/
/*checkbox()

$id
    stirng con el nombre de id que le queremos dar
$name
    Nombre de la variable que queremos recibir en el backend
    puede ser un array o una variable
$value
    Valor de la variable que queremos recibir en el backed
$label
    texto que queramos que muestre el label

*/
function checkbox($id,$name,$value,$label,$isarray=false){?>
    <div class="chkWp">
      <input  
        type="checkbox" 
        id="<?php echo $id?>" 
        name="<?php if($isarray) echo $name.'[]';else echo $name; ?>" 
        value="<?php echo $value?>" 
        <?php
        if(isset($_POST[$name])){
          if(is_array($_POST[$name]) && in_array($value, $_POST[$name]) || $_POST[$name] == $value){echo "checked";}
        }  
        ?>
      >
      <label for="<?php echo $id ?>"><?php echo $label ?></label>
    </div>
  <?php
  }  
/*
generalInput()
  Genera un input de texto, numero, telefono etc.. inputs donde se ingresan caracteres
  $label
    (string)
    contenido de texto que queremos que tenga el input
  $id
    (string)
    id que le asignamos como atributo al input
$attr
  (string)
  contine todos los atributos del <input>
  ej
  ' type="tel" name="tel" inputmode="tel" placeholder="Telefono celular"  '

  The placeholder attr is yet include
*/
  function generalInput($label,$id,$attr,$placeholder=''){?>
    <div class="inputWp">
          <input 
            <?php echo $attr ?>
           placeholder="<?php
           if(empty($placeholder))echo $label;
           else echo $placeholder 
            ?>"
            id="<?php echo $id ?>" 
          >
          <label for="<?php echo $id ?>"><?php echo $label ?></label>
        </div>
 <?php } ;
/*
select($label,$id,$options)
    $label
        (string)
        contenido de texto que queremos que tenga el input
    $id
        (string)
        id que le asignamos como atributo al input
    $attr
        (string)
        Contiene los atributos de la etiqueta select como:
        ej
        ' name="hour" ' 
    $options
        (array)
        Un array multidimensional este contiene dos arrays asociativos

        ['text']=> contiene el texto que aparecera en al opcio
    $defaultOption
        (string)
        Es la opcion por defecto solo se imprimira el contenido cuando es diferente a null
        se debe ingresar solo el contenido y no la etiqueta completa
*/
function select($label,$id,$attr,$options,$defaultOption){?>
    <div class="slctWp">
              <label for="<?php echo $id ?>"><?php echo $label ?></label>
              <select id="<?php echo $id ?>" <?php echo $attr ?>>
                <?php
                if(!$defaultOption==null) echo '<option selected>'.$defaultOption.'</option>';
                //showing the options
                $textLenght=count($options['text']);
                $valueLenght=count($options['value']);
                for ($textI=0, $valueI=0;;$textI++,$valueI++) { 
                    //Stoping the loop
                    if($textI >= $textLenght || $valueI >= $valueLenght) break;
                    //showing the options
                    $value=$options['value'][$valueI];
                    if(!isset($value) || !$value==null)$value='value="'.$value.'"';
                    echo '<option '.$value.'>'.$options['text'][$textI].'</option>';
                }
                ?>
              </select>
            </div>
    <?php }
/*
select($label,$id,$attr)
    $label
        (string)
        contenido de texto que queremos que tenga el input
    $id
        (string)
        id que le asignamos como atributo al input
    $attr
        (string)
        Contiene los atributos de la etiqueta select como:
        ej
        ' cols="32" rows="8" name="comment" autocapitalize="sentences"'

        The placeholder attr is yet included
    $defaultContent
        Es el texto por default que queremos que tenga el text area
*/
function textarea($label,$id,$attr,$defaultContent=null,$placeholder=''){?>
    <div class="txtWp">
      <textarea placeholder="<?php
            if(empty($placeholder))echo $label;
            else echo $placeholder 
        ?>"  
      <?php echo $attr ?>  id="<?php echo $id ?>" ><?php echo $defaultContent ?></textarea>
      <label for="<?php echo $id ?>"><?php echo $label ?></label>
    </div>
    <?php }

  /*
dialog()
    $title
        (string)
        El titulo que queremos que tenga nuestro cuadro de dialogo
    $msj
        (string)
        El mensaje que queremos que tenga nuestro cuadro de dialogo
    $components
        (variable con callbacks)
        Un array asociativo que contiene funciones anonimas, las funciones
        anonimas contienen otra funcion, estas funicones son los distintos componenetes
    $components=
            'btn1' => function(){
                        btn('button','error','Reintentar','Reintentar');
                    }
    $formAttr
        (string)
        atributos que queremos que aparescan dentro de la etiqueta form como
        las
        paginas se cargan mediante condicionales en la variable form recibida por el
        metodo get, cuando esta variable estapresente se cargan cuadros de dialogo segun 
        la condicion
        ej
        ' method="post" enctype="" '
    $style
        (string)
        Un string que contiene la etiqueta 
        <style>
            //estilos particulares al cuadro de dialogo
        </style>
*/
function dialog ($title, $msj, $components,$formAttr=null,$style=null){?>
    <dialog open class="d" id="d">
    <form <?php echo $formAttr?> >
        <h2><?php echo $title ?></h2>
        <p class="d__h2"><?php echo $msj ?></p>
        <?php
            $components();
            echo $style
    ?>
    </form>
    </dialog>
    <?php }


/*
comment()
    Genera un contenedor, que tiene en su interior 3 comentarios que ha hecho la comunidad
    $repeat
        (int)
        Numero de contenedores que queremos que se quieran generar
    $col
        (int) (opcional)
        Numero de columnas interiores del contenerdor

    ----------------------------------   Variables internas  ------------------------------------
        $comments 
            (array)
            Array con cada comentario
        $commentsN
            (int)
            Numero de comentarios
        $blockI
            (int)
            Iterador de cada
        $colsI
            (int)
            iterador de las columnas
 */
//This is a subfunction that order all the comments
/*
readDirectories($path (string)) : array
    Le pasamos como parametro una ruta

    $path
    (string)
    Es la ruta al directorio que queremos recorrer
*/
// 'community'
function readDirectories($path){
    if ($handle = opendir($path)) {
        //All the comments
        $comments=[];
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                array_push($comments,$entry);
            }
        }
        //Termnina de recorrer el directorio  
        closedir($handle);
    }
    return $comments;
}
