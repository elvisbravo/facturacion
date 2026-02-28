let cart = [];

let activePaymentMethods = [];
let paymentMethodsDB = [];
const paymentMethodsConfig = {
    cash: {
        icon: "payments",
        color: "green",
        class: "bg-green-100 dark:bg-green-900/40 text-green-600",
    },
    card: {
        icon: "credit_card",
        color: "blue",
        class: "bg-blue-100 dark:bg-blue-900/40 text-blue-600",
    },
    yape: {
        icon: `<svg viewBox="0 0 24 24" class="size-6 fill-current"><path d="M13.5 4L7 13h5l-2 7 6.5-9H11l2.5-7z"/></svg>`,
        color: "purple",
        class: "bg-purple-100 dark:bg-purple-900/40 text-purple-600",
        isSvg: true,
    },
    plin: {
        icon: `<svg viewBox="0 0 24 24" class="size-6 fill-current"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>`,
        color: "cyan",
        class: "bg-cyan-100 dark:bg-cyan-900/40 text-cyan-600",
        isSvg: true,
    },
    default: {
        icon: "payments",
        color: "slate",
        class: "bg-slate-100 dark:bg-slate-800 text-slate-600",
    }
};

let currentAlmacen = 0;
let currentCategoria = 0;
let productList = [];

let selectedCustomerIdVal = 1;
let selectedCustomerTipoDocIdVal = 1; // Default DNI/Varios
let selectedCustomerTipoDocNombreVal = "DNI";

// Elements
const cartItemsContainer = document.getElementById("cartItemsContainer");
const subtotalValueElem = document.getElementById("subtotalValue");
const totalValueElem = document.getElementById("totalValue");
const clearCartBtn = document.getElementById("clearCartBtn");
const payButton = document.getElementById("payButton");
const paymentModal = document.getElementById("paymentModal");
const modalTotalToPay = document.getElementById("modalTotalToPay");
const modalAmountPaid = document.getElementById("modalAmountPaid");
const activeMethodsContainer = document.getElementById(
    "activePaymentMethods",
);
const customerSearchInput = document.getElementById(
    "customerSearchInput",
);
const customerSearchResults = document.getElementById(
    "customerSearchResults",
);
const selectedCustomerName = document.getElementById(
    "selectedCustomerName",
);
const selectedCustomerId = document.getElementById("selectedCustomerId");

// Render Cart
function renderCart() {
    // Update Mobile Count
    const mobileCount = document.getElementById("mobileCartCount");
    const totalQty = cart.reduce((acc, item) => acc + item.quantity, 0);
    if (mobileCount) mobileCount.textContent = totalQty;

    cartItemsContainer.innerHTML = "";
    let subtotal = 0;

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = `
                    <div class="h-full flex flex-col items-center justify-center text-slate-400 opacity-50 space-y-2">
                        <span class="material-symbols-outlined text-6xl">shopping_cart</span>
                        <p class="font-medium">El carrito está vacío</p>
                    </div>
                `;
        subtotalValueElem.textContent = "S/ 0.00";
        totalValueElem.textContent = "S/ 0.00";
        return;
    }

    cart.forEach((item) => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;

        const itemHTML = `
                    <div class="flex items-center gap-4 group animate-in slide-in-from-right-4 duration-200">
                        <div class="size-12 rounded-lg bg-slate-100 dark:bg-slate-800 overflow-hidden shrink-0">
                            <img src="${item.image}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold truncate">${item.name}</p>
                            <p class="text-xs text-slate-500">S/ ${item.price.toFixed(2)} c/u</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="window.updateQuantity('${item.id}', -1)"
                                class="size-7 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                <span class="material-symbols-outlined text-sm">remove</span>
                            </button>
                            <span class="text-sm font-bold w-4 text-center">${item.quantity}</span>
                            <button onclick="window.updateQuantity('${item.id}', 1)"
                                class="size-7 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                <span class="material-symbols-outlined text-sm">add</span>
                            </button>
                        </div>
                        <div class="flex flex-col items-end gap-1">
                            <p class="text-sm font-bold w-16 text-right">S/ ${itemTotal.toFixed(2)}</p>
                            <button onclick="window.removeFromCart('${item.id}')" class="text-slate-400 hover:text-rose-500 transition-colors">
                                <span class="material-symbols-outlined text-xs">delete</span>
                            </button>
                        </div>
                    </div>
                `;
        cartItemsContainer.insertAdjacentHTML("beforeend", itemHTML);
    });

    subtotalValueElem.textContent = `S/ ${subtotal.toFixed(2)}`;
    totalValueElem.textContent = `S/ ${subtotal.toFixed(2)}`;

}

