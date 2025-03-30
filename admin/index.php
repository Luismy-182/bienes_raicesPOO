<?php 
require_once("../includes/app.php");

is_auth();

incluirTemplate('header');
$db=conectarDB();
$estatus=$_GET['resultado'] ?? '';

//implementar un methodo para obtener todas las propiedades


use App\Propiedad;
use App\Vendedor;


$propiedades=Propiedad::all();
$vendedores=Vendedor::all();


if($_SERVER['REQUEST_METHOD']==='POST'){
    //TOMAMMOS EL ID A ELIMINAR y lo filtramos
    $id=$_POST['id'];
    $id=filter_var($id,FILTER_VALIDATE_INT);



    if($id){
    $tipo = $_POST['tipo'];
   
    if(validarTipoContenido($tipo)){
        if($tipo==='vendedor'){
            $vendedor=Vendedor::find($id);
            $vendedor->delete();  
        }else if($tipo==='propiedad'){
            $propiedad=Propiedad::find($id);
            $propiedad->delete();    
        }
    }

}


    


}



?>

<main class="contenedor seccion">

    <h1>Administrador de bienes raices</h1>
  <?php 
    $mensaje=mostrarNotificacion(intval($estatus));
    if($mensaje): ?>
        <p class="alerta exito"><?php echo s($mensaje) ?></p>
    <?php endif;
  
  ?>
    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>
    <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo vendedor</a>
    
    <h2>Propiedades</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>Id</th>
                <th>Título</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        
        <tbody>
            <?php foreach($propiedades as $propiedad ): ?>
            <tr>
                <td><?php echo $propiedad->id ?></td>
                <td><?php echo $propiedad->titulo?></td>
                <td>
                    <img src="/imagenes/<?php echo $propiedad->imagen?>" alt="imagen <?php echo $propiedad->titulo; ?>">    
                </td>
                <td><?php echo $propiedad->precio?></td>
                <td>
                    
                    <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $propiedad->id;?>">
                    <input type="hidden" name="tipo" value="propiedad"> <!--El tipo de persona-->
                    <input type="submit" class="boton-rojo" value="Eliminar">
                    </form>
                    <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id?>" class="boton-azul">Actualizar</a>
                </td>
               
            </tr>
        </tbody>
     
        <?php  endforeach ;?>


    </table>
    <h2>Vendedores</h2>


    <table class="propiedades">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>imagen</th>
                <th>email</th>
            
                <th>Acciones</th>
            </tr>
        </thead>

        
        <tbody>
            <?php foreach($vendedores as $vendedor ): ?>
            <tr>
                <td><?php echo $vendedor->id ?></td>
                <td><?php echo $vendedor->nombre?></td>
                <td><?php echo $vendedor->telefono?></td>
                <td><img src="/imagenes/<?php echo $vendedor->imagen?>" alt="imagen <?php echo $vendedor->nombre?>"></td>
                <td><?php echo $vendedor->email?></td>
                <td>
                    
                    <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $vendedor->id;?>">
                    <input type="hidden" name="tipo" value="vendedor">
                    <input type="submit" class="boton-rojo" value="Eliminar">
                    </form>
                    <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id?>" class="boton-azul">Actualizar</a>
                </td>
               
            </tr>
        </tbody>
     
        <?php  endforeach ;?>


    </table>
            
</main>


<?php 
    incluirTemplate('footer');
?>
