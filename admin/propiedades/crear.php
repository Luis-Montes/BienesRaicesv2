<?php
//Base de datos
require '../../includes/config/database.php';
$db = conectarDB();
//Obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Arreglo de errores
$errores = [];

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedor_id = '';

// Se ejecuta despues de enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

    $titulo = mysqli_real_escape_string( $db, $_POST['titulo']);
    $precio = mysqli_real_escape_string( $db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string( $db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string( $db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string( $db, $_POST['estacionamiento']);
    $vendedor_id = mysqli_real_escape_string( $db, $_POST['vendedor_id']);
    $creado = date('Y/m/d');

    //Asignar files a una variable
    $imagen = $_FILES['imagen'];

    if (!$titulo) {
        $errores[] = "Debes añadir el título";
    }

    if (!$precio) {
        $errores[] = "El precio es obligatorio";
    }

    if (strlen($descripcion) < 30) {
        $errores[] = "La descripción debe tener mas de 30 caracteres";
    }

    if (!$habitaciones) {
        $errores[] = "El numero de habitaciones es obligatorio";
    }

    if (!$wc) {
        $errores[] = "El numero de baños es obligatorio";
    }

    if (!$estacionamiento) {
        $errores[] = "El numero de estacionamientos es obligatorio";
    }

    if (!$vendedor_id) {
        $errores[] = "Elige un vendedor";
    }

    if (!$imagen['name'] || $imagen['error']) {
        $errores[] = "Imagen obligatoria";
    }

    // Validar el tamaño de la imagen
    $medida = 1000 * 1000;

    if ($imagen['size'] > $medida) {
        $errores[] = 'La imagen es muy pesada';
    }

    //Revisar que el arreglo de errores este vacio
    if (empty($errores)) {
        //Guardar las imagenes

        //Crear carpeta
        $carpetaImagenes = '../../imagenes/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        //Generar nombre unico
        $nombreImagen = md5(uniqid(rand(), true));

        //Subir imagen
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen . ".jpg");


        $query = " INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedor_id) 
        VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedor_id') ";

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: /admin?resultado=1');
        }
    }
}


require '../../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="post" action="/admin//propiedades/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Título Propiedad" value="<?php echo $titulo ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion"><?php echo $descripcion ?></textarea>

        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" value="<?php echo $habitaciones ?>" placeholder="Ej: 3" min="1" max="3">

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="3" value="<?php echo $wc ?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" value="<?php echo $estacionamiento ?>" max="3">

        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor_id">
                <option value="">-- Seleccione --</option>
                <?php while($vendedor = mysqli_fetch_assoc($resultado) ): ?>
                    <option <?php echo $vendedor_id === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id'] ?>"><?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplate('footer');
?>

<script src="/build/js/bundle.min.js"></script>
</body>

</html>