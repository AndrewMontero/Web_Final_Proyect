document.addEventListener('DOMContentLoaded', () => {
    const priceRange = document.getElementById('price-range');
    const priceValue = document.getElementById('price-value');
    const filterPriceButton = document.getElementById('filterPriceButton');
    const searchButton = document.getElementById('searchButton');
    const searchInput = document.getElementById('search');
    const categoriaSelect = document.getElementById('category');
    const subcategoriaSelect = document.getElementById('subcategory');

    // Array para almacenar los productos seleccionados
    let carrito = [];

    noUiSlider.create(priceRange, {
        start: [5000, 74000],
        connect: true,
        range: {
            'min': 0,
            'max': 100000
        },
        tooltips: [true, true],
        format: {
            to: value => `₡${parseInt(value)}`,
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
                filtrarProductos(true);
                searchInput.value = '';
                categoriaSelect.value = '';
                subcategoriaSelect.value = '';
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
                                    <p class="card-text">Precio: ₡${producto.Precio}</p>
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

                    // Añadir evento de clic para el botón "Añadir"
                    productoDiv.querySelector('.add-to-cart').addEventListener('click', () => {
                        const cantidad = productoDiv.querySelector('input[type="number"]').value;
                        const productoCarrito = {
                            ...producto,
                            cantidad: parseInt(cantidad) // Guardar la cantidad seleccionada
                        };
                        carrito.push(productoCarrito);
                        console.log('Producto añadido al carrito:', productoCarrito);
                        console.log('Carrito actual:', carrito);
                    });
                });
            }

            function decreaseQuantity(button) {
                const input = button.parentElement.nextElementSibling;
                if (input.value > 1) {
                    input.value--;
                }
            }

            function increaseQuantity(button) {
                const input = button.parentElement.previousElementSibling;
                input.value++;
            }

            filtrarProductos();
        });
});
