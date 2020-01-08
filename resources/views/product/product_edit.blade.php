<section>
    <div class="card">
        <div class="card-header">
            <h1>{{ $title }}</h1>
        </div>
    <hr>
        <div class="card-body">
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Gagal!</strong> {{ Session::get('error') }}
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Sukses!</strong> {{ Session::get('success') }}
            </div>
            @endif
            <form action="{{ url('admin/product/update/'.$product->productId) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <div class="form-group">
                            <label for="productName">Nama Produk</label>
                            <input type="text" class="form-control" name="productName" id="productName" value="{{ $product->productName }}">
                            @error('productName') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="categoryId">Kategori</label>
                            <select name="categoryId" id="categoryId" class="form-control">
                                <option value="">-- Pilih Kategori Produk --</option>
                                @foreach ($category as $c)
                                    <option value="{{ $c->categoryId }}" 
                                    @if ($product->categoryId == $c->categoryId)
                                        {{ 'selected' }}
                                    @else
                                        {{ '' }}
                                    @endif>{{ $c->categoryName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="productImage">Gambar Produk</label>
                            <input type="file" class="form-control" name="productImage" id="productImage">
                            @error('productImage') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="productDescription">Deskripsi</label>
                            @error('productDescription') <small class="text-danger">{{ $message }}</small> @enderror
                            <textarea name="productDescription" id="productDescription" cols="30" rows="10" class="form-control">{{ $product->productDescription }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xl-6">
                                <button type="submit" class="btn btn-warning btn-block"><i class="fas fa-edit"></i> Update</button>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xl-6">
                                <a href="{{ url('admin/product') }}" class="btn btn-danger btn-block"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>