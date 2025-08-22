@extends('admin.layouts.app')

@section('title','Ürün Yönetimi')

@section('content')
    <div class="admin-product-container">

        {{-- Filtreleme --}}
        <form method="GET" action="{{ route('admin.products.index') }}" class="mb-3 d-flex gap-2 flex-wrap">
            <input type="text" name="name" value="{{ request('name') }}" placeholder="Ürün Adı" class="form-control" style="max-width:200px;">
            <select name="category" class="form-control" style="max-width:150px;">
                <option value="">Kategori (Tümü)</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
            <input type="number" step="1" name="min_price" value="{{ request('min_price') }}" placeholder="Min Fiyat" class="form-control" style="max-width:120px;">
            <input type="number" step="1" name="max_price" value="{{ request('max_price') }}" placeholder="Max Fiyat" class="form-control" style="max-width:120px;">
            <button type="submit" class="btn btn-primary btn-sm">Filtrele</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">Temizle</a>
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($mode == 'index')
            <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
                <h1 style="text-align:center;">🍽️ Ürün Yönetimi</h1>
                <a href="{{ route('admin.products.index',['mode'=>'create']) }}" class="btn btn-success">+ Yeni Ürün Ekle</a>
            </div>

            @if($products->isEmpty())
                <div class="alert alert-info text-center">Henüz ürün eklenmemiş.</div>
            @else
                <div class="d-flex flex-wrap gap-3">
                    @foreach($products as $product)
                        <div class="card" style="width: 18rem;">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">Resim Yok</div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description ?? 'Açıklama yok.' }}</p>
                                <p>
                                    <strong>Kategori:</strong> {{ $product->category->name ?? '-' }}<br>
                                    <strong>Fiyat:</strong> {{ number_format($product->price,2) }} ₺<br>
                                    <strong>Durum:</strong>
                                    @if($product->active) <span class="badge bg-success">Aktif</span>
                                    @else <span class="badge bg-secondary">Pasif</span>
                                    @endif
                                </p>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('admin.products.index',['mode'=>'edit','product'=>$product->id]) }}" class="btn btn-warning btn-sm">Düzenle</a>
                                <form action="{{ route('admin.products.destroy',$product) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Sil</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @elseif($mode == 'create' || $mode == 'edit')
            @php $isEdit = $mode == 'edit'; @endphp

        <div class="mt-3">{{ $products->links('pagination::bootstrap-5') }}</div>
    </div>

    {{-- Modal (başta gizli) --}}
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="productForm" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Ürün</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="productId" name="productId">
                    <div class="mb-3">
                        <label>Ürün Adı</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Açıklama</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Fiyat</label>
                        <input type="number" name="price" step="0.01" min="0" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Seçiniz</option>
                            @foreach($categories as $id=>$name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Resim</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary saveBtn">Kaydet</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                const productModal = new bootstrap.Modal(document.getElementById('productModal'));
                const form = document.getElementById('productForm');
                const addNewBtn = document.getElementById('addNewBtn');

                // Yeni Ürün
                addNewBtn.addEventListener('click', ()=>{
                    form.reset();
                    form.dataset.method = 'POST';
                    form.action = "{{ route('admin.products.store') }}";
                    document.querySelector('#productModal .modal-title').textContent = "Yeni Ürün";
                    productModal.show();
                });

                // Düzenle
                document.querySelectorAll('.editBtn').forEach(btn=>{
                    btn.addEventListener('click', ()=>{
                        const card = btn.closest('.menu-card');
                        const id = card.dataset.id;
                        fetch(`/admin/products/${id}/edit`)
                            .then(res=>res.json())
                            .then(data=>{
                                form.reset();
                                form.dataset.method = 'PUT';
                                form.action = `/admin/products/${id}`;
                                document.querySelector('#productModal .modal-title').textContent = "Ürün Düzenle";
                                form.productId.value = id;
                                form.name.value = data.name;
                                form.description.value = data.description;
                                form.price.value = data.price;
                                form.category_id.value = data.category_id;
                                productModal.show();
                            });
                    });
                });

                // Submit
                form.addEventListener('submit', function(e){
                    e.preventDefault();
                    const action = form.action;
                    const method = form.dataset.method || 'POST';
                    const formData = new FormData(form);
                    if(method==='PUT') formData.append('_method','PUT');

                    fetch(action,{
                        method:'POST',
                        body: formData,
                        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}
                    }).then(res=>res.json())
                        .then(data=>{
                            if(data.success) location.reload();
                            else alert(data.message || 'Hata oluştu.');
                        });
                });

                // Sil
                document.querySelectorAll('.deleteBtn').forEach(btn=>{
                    btn.addEventListener('click', ()=>{
                        if(!confirm('Silmek istediğinize emin misiniz?')) return;
                        const card = btn.closest('.menu-card');
                        const id = card.dataset.id;

                        fetch(`/admin/products/${id}`, {
                            method:'POST',
                            body: JSON.stringify({_method:'DELETE'}),
                            headers:{
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type':'application/json'
                            }
                        }).then(res=>res.json())
                            .then(data=>{
                                if(data.success) location.reload();
                            });
                    });
                });
            });
        </script>
    @endpush
@endsection