// Add Product
function addProduct(id, name, price, image) {
    const product = productList.find(p => p.id == id);
    if (!product || parseFloat(product.stock) <= 0) {
        alert(`¡Atención! No queda stock disponible de "${name}".`);
        return;
    }

    const existingItem = cart.find((item) => item.id == id);
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id,
            name,
            price: parseFloat(price),
            image,
            quantity: 1
        });
    }

    product.stock = parseFloat(product.stock) - 1;
    updateStockUI(id);
    renderCart();
}

// Update Quantity
window.updateQuantity = function (id, delta) {
    const item = cart.find((item) => item.id == id);
    const product = productList.find(p => p.id == id);

    if (item && product) {
        if (delta > 0 && parseFloat(product.stock) <= 0) {
            alert("No hay más stock disponible para este producto.");
            return;
        }

        item.quantity += delta;
        product.stock = parseFloat(product.stock) - delta;

        if (item.quantity <= 0) {
            window.removeFromCart(id, false);
        } else {
            updateStockUI(id);
            renderCart();
        }
    }
};

// Remove Item
window.removeFromCart = function (id, updateStock = true) {
    if (updateStock) {
        const item = cart.find((i) => i.id == id);
        const product = productList.find(p => p.id == id);
        if (item && product) {
            product.stock = parseFloat(product.stock) + item.quantity;
            updateStockUI(id);
        }
    }
    cart = cart.filter((i) => i.id != id);
    renderCart();
};

function updateStockUI(id) {
    const card = document.querySelector(`.product-card[data-id="${id}"]`);
    const product = productList.find(p => p.id == id);
    if (card && product) {
        const stockSpan = card.querySelector(".stock-count");
        const stockBadge = card.querySelector(".stock-badge");
        if (stockSpan) {
            const currentStock = parseFloat(product.stock);
            stockSpan.textContent = currentStock;

            // Update color if low stock
            if (currentStock <= 5) {
                stockBadge.classList.replace("bg-slate-900/80", "bg-red-500");
                stockBadge.classList.remove("backdrop-blur-sm");
            } else {
                stockBadge.classList.replace("bg-red-500", "bg-slate-900/80");
                stockBadge.classList.add("backdrop-blur-sm");
            }
        }
    }
}

// Event Listeners for Product Cards
document.querySelectorAll(".product-card").forEach((card) => {
    card.addEventListener("click", () => {
        const {
            id,
            name,
            price,
            image
        } = card.dataset;
        addProduct(parseInt(id), name, price, image);
    });
});

// Clear Cart
window.clearCart = function () {
    cart.forEach((item) => {
        const product = productList.find(p => p.id == item.id);
        if (product) {
            product.stock = parseFloat(product.stock) + item.quantity;
            updateStockUI(item.id);
        }
    });
    cart = [];
    renderCart();
};

// Modal Logic
payButton.addEventListener("click", () => {
    if (cart.length === 0) {
        alert("El carrito está vacío");
        return;
    }
    const total = parseFloat(totalValueElem.textContent.replace("S/ ", ""));
    modalTotalToPay.textContent = `S/ ${total.toFixed(2)}`;

    // Default to Efectivo if exists in DB
    const cashMethod = paymentMethodsDB.find(m => m.nombre.toLowerCase().includes('efectivo'));
    if (cashMethod) {
        activePaymentMethods = [cashMethod.id.toString()];
    } else if (paymentMethodsDB.length > 0) {
        activePaymentMethods = [paymentMethodsDB[0].id.toString()];
    } else {
        activePaymentMethods = [];
    }

    renderActivePaymentMethods();

    if (activePaymentMethods.length > 0) {
        const firstId = activePaymentMethods[0];
        const cashInp = document.getElementById(`${firstId}Input`);
        if (cashInp) cashInp.value = total.toFixed(2);
    }

    calculateBalance();

    // Auto-close mobile cart if open
    const sidebar = document.getElementById("cartSidebar");
    const overlay = document.getElementById("mobileOverlay");
    if (sidebar && sidebar.classList.contains("active")) {
        sidebar.classList.remove("active");
        overlay.classList.add("hidden");
    }

    paymentModal.classList.remove("hidden");
});

