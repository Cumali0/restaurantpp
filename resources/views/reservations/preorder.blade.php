<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ön Sipariş - Rezervasyon</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f0f4f8; color:#222; margin:0; padding:20px; }
        h2,h3 { text-align:center; color:#1a202c; margin-top:10px; }
        .category-bar { display:flex; justify-content:center; flex-wrap:wrap; gap:12px; padding:10px 0; margin:0 auto 20px auto; max-width:900px; overflow-x:auto; scrollbar-width:none; position:sticky; top:0; z-index:100; background:#f0f4f8; }
        .category-bar::-webkit-scrollbar { display:none; }
        .category-btn { padding:8px 20px; border:none; border-radius:25px; background: linear-gradient(135deg,#6a11cb,#2575fc); color:white; cursor:pointer; font-weight:bold; transition:0.3s; flex:0 0 auto; }
        .category-btn.active { background: linear-gradient(135deg,#ff6f61,#ffb347); }
        .category-btn:hover { opacity:0.85; transform:translateY(-2px); }
        .main-content { display:flex; gap:30px; justify-content:center; align-items:flex-start; flex-wrap:wrap; }
        #product-container { display:grid; grid-template-columns:repeat(4,220px); gap:20px; justify-content:center; max-height:80vh; overflow-y:auto; scrollbar-width:none; }
        #product-container::-webkit-scrollbar { display:none; }
        .product-item { background:#fff8e1; border-radius:12px; text-align:center; box-shadow:0 6px 15px rgba(0,0,0,0.1); overflow:hidden; cursor:pointer; transition:transform 0.3s, box-shadow 0.3s; display:flex; flex-direction:column; align-items:center; }
        .product-item:hover { transform:translateY(-5px); box-shadow:0 12px 30px rgba(0,0,0,0.2); }
        .product-item img { width:100%; height:140px; object-fit:cover; transition: transform 0.3s; }
        .product-item:hover img { transform: scale(1.08); }
        .product-info { padding:12px; width:100%; display:flex; flex-direction:column; align-items:center; }
        .product-info strong { font-size:16px; margin-bottom:5px; color:#333; }
        .product-info .price { font-weight:bold; margin-bottom:10px; color:#1a202c; }
        .product-quantity { width:50px; padding:4px; text-align:center; margin-bottom:10px; border-radius:5px; border:1px solid #ccc; }
        .add-to-cart { padding:6px 12px; border:none; border-radius:5px; background:#28a745; color:white; cursor:pointer; font-weight:bold; transition: background 0.2s; }
        .add-to-cart:hover { background:#e65c50; }
        #cart-container { width:350px; position:sticky; top:20px; max-height:80vh; overflow-y:auto; scrollbar-width:none; background:#fff; padding:15px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); }
        #cart-container::-webkit-scrollbar { display:none; }
        #cart-items { list-style:none; padding:0; margin:10px 0; }
        #cart-items li { background:#f7f7f7; border-radius:6px; padding:8px 12px; margin-bottom:5px; display:flex; justify-content:space-between; align-items:center; font-size:14px; color:#333; }
        .cart-controls button { margin:0 4px; padding:4px 8px; border:none; border-radius:4px; cursor:pointer; font-weight:bold; }
        .cart-controls .increase { background:#28a745; color:white; }
        .cart-controls .decrease { background:#ffc107; color:white; }
        .cart-controls .remove { background: #dc3545; color: white; }
        #cart-total { display:block; text-align:right; font-weight:bold; margin-bottom:5px; font-size:16px; color:#1a202c; }
        #cart-summary { text-align:right; font-size:14px; color:#555; margin-bottom:10px; }
        #finalize-cart, #empty-cart { display:block; margin:5px auto; padding:10px 20px; font-size:16px; font-weight:bold; color:white; background:#007bff; border:none; border-radius:6px; cursor:pointer; transition:background 0.2s, transform 0.2s; }
        #finalize-cart:hover, #empty-cart:hover { background:#0056b3; transform:translateY(-2px); }
        #order-modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; }
        #order-modal .modal-content { background:#fff; padding:20px; border-radius:8px; width:90%; max-width:400px; text-align:center; }
        #order-modal button { margin:10px; padding:8px 16px; }
        @media(max-width:1100px) { #product-container { grid-template-columns:repeat(3,220px); } }
        @media(max-width:900px){ #product-container { grid-template-columns:repeat(2,220px); } #cart-container { width:90%; margin-top:20px; position:static; } }
        @media(max-width:600px){ #product-container { grid-template-columns:1fr; } }
    </style>
</head>
<body>

<h2>Ön Sipariş - Rezervasyon #{{ $reservation->id }}</h2>
<input type="hidden" id="reservation_token" value="{{ $reservation->preorder_token }}">

<div id="filter-container" class="category-bar"></div>

<div class="main-content">
    <div id="product-container"></div>

    <div id="cart-container">
        <h3>Sepet</h3>
        <ul id="cart-items"></ul>
        <p id="cart-summary">0 ürün, 0₺</p>
        <p>Toplam: <span id="cart-total">0</span>₺</p>

        <div style="text-align:center; margin-bottom:10px;">
            <label><input type="radio" name="payment" value="Banka" checked> Banka Kartı</label>
            <label><input type="radio" name="payment" value="Kredi"> Kredi Kartı</label>
        </div>

        <button id="empty-cart">Sepeti Boşalt</button>
        <button type="button" id="finalize-cart">Siparişi Tamamla</button>
    </div>
</div>

<div id="order-modal">
    <div class="modal-content">
        <h3>Sipariş Özeti</h3>
        <div id="modal-items"></div>
        <p id="modal-total"></p>
        <p id="modal-payment"></p>
        <button id="confirm-order">Onayla</button>
        <button id="cancel-order">İptal</button>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const productContainer = document.getElementById('product-container');
        const filterContainer = document.getElementById('filter-container');
        const cartItems = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        const cartSummary = document.getElementById('cart-summary');
        const reservationToken = document.getElementById('reservation_token').value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // --- SESSION STORAGE TOKEN SAKLAMA ---
        if (!sessionStorage.getItem('orderToken')) {
            sessionStorage.setItem('orderToken', reservationToken);
        }

        let cart = [];

        // --- Backend'den cart yükle ---
        async function loadCart() {
            const tokenToUse = sessionStorage.getItem('orderToken') || reservationToken;
            const res = await fetch(`/preorder/get-cart/${tokenToUse}`);
            const data = await res.json();
            cart = data.items.map(i => ({
                cart_item_id: i.id,
                id: i.product.id,
                name: i.product.name,
                price: parseFloat(i.price),
                quantity: parseInt(i.quantity)
            }));
            updateCartDisplay();
        }

        // --- Sayfa kapanınca veya başka sayfaya gidince token sil ---
        window.addEventListener('pagehide', function (e) {
            // sayfa back/forward cache’den geliyorsa silme
            if (e.persisted) return;

            // navigation API ile reload kontrolü
            const nav = performance.getEntriesByType("navigation")[0];
            if(nav && nav.type === "reload") return; // yenilemede silme

            const tokenToDelete = sessionStorage.getItem('orderToken');
            if(tokenToDelete){
                const blob = new Blob([JSON.stringify({ _token: csrfToken })], { type: 'application/json' });
                navigator.sendBeacon(`/preorder/invalidate-token/${tokenToDelete}`, blob);
                sessionStorage.removeItem('orderToken');
            }
        });

        // --- Ürünleri render et ---
        const categories = @json($categories);
        let products = [];
        categories.forEach(c => products.push(...c.products.map(p => ({ ...p, category: c.name }))));
        const categoryNames = ['Tüm Ürün', ...categories.map(c => c.name)];

        categoryNames.forEach(cat => {
            const btn = document.createElement('button');
            btn.textContent = cat;
            btn.className = 'category-btn' + (cat === 'Tüm Ürün' ? ' active' : '');
            btn.addEventListener('click', () => {
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                renderProducts(cat);
            });
            filterContainer.appendChild(btn);
        });

        function renderProducts(category = 'Tüm Ürün') {
            productContainer.innerHTML = '';
            products.forEach(p => {
                if (category !== 'Tüm Ürün' && p.category !== category) return;
                const div = document.createElement('div');
                div.className = 'product-item';
                div.innerHTML = `
<img src="{{ asset('storage') }}/${p.img}" alt="${p.name}">
<div class="product-info">
    <strong>${p.name}</strong>
    <span class="price">${p.price}</span>
    <div style="display:flex; gap:5px; align-items:center;">
        <button class="decrease">-</button>
        <input type="number" min="1" value="1" class="product-quantity" data-id="${p.id}" style="width:40px; text-align:center;"/>
        <button class="increase">+</button>
    </div>
    <button class="add-to-cart" data-id="${p.id}">Sepete Ekle</button>
</div>
`;
                productContainer.appendChild(div);
            });
        }

        // --- Product container delegasyonu ---
        productContainer.addEventListener('click', (e) => {
            const btn = e.target;
            const input = btn.closest('.product-item')?.querySelector('.product-quantity');
            if (!input) return;

            if (btn.classList.contains('increase')) input.value = parseInt(input.value)+1;
            else if (btn.classList.contains('decrease')) input.value = Math.max(1, parseInt(input.value)-1);
            else if (btn.classList.contains('add-to-cart')) addToCart(btn.dataset.id, parseInt(input.value));
        });

        // --- Cart güncelle ---
        function updateCartDisplay() {
            cartItems.innerHTML = '';
            cart.forEach((i, idx) => {
                const li = document.createElement('li');
                li.innerHTML = `
${i.name}
<div class="cart-controls">
    <button class="decrease" data-idx="${idx}">-</button>
    ${i.quantity}
    <button class="increase" data-idx="${idx}">+</button>
    - ${(i.price*i.quantity).toFixed(2)}₺
    <button class="remove" data-idx="${idx}">X</button>
</div>
`;
                cartItems.appendChild(li);
            });
            cartTotal.textContent = cart.reduce((sum,i)=>sum+i.price*i.quantity,0).toFixed(2);
            cartSummary.textContent = `${cart.length} ürün, ${cartTotal.textContent}₺`;
        }

        // --- Cart delegasyonu ---
        cartItems.addEventListener('click', async (e)=>{
            const btn = e.target;
            const idx = btn.dataset.idx;
            if(idx===undefined) return;

            if(btn.classList.contains('increase')) {
                cart[idx].quantity++;
                await updateBackendCart(cart[idx].cart_item_id, cart[idx].quantity);
            }
            else if(btn.classList.contains('decrease')) {
                cart[idx].quantity=Math.max(1,cart[idx].quantity-1);
                await updateBackendCart(cart[idx].cart_item_id, cart[idx].quantity);
            }
            else if(btn.classList.contains('remove')) {
                await removeFromBackendCart(cart[idx].cart_item_id);
                cart.splice(idx,1);
            }

            updateCartDisplay();
        });

        // --- Backend ile senkron ---
        async function addToCart(productId, quantity){
            const tokenToUse = sessionStorage.getItem('orderToken') || reservationToken;
            const res = await fetch(`/preorder/add/${tokenToUse}`,{
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},
                body:JSON.stringify({product_id:productId, quantity})
            });
            const data = await res.json();
            if(data.success){
                cart = data.cart.items.map(i=>({
                    cart_item_id:i.id,
                    id:i.product.id,
                    name:i.product.name,
                    price:parseFloat(i.price),
                    quantity:parseInt(i.quantity)
                }));
                updateCartDisplay();
            }
        }

        async function updateBackendCart(cart_item_id, quantity){
            const tokenToUse = sessionStorage.getItem('orderToken') || reservationToken;
            await fetch(`/preorder/update-item/${tokenToUse}`,{
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},
                body:JSON.stringify({cart_item_id, quantity})
            });
        }

        async function removeFromBackendCart(cart_item_id){
            const tokenToUse = sessionStorage.getItem('orderToken') || reservationToken;
            await fetch(`/preorder/remove/${tokenToUse}`,{
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},
                body:JSON.stringify({cart_item_id})
            });
        }

        document.getElementById('empty-cart').onclick=async()=>{
            const tokenToUse = sessionStorage.getItem('orderToken') || reservationToken;
            await fetch(`/preorder/empty/${tokenToUse}`,{method:'POST', headers:{'X-CSRF-TOKEN':csrfToken}});
            cart=[];
            updateCartDisplay();
        };

        // --- Modal işlemleri ---
        const finalizeBtn = document.getElementById('finalize-cart');
        const orderModal = document.getElementById('order-modal');
        const modalItems = document.getElementById('modal-items');
        const modalTotal = document.getElementById('modal-total');
        const modalPayment = document.getElementById('modal-payment');
        const confirmOrder = document.getElementById('confirm-order');
        const cancelOrder = document.getElementById('cancel-order');

        finalizeBtn.addEventListener('click', ()=>{
            if(cart.length===0) return alert('Sepet boş!');
            modalItems.innerHTML = cart.map(i=>`<p>${i.name} x${i.quantity} = ${(i.price*i.quantity).toFixed(2)}₺</p>`).join('');
            modalTotal.textContent = `Toplam: ${cartTotal.textContent}₺`;
            modalPayment.textContent = `Ödeme Türü: ${document.querySelector('input[name="payment"]:checked').value}`;
            orderModal.style.display='flex';
        });

        cancelOrder.addEventListener('click', ()=>orderModal.style.display='none');

        confirmOrder.addEventListener('click', async ()=>{
            const tokenToUse = sessionStorage.getItem('orderToken') || reservationToken;
            const payment = document.querySelector('input[name="payment"]:checked').value;
            const res = await fetch(`/preorder/finalize/${tokenToUse}`,{
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},
                body:JSON.stringify({payment})
            });
            const data = await res.json();
            if(data.success){
                alert(data.message);
                orderModal.style.display='none';
                cart=[];
                updateCartDisplay();


                sessionStorage.removeItem('orderToken'); // sipariş tamamlandığında token sil
                window.location.href=data.redirect_url;
            } else alert(data.message||'Hata oluştu!');
        });

        renderProducts();
        loadCart();
        window.addEventListener("beforeunload", function (event) {
            const reservationId = document.getElementById('reservation_id').value;
            if (!reservationId) return;

            // Sayfa reload ise tokeni silme
            if (performance.getEntriesByType("navigation")[0].type === "reload") return;

            // Tokeni silmek için beacon gönder
            const formData = new FormData();
            formData.append('reservation_id', reservationId);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            navigator.sendBeacon(`/reservation/${reservationId}/abandon-cart`, formData);

            // Tarayıcıya kendi mesajımızı vermek istiyoruz

        });
    });
</script>




</body>
</html>
