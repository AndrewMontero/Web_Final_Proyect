<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda Virtual</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/styles/dashboard.css">

</head>

<body>
    <div class="container-fluid">
        <div class="row fixed-top header bg-white">
            <div class="col-3"></div>
            <div class="col-6 text-center py-3">
                <div class="logo">
                    <img src="/img/logo.jpg" alt="Logo">
                </div>
            </div>
            <div class="col-3 d-flex justify-content-end align-items-center py-3 header-buttons">
                <div class="usuarioCarrito">
                    <div class="row w-100">
                        <div class="col-6 d-flex justify-content-end align-items-center">
                            <a href="perfil.php" class="d-flex align-items-center">
                                <img src="../img/usuario.png" alt="Usuario" class="icono-usuario">
                                <span class="texto-usuario ml-2">Mi cuenta</span>
                            </a>
                        </div>
                        <div class="col-6 d-flex justify-content-end align-items-center">
                            <a id="guardarCarritoButton" href="carrito.php" class="d-flex align-items-center">
                                <img src="../img/carrito.jpg" alt="Carrito" class="icono-carrito">
                                <span class="texto-carrito ml-2">Mi carrito</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3 sidebar">
                <h5>Filtro</h5>
                <form id="filterForm">
                    <div class="form-group">
                        <label for="search">Buscador</label>
                        <input type="text" class="form-control" id="search" placeholder="Buscar producto">
                        <button type="button" id="searchButton" class="btn btn-primary mt-2">Buscar</button>
                    </div>
                    <div class="form-group">
                        <label for="price">Precio</label>
                        <div id="price-range" class="price-range"></div>
                        <p id="price-value"></p>
                        <button type="button" id="filterPriceButton" class="btn btn-primary">Filtrar por Precio</button>
                    </div>
                    <div class="form-group">
                        <label for="category">Categoría</label>
                        <select class="form-control" id="category">
                            <option value="">Todas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subcategory">Subcategoría</label>
                        <select class="form-control" id="subcategory">
                            <option value="">Todas</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="col-9 content">
                <div class="row" id="productos"></div>
            </div>
        </div>
    </div>
    <script src="../js/dashboard.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.js"></script>

</body>

</html>