window.closePaymentModal = function () {
    paymentModal.classList.add("hidden");
};

window.renderActivePaymentMethods = function () {
    activeMethodsContainer.innerHTML = "";
    activePaymentMethods.forEach((methodId) => {
        const method = paymentMethodsDB.find(m => m.id == methodId);
        if (!method) return;

        const nameLower = method.nombre.toLowerCase();
        let configKey = 'default';
        if (nameLower.includes('efectivo')) configKey = 'cash';
        else if (nameLower.includes('tarjeta')) configKey = 'card';
        else if (nameLower.includes('yape')) configKey = 'yape';
        else if (nameLower.includes('plin')) configKey = 'plin';

        const config = paymentMethodsConfig[configKey];

        const div = document.createElement("div");
        div.className = "p-4 flex items-center justify-between gap-4 animate-in slide-in-from-top-2 duration-200";
        div.innerHTML = `
                <div class="flex items-center gap-3 min-w-[120px]">
                    <div class="size-10 rounded-full ${config.class} flex items-center justify-center">
                        ${config.isSvg ? config.icon : `<span class="material-symbols-outlined">${config.icon}</span>`}
                    </div>
                    <span class="font-semibold text-sm">${method.nombre}</span>
                </div>
                <div class="flex items-center gap-4 flex-1 justify-end">
                    <div class="relative flex-1 max-w-[150px]">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 font-bold">S/</span>
                        <input id="${methodId}Input" oninput="calculateBalance()" class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-none rounded-lg text-right font-bold focus:ring-2 focus:ring-primary" type="text" value="0.00">
                    </div>
                    <button onclick="removePaymentMethod('${methodId}')" class="text-slate-400 hover:text-rose-500 transition-colors">
                        <span class="material-symbols-outlined text-xl">delete</span>
                    </button>
                </div>
            `;
        activeMethodsContainer.appendChild(div);
    });

    // Update Buttons availability
    paymentMethodsDB.forEach(method => {
        const btn = document.getElementById(`addMethodBtn_${method.id}`);
        if (btn) {
            const isSelected = activePaymentMethods.includes(method.id.toString());
            btn.disabled = isSelected;

            if (isSelected) {
                btn.classList.add("opacity-30", "cursor-not-allowed", "grayscale");
                btn.classList.remove("hover:border-primary", "hover:text-primary");
            } else {
                btn.classList.remove("opacity-30", "cursor-not-allowed", "grayscale");
                btn.classList.add("hover:border-primary", "hover:text-primary");
            }
        }
    });
};

window.addPaymentMethod = function (methodId) {
    const methodIdStr = methodId.toString();
    if (!activePaymentMethods.includes(methodIdStr)) {
        activePaymentMethods.push(methodIdStr);
        renderActivePaymentMethods();

        // If it's the only method, assign full total
        const totalToPay = parseFloat(
            modalTotalToPay.textContent.replace("S/ ", ""),
        );
        if (activePaymentMethods.length === 1) {
            document.getElementById(`${methodIdStr}Input`).value =
                totalToPay.toFixed(2);
        }

        // Adjust other methods if needed (simple logic: if first method was full, move to new)
        const firstMethodId = activePaymentMethods[0];
        const firstInput = document.getElementById(`${firstMethodId}Input`);
        if (
            firstInput &&
            parseFloat(firstInput.value) === totalToPay &&
            activePaymentMethods.length > 1
        ) {
            firstInput.value = "0.00";
        }

        // Focus new input
        setTimeout(() => document.getElementById(`${methodIdStr}Input`).focus(), 50);
        calculateBalance();
    }
};

window.removePaymentMethod = function (type) {
    activePaymentMethods = activePaymentMethods.filter((m) => m !== type);
    renderActivePaymentMethods();
    calculateBalance();
};

