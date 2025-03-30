<?php 

use App\Vendedor;
use App\Propiedad;

require __DIR__.('/../../includes/app.php');

use Intervention\Image\ImageManagerStatic as Image;
$propiedad=new Propiedad;
$db=conectarDB();
incluirTemplate('header');
is_auth();



$vendedores=Vendedor::all();

$alertas=Propiedad::getAlertas();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    
    //forma POO.
    $propiedad= new Propiedad($_POST['propiedad']);
    
    
    //generando un nombre unico para almacenar imagen
    $nombre_imagen=md5(uniqid(rand(),true)).'.jpg';
    if($_FILES['propiedad']['tmp_name']['imagen']){

        $imagen=Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
     
        $propiedad->setImagen($nombre_imagen);
    }

    //validar
    $alertas=$propiedad->validar();


    
    if(empty($alertas)){
        
        /***************insertando imagen************/
        
        //crear carpeta relativa
        $carpetaImagenes='../../imagenes/';
        
        if(!is_dir($carpetaImagenes)){
            mkdir($carpetaImagenes, 0777);
        }

        
        //subir o mover la imagen del directorio temporal
        //  move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombre_imagen);
        
        //usando intervention image guardar imagen en servidor
        $imagen->save($carpetaImagenes. $nombre_imagen);
        //ahora guardamos tambien el nombre en la bd
        
        //si no hay alertas insertamos
        $resultado=$propiedad->save();

        if($resultado){
            header('Location: /admin?resultado=1');
        }
   


    }

   
}






?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php 
        foreach($alertas as $alerta){

         
            ?> 
            <div class="alerta error"><?php echo $alerta ?></div>
            <?php 
        }
    ?>
    <form class="formulario" method="POST" enctype="multipart/form-data">
       <?php include('../../includes/templates/formulario.php') ?>

        <input type="submit" value="Crear propiedad" class="boton boton-verde">
    </form>
</main>


<?php 
    incluirTemplate('footer');
?>
