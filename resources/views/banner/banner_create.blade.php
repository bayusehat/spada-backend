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
            <form action="{{ url('admin/banner/insert') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <div class="form-group">
                            <label for="bannerTitle">Judul</label>
                            <input type="text" class="form-control" name="bannerTitle" id="bannerTitle">
                            @error('bannerTitle') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="bannerImage">Gambar</label>
                            <input type="file" class="form-control" name="bannerImage" id="bannerImage">
                            @error('bannerImage') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="bannerDescription">Deskripsi</label>
                            <input type="text" class="form-control" name="bannerDescription" id="bannerDescription">
                            @error('bannerDescription') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xl-6">
                                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-plus"></i> Simpan</button>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xl-6">
                                <a href="{{ url('admin/banner') }}" class="btn btn-danger btn-block"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>