window.calculateBalance = function () {
    const totalToPay = parseFloat(
        modalTotalToPay.textContent.replace("S/ ", ""),
    );

    let totalPaid = 0;
    activePaymentMethods.forEach((methodId) => {
        const inp = document.getElementById(`${methodId}Input`);
        if (inp) totalPaid += parseFloat(inp.value) || 0;
    });

    const balance = totalPaid - totalToPay;
    const cashMethod = paymentMethodsDB.find(m => m.nombre.toLowerCase().includes('efectivo'));
    const isOnlyCash =
        activePaymentMethods.length === 1 &&
        cashMethod && activePaymentMethods[0] == cashMethod.id;

    modalAmountPaid.textContent = `S/ ${totalPaid.toFixed(2)}`;

    const balanceElem = document.getElementById("modalBalance");
    const balanceTitle = balanceElem.previousElementSibling;

    if (balance >= 0) {
        balanceTitle.textContent = "Vuelto";
        const displayBalance = isOnlyCash ? balance : 0;
        balanceElem.textContent = `S/ ${displayBalance.toFixed(2)}`;
        balanceElem.classList.replace("text-orange-600", "text-green-600");
        balanceElem.parentElement.classList.replace(
            "bg-orange-50",
            "bg-green-50",
        );
    } else {
        balanceTitle.textContent = "Restante";
        balanceElem.textContent = `S/ ${Math.abs(balance).toFixed(2)}`;
        balanceElem.classList.replace("text-green-600", "text-orange-600");
        balanceElem.parentElement.classList.replace(
            "bg-green-50",
            "bg-orange-50",
        );
    }
};

// Handle Select Receipt Type
document.querySelectorAll('input[name="docType"]').forEach((radio) => {
    radio.addEventListener("change", (e) => {
        // Remove selection class from all
        document.querySelectorAll('input[name="docType"]').forEach((r) => {
            const container = r.closest("label");
            container.classList.remove("border-primary", "bg-primary/5", "border-2");
            container.classList.add("border-slate-200", "dark:border-slate-700");

            // Reset icon color
            const icon = container.querySelector(".material-symbols-outlined:first-of-type");
            if (icon) {
                icon.classList.remove("text-primary");
                icon.classList.add("text-slate-500");
            }

            const check = container.querySelector(".check-icon");
            if (check) check.remove();
        });

        // Add to selected
        const container = e.target.closest("label");
        container.classList.add("border-primary", "bg-primary/5", "border-2");
        container.classList.remove("border-slate-200", "dark:border-slate-700");

        // Active icon color
        const icon = container.querySelector(".material-symbols-outlined:first-of-type");
        if (icon) {
            icon.classList.add("text-primary");
            icon.classList.remove("text-slate-500");
        }

        // Add check icon
        const checkIcon = document.createElement("span");
        checkIcon.className = "material-symbols-outlined text-primary check-icon";
        checkIcon.textContent = "check_circle";
        container.appendChild(checkIcon);
    });
});

window.searchCustomer = function (query) {
    if (query.length < 2) {
        customerSearchResults.innerHTML = "";
        customerSearchResults.classList.add("hidden");
        return;
    }

    const formData = new FormData();
    formData.append('nombres', query);

    fetch(BASE_URL + '/clientes/buscar', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success' && res.data.length > 0) {
                customerSearchResults.innerHTML = res.data
                    .map(
                        (c) => `
                    <div onclick="selectCustomer('${c.id}', '${c.numero_documento}', '${c.nombres}', '${c.id_tipo_documento}', '${c.tipo_doc_nombre}')" class="p-3 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer border-b border-slate-100 dark:border-slate-800 last:border-0">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-[10px] font-bold px-1.5 py-0.5 bg-slate-100 dark:bg-slate-800 rounded text-slate-500 uppercase">${c.tipo_doc_nombre}</span>
                            <span class="text-xs font-bold text-slate-400">${c.numero_documento}</span>
                        </div>
                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">${c.nombres}</p>
                    </div>
                `,
                    )
                    .join("");
                customerSearchResults.classList.remove("hidden");
            } else {
                customerSearchResults.innerHTML = `
                <div class="p-3 text-sm text-slate-500 text-center italic border-none">No se encontraron clientes</div>
            `;
                customerSearchResults.classList.remove("hidden");
            }
        });
};

window.selectCustomer = function (id, documento, nombres, id_tipo_documento, tipo_doc_nombre) {
    selectedCustomerIdVal = id;
    selectedCustomerTipoDocIdVal = id_tipo_documento || 1;
    selectedCustomerTipoDocNombreVal = tipo_doc_nombre || "DNI";
    selectedCustomerName.textContent = nombres;
    selectedCustomerId.textContent = `${selectedCustomerTipoDocNombreVal}: ${documento}`;
    customerSearchInput.value = "";
    customerSearchResults.classList.add("hidden");
};

