<?php
require '../shared/header.php';
?>


<body>
    <div class="container-fluid">
        <div class="row fixed-top header bg-white">
            <div class="col-3"></div>
            <div class="col-6 text-center py-3">
                <div class="logo">
                    <img src="../img/logo.jpg" alt="Logo">
                </div>
            </div>
            <div class="col-3 d-flex justify-content-end align-items-center py-3 header-buttons">
                <div class="row w-100">
                    <div class="col-6 d-flex justify-content-end">
                        <a href="perfil.php" class="btn btn-primary w-100">Mi Cuenta</a>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <button class="btn btn-primary w-100">Carrito</button>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const priceRange = document.getElementById('price-range');
            const priceValue = document.getElementById('price-value');
            const filterPriceButton = document.getElementById('filterPriceButton');
            const searchButton = document.getElementById('searchButton');
            const searchInput = document.getElementById('search');
            const categoriaSelect = document.getElementById('category');
            const subcategoriaSelect = document.getElementById('subcategory');

            noUiSlider.create(priceRange, {
                start: [5000, 74000], // Valores iniciales en colones
                connect: true,
                range: {
                    'min': 0,
                    'max': 100000 // Rango máximo en colones
                },
                tooltips: [true, true],
                format: {
                    to: value => `₡${parseInt(value)}`, // Símbolo de colón
                    from: value => Number(value.replace('₡', ''))
                }
            });

            priceRange.noUiSlider.on('update', (values, handle) => {
                priceValue.innerHTML = `Precio: ${values[0]} - ${values[1]}`;
            });

            fetch('../json/productos.json')
                .then(response => response.json())
                .then(data => {
                    const productosContainer = document.getElementById('productos');

                    data.categorias.forEach(categoria => {
                        const categoriaOption = document.createElement('option');
                        categoriaOption.value = categoria.nombre;
                        categoriaOption.textContent = categoria.nombre;
                        categoriaSelect.appendChild(categoriaOption);
                    });

                    categoriaSelect.addEventListener('change', () => {
                        const categoriaSeleccionada = categoriaSelect.value;
                        subcategoriaSelect.innerHTML = '<option value="">Todas</option>';

                        if (categoriaSeleccionada) {
                            const categoria = data.categorias.find(cat => cat.nombre === categoriaSeleccionada);
                            if (categoria) {
                                categoria.subcategorias.forEach(subcategoria => {
                                    const subcategoriaOption = document.createElement('option');
                                    subcategoriaOption.value = subcategoria.nombre;
                                    subcategoriaOption.textContent = subcategoria.nombre;
                                    subcategoriaSelect.appendChild(subcategoriaOption);
                                });
                            }
                        }

                        filtrarProductos();
                    });

                    subcategoriaSelect.addEventListener('change', () => {
                        filtrarProductos();
                    });

                    filterPriceButton.addEventListener('click', () => {
                        filtrarProductos();
                    });

                    searchButton.addEventListener('click', () => {
                        filtrarProductos(true); // Pasamos true para indicar que es una búsqueda por palabra clave
                        searchInput.value = ''; // Limpiar el campo de búsqueda
                        categoriaSelect.value = ''; // Restablecer el combobox de categoría
                        subcategoriaSelect.value = ''; // Restablecer el combobox de subcategoría
                    });

                    function filtrarProductos(esBusquedaPorPalabraClave = false) {
                        const categoriaSeleccionada = categoriaSelect.value;
                        const subcategoriaSeleccionada = subcategoriaSelect.value;
                        const searchKeyword = searchInput.value.toLowerCase();
                        const [precioMin, precioMax] = priceRange.noUiSlider.get().map(value => Number(value.replace('₡', '')));

                        const productosFiltrados = data.categorias
                            .flatMap(categoria => {
                                return categoria.subcategorias.flatMap(subcategoria => {
                                    return subcategoria.productos.map(producto => ({
                                        ...producto,
                                        categoria: categoria.nombre,
                                        subcategoria: subcategoria.nombre
                                    }));
                                });
                            })
                            .filter(producto => {
                                const categoriaValida = !categoriaSeleccionada || producto.categoria === categoriaSeleccionada;
                                const subcategoriaValida = !subcategoriaSeleccionada || producto.subcategoria === subcategoriaSeleccionada;
                                const precioValido = producto.Precio >= precioMin && producto.Precio <= precioMax;
                                const keywordValido = !searchKeyword || producto.nombre.toLowerCase().includes(searchKeyword) ||
                                    producto.Marca.toLowerCase().includes(searchKeyword) ||
                                    producto.subcategoria.toLowerCase().includes(searchKeyword);

                                // Si es una búsqueda por palabra clave, solo consideramos keywordValido
                                if (esBusquedaPorPalabraClave) {
                                    return keywordValido;
                                } else {
                                    return categoriaValida && subcategoriaValida && precioValido;
                                }
                            });

                        mostrarProductos(productosFiltrados);
                    }

                    function mostrarProductos(productos) {
                        productosContainer.innerHTML = '';
                        productos.forEach(producto => {
                            const productoDiv = document.createElement('div');
                            productoDiv.classList.add('col-md-4', 'mb-3');
                            productoDiv.innerHTML = `
                            <div class="card">
                                <img src="${producto.Imagen}" class="card-img-top" alt="${producto.nombre}">
                                <div class="card-body">
                                    <h5 class="card-title">${producto.nombre}</h5>
                                    <p class="card-text">Marca: ${producto.Marca}</p>
                                    <p class="card-text">Presentación: ${producto.Presentación}</p>
                                    <p class="card-text">Precio: ₡${producto.Precio}</p> <!-- Cambiado a colones -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="decreaseQuantity(this)">-</button>
                                            </div>
                                            <input type="number" class="form-control" value="1" min="1" max="10">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="increaseQuantity(this)">+</button>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-sm add-to-cart">Añadir</button>
                                    </div>
                                </div>
                            </div>`;
                            productosContainer.appendChild(productoDiv);
                        });
                    }

                    window.decreaseQuantity = function (button) {
                        const input = button.parentElement.nextElementSibling;
                        if (input.value > 1) {
                            input.value--;
                        }
                    };

                    window.increaseQuantity = function (button) {
                        const input = button.parentElement.previousElementSibling;
                        input.value++;
                    };

                    filtrarProductos();
                });
        });
    </script>
</body>

</html>