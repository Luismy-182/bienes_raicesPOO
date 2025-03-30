<?php
use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

require_once('../../includes/app.php');
incluirTemplate('header');
is_auth();
$id=$_GET['id'];

//buscar una propiedad por su id;+
$alertas=[];


//llena el select de vendedores
$vendedor=Vendedor::find($id);
$vendedores=Vendedor::all();
$alertas=Vendedor::getAlertas();

if(!$id){
    header('Location: /admin');
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //asignar los atributos
    $args=$_POST['vendedor'];
    $vendedor->sincronizar($args);
    $alertas=$vendedor->validar();
    //generando un nombre unico para almacenar imagen
    $nombre_imagen=md5(uniqid(rand(),true)).'.jpg';

    if($_FILES['vendedor']['tmp_name']['imagen']){

        $imagen=Image::make($_FILES['vendedor']['tmp_name']['imagen'])->fit(800,600);
     
        $vendedor->setImagen($nombre_imagen);
    }
    
    if(empty($alertas)){
        if($_FILES['vendedor']['tmp_name']['imagen']){
        $imagen->save(CARPETA_IMAGENES . $nombre_imagen);
        }
        $resultado=$vendedor->save();
        
    }
    $resultado=$vendedor->save();

    
}







?>

<main class="contenedor seccion">
    <h1>Actualizar</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php 
        foreach($alertas as $alerta){

         
            ?> 
            <div class="alerta error"><?php echo $alerta ?></div>
            <?php 
        }
    ?>
    <form class="formulario" method="POST" enctype="multipart/form-data">
      
        <?php require_once('../../includes/templates/vendedorForm.php'); ?>

        <input type="submit" value="Actualizar vendedor" class="boton boton-verde">
    </form>
</main>


<?php 
    incluirTemplate('footer');
    
?>