window.resetCustomerSelection = function () {
    selectedCustomerIdVal = 1;
    selectedCustomerTipoDocIdVal = 1;
    selectedCustomerTipoDocNombreVal = "DNI";
    selectedCustomerName.textContent = "Cliente Varios";
    selectedCustomerId.textContent = "DNI: 00000001";
};

// Close dropdown when clicking outside
document.addEventListener("click", (e) => {
    if (
        !customerSearchInput.contains(e.target) &&
        !customerSearchResults.contains(e.target)
    ) {
        customerSearchResults.classList.add("hidden");
    }

    const userBtn = document.getElementById("userProfileBtn");
    const userDropdown = document.getElementById("userDropdown");
    if (
        userBtn &&
        !userBtn.contains(e.target) &&
        !userDropdown.contains(e.target)
    ) {
        userDropdown.classList.add("hidden");
    }
});

// Customer Modal Logic
window.openCustomerModal = function () {
    document.getElementById('customerForm').reset();
    document.getElementById('custId').value = '0';
    document.getElementById('customerModalTitle').textContent = 'Nuevo Cliente';
    document.getElementById('customerModal').classList.remove('hidden');
    loadTiposDoc();
}

window.closeCustomerModal = function () {
    document.getElementById('customerModal').classList.add('hidden');
}

window.loadTiposDoc = function () {
    fetch(BASE_URL + '/clientes/tipos_documento')
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                const select = document.getElementById('custTipoDoc');
                select.innerHTML = '';
                res.data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id_tipodocidentidad;
                    opt.textContent = item.nombre;
                    select.appendChild(opt);
                });
            }
        });
}

window.initCustomerForm = function () {
    const form = document.getElementById('customerForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch(BASE_URL + '/clientes/guardar', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        const client = res.data;
                        selectCustomer(client.id, client.numero_documento, client.nombres, client.id_tipo_documento, client.tipo_doc_nombre);
                        closeCustomerModal();
                        alert(res.message);
                    } else {
                        alert(res.message);
                    }
                });
        });
    }
}

window.toggleUserMenu = function () {
    const dropdown = document.getElementById("userDropdown");
    dropdown.classList.toggle("hidden");
};

// Mobile Cart Toggle
// Mobile Menu Toggle
// Mobile Menu Toggle
window.toggleMobileMenu = function () {
    const menu = document.getElementById("mobileSideMenu");
    const overlay = document.getElementById("menuOverlay");
    const hamburgerBtn = document.querySelector('button[onclick="toggleMobileMenu()"] .material-symbols-outlined');

    const isActive = menu.classList.toggle("active");
    overlay.classList.toggle("hidden");

    if (hamburgerBtn) {
        hamburgerBtn.textContent = isActive ? "close" : "menu";
    }
};

window.toggleMobileCart = function () {
    const sidebar = document.getElementById("cartSidebar");
    const overlay = document.getElementById("mobileOverlay");
    sidebar.classList.toggle("active");
    overlay.classList.toggle("hidden");
};

window.loadWarehouses = function () {
    fetch(BASE_URL + '/almacen/listar')
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                const selectors = [
                    document.getElementById('posWarehouse')
                ].filter(el => el !== null);

                selectors.forEach(select => {
                    res.data.forEach((almacen, index) => {
                        const opt = document.createElement('option');
                        opt.value = almacen.id;
                        opt.textContent = almacen.nombre;
                        select.appendChild(opt);

                        // Set first warehouse as default if currentAlmacen is 0
                        if (index === 0 && currentAlmacen === 0) {
                            currentAlmacen = almacen.id;
                        }
                    });

                    // Update selector value if currentAlmacen was set
                    if (currentAlmacen !== 0) {
                        select.value = currentAlmacen;
                    }

                    select.addEventListener('change', (e) => {
                        const val = e.target.value;
                        currentAlmacen = val;
                        // Sync other selectors
                        selectors.forEach(s => { if (s !== select) s.value = val; });
                        loadProducts();
                    });
                });
            }
        });
}

