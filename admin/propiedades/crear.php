<?php
//Base de datos
require '../../includes/config/database.php';

$db = conectarDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $vendedor_id = $_POST['vendedor_id'];

    $query = " INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedor_id) 
    VALUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedor_id') ";

    echo $query;
}


require '../../includes/funciones.php';
incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <form class="formulario" method="post" action="/admin//propiedades/crear.php">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Título Propiedad">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="imagen/jpge, imagen/png">

                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion"></textarea>

            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="3">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="3">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="3">

            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor_id">
                    <option value="1">Luis</option>
                    <option value="2">Gloria</option>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>

        <a href="/admin" class="boton boton-verde">Volver</a>
    </main>
    <?php
    incluirTemplate('footer');
    ?>

    <script src="/build/js/bundle.min.js"></script>
</body>
</html>