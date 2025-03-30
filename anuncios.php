<?php 

require 'includes/app.php';
incluirTemplate('header');
?>

    <main class="contenedor section">
        <h1>Casas y depas en venta</h1>


    <?php 
        include __DIR__.'/includes/templates/anuncios.php';
    ?>
    </div>

    </main>

    <?php incluirTemplate('footer'); ?>

</body>
</html>