window.loadCategories = function () {
    fetch(BASE_URL + '/categorias/listar')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('posCategories');
            data.forEach(cat => {
                const btn = document.createElement('button');
                btn.className = "px-6 py-2 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 font-medium text-sm transition-colors category-btn";
                btn.dataset.id = cat.id;
                btn.textContent = cat.nombre_categoria;
                btn.onclick = () => selectCategory(cat.id, btn);
                container.appendChild(btn);
            });
        });
}

window.selectCategory = function (id, btn) {
    document.querySelectorAll('.category-btn').forEach(b => {
        b.classList.remove('bg-primary', 'text-slate-900', 'font-bold', 'shadow-sm', 'active');
        b.classList.add('bg-slate-100', 'dark:bg-slate-800', 'hover:bg-slate-200', 'dark:hover:bg-slate-700', 'font-medium');
    });

    btn.classList.add('bg-primary', 'text-slate-900', 'font-bold', 'shadow-sm', 'active');
    btn.classList.remove('bg-slate-100', 'dark:bg-slate-800', 'hover:bg-slate-200', 'dark:hover:bg-slate-700', 'font-medium');

    currentCategoria = id;
    loadProducts();
}

window.loadProducts = function () {
    const url = `${BASE_URL}/productos/listar?almacen_id=${currentAlmacen}&categoria_id=${currentCategoria}`;
    fetch(url)
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                productList = res.data;
                renderProducts();
            }
        });
}

window.renderProducts = function () {
    const grid = document.getElementById('posProductGrid');
    const searchInput = document.getElementById('productSearch');
    const searchTerm = (searchInput?.value || "").toLowerCase();

    if (grid) grid.innerHTML = '';

    const filtered = productList.filter(p =>
        p.nombre_producto.toLowerCase().includes(searchTerm) ||
        p.codigo.toLowerCase().includes(searchTerm)
    );

    filtered.forEach(p => {
        const image = p.imagen_producto ? `${BASE_URL}/uploads/productos/${p.imagen_producto}` : `${BASE_URL}/uploads/productos/producto.png`;
        const stock = parseFloat(p.stock);
        const stockClass = stock <= 5 ? 'bg-red-500' : 'bg-slate-900/80 backdrop-blur-sm';

        const card = document.createElement('div');
        card.className = "product-card bg-white dark:bg-slate-900 rounded-xl p-3 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-primary transition-all cursor-pointer group";
        card.dataset.id = p.id;
        card.innerHTML = `
            <div class="aspect-square rounded-lg bg-slate-100 dark:bg-slate-800 mb-3 overflow-hidden relative">
                <div class="stock-badge absolute top-2 right-2 ${stockClass} text-white text-[10px] px-2 py-1 rounded-full">
                    <span class="stock-count">${stock}</span> stock
                </div>
                <div class="w-full h-full bg-cover bg-center group-hover:scale-105 transition-transform"
                    style="background-image: url('${image}');">
                </div>
            </div>
            <p class="text-sm font-bold truncate">${p.nombre_producto}</p>
            <p class="text-primary font-bold mt-1 text-lg">S/ ${parseFloat(p.precio_venta).toFixed(2)}</p>
        `;

        card.onclick = () => addProduct(p.id, p.nombre_producto, p.precio_venta, image);
        grid.appendChild(card);
    });
}

const searchInputs = [
    document.getElementById('productSearch')
].filter(el => el !== null);

searchInputs.forEach(input => {
    input.addEventListener('input', (e) => {
        const val = e.target.value;
        // Sync other search inputs
        searchInputs.forEach(s => { if (s !== input) s.value = val; });
        renderProducts();
    });
});

// Category "All" click
document.querySelector('.category-btn[data-id="0"]').onclick = function () {
    selectCategory(0, this);
};

window.loadPaymentMethods = function () {
    fetch(BASE_URL + '/metodo_pago/listar')
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                paymentMethodsDB = res.data;
                renderPaymentButtons();
            }
        });
}

window.renderPaymentButtons = function () {
    const container = document.getElementById('paymentMethodsContainer');
    if (!container) return;

    container.innerHTML = '';
    paymentMethodsDB.forEach(method => {
        const nameLower = method.nombre.toLowerCase();
        let configKey = 'default';
        if (nameLower.includes('efectivo')) configKey = 'cash';
        else if (nameLower.includes('tarjeta')) configKey = 'card';
        else if (nameLower.includes('yape')) configKey = 'yape';
        else if (nameLower.includes('plin')) configKey = 'plin';

        const config = paymentMethodsConfig[configKey];

        const btn = document.createElement('button');
        btn.id = `addMethodBtn_${method.id}`;
        btn.onclick = () => window.addPaymentMethod(method.id);
        btn.className = "flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 hover:border-primary hover:text-primary transition-all text-xs font-bold";
        btn.innerHTML = `
            ${config.isSvg ? `<div class="size-4">${config.icon}</div>` : `<span class="material-symbols-outlined text-sm">${config.icon}</span>`}
            ${method.nombre}
        `;
        container.appendChild(btn);
    });
}

