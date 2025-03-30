<?php 

use App\Vendedor;
require __DIR__.('/../../includes/app.php');
use Intervention\Image\ImageManagerStatic as Image;
$db=conectarDB();
incluirTemplate('header');
is_auth();

$alertas=Vendedor::getAlertas();
$vendedor=new Vendedor;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $vendedor=new Vendedor($_POST['vendedor']);
   
    $alertas=$vendedor->validar();
    if(empty($alertas)){

        //preparamos la imagen
        $nombre_imagen=md5(uniqid(rand(),true)).'.jpg';
        if($_FILES['vendedor']['tmp_name']['imagen']){
            $imagen=Image::make($_FILES['vendedor']['tmp_name']['imagen'])->fit(800,600);
            $vendedor->setImagen($nombre_imagen);
        }
        $resultado=$vendedor->save();
        
        if($resultado){

                   /***************insertando imagen************/
        
        //crear carpeta relativa
        $carpetaImagenes='../../imagenes/';
        
        if(!is_dir($carpetaImagenes)){
            mkdir($carpetaImagenes, 0777);
        }

        //usando intervention image guardar imagen en servidor
        $imagen->save($carpetaImagenes.$nombre_imagen);
        //ahora guardamos tambien el nombre en la bd
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
       <?php include('../../includes/templates/vendedorForm.php') ?>

        <input type="submit" value="Crear Vendedor" class="boton boton-verde">
    </form>
</main>


<?php 
    incluirTemplate('footer');
?>