// Simulate Payment Process
window.processPayment = function () {
    const total = totalValueElem.textContent;

    // Validación de Factura con RUC (Dinámico)
    const selectedDocRadio = document.querySelector('input[name="docType"]:checked');
    const esFactura = selectedDocRadio ? selectedDocRadio.dataset.esFactura === 'true' : false;
    const esBoleta = selectedDocRadio ? selectedDocRadio.dataset.esBoleta === 'true' : false;
    const esClienteRUC = selectedCustomerTipoDocNombreVal.toUpperCase().includes("RUC");
    const esClienteDNI = selectedCustomerTipoDocNombreVal.toUpperCase().includes("DNI");

    // Obtener total numérico
    const totalNum = parseFloat(totalValueElem.textContent.replace("S/ ", ""));

    if (esFactura && !esClienteRUC) {
        Swal.fire({
            title: 'Cliente inválido',
            text: `No se puede emitir una Factura a un cliente con ${selectedCustomerTipoDocNombreVal}. El cliente debe tener un RUC válido.`,
            icon: 'warning',
            confirmButtonColor: '#13ec49'
        });
        return;
    }

    // Validación Boleta >= 700 requiere identificación (DNI)
    if (esBoleta && totalNum >= 700) {
        if (!esClienteDNI || selectedCustomerIdVal == 1) {
            Swal.fire({
                title: 'Identificación requerida',
                text: 'Para Boletas con monto mayor o igual a S/ 700.00, es obligatorio identificar al cliente con un DNI válido.',
                icon: 'warning',
                confirmButtonColor: '#13ec49'
            });
            return;
        }
    }

    Swal.fire({
        title: '¿Confirmar Pago?',
        text: `Se procesará una venta por un total de ${total}`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#13ec49',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, confirmar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Procesando...',
                text: 'Por favor espere un momento',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Preparar datos para el backend
            const paymentMethods = [];
            activePaymentMethods.forEach(id => {
                const inp = document.getElementById(`${id}Input`);
                if (inp) {
                    paymentMethods.push({
                        id: id,
                        amount: parseFloat(inp.value) || 0
                    });
                }
            });

            const data = {
                cart: cart,
                paymentMethods: paymentMethods,
                cliente_id: selectedCustomerIdVal,
                docType_id: selectedDocRadio.value,
                almacen_id: currentAlmacen
            };

            fetch(BASE_URL + '/ventas/guardar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        const venta_id = res.venta_id;

                        Swal.fire({
                            title: '¡Venta Exitosa!',
                            text: res.message,
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#13ec49',
                            confirmButtonText: '<span class="flex items-center gap-2"><span class="material-symbols-outlined">print</span> Imprimir Ticket</span>',
                            cancelButtonText: 'Cerrar',
                        }).then((r) => {
                            if (r.isConfirmed) {
                                window.open(`${BASE_URL}/ventas/ticket/${venta_id}`, '_blank');
                            }

                            // Siempre limpiar y cerrar al finalizar el mensaje de éxito
                            window.clearCart();
                            window.closePaymentModal();
                            window.resetCustomerSelection();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: res.message,
                            icon: 'error',
                            confirmButtonColor: '#13ec49'
                        });
                    }
                })
                .catch(err => {
                    Swal.fire({
                        title: 'Error Crítico',
                        text: 'No se pudo procesar la venta. Verifique su conexión.',
                        icon: 'error',
                        confirmButtonColor: '#13ec49'
                    });
                });
        }
    });
};

// Initial Load
document.addEventListener('DOMContentLoaded', () => {
    window.loadWarehouses();
    window.loadCategories();
    window.loadProducts();
    window.loadPaymentMethods();
    window.resetCustomerSelection(); // Ensure default customer is selected on load
    window.initCustomerForm();
    window.renderCart();
});