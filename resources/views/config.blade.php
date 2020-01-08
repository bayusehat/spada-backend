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
            <form action="{{ url('admin/config/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xl-12">
                        <div class="form-group">
                            <label for="configWebName">Nama Web</label>
                            <input type="text" class="form-control" name="configWebName" id="configWebName" value="{{ $config->configWebName }}">
                            @error('configWebName') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="configTitle">Judul</label>
                            <input type="text" class="form-control" name="configTitle" id="configTitle" value="{{ $config->configTitle }}">
                            @error('configTitle') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="configOfficeHour">Jam Kerja</label>
                            <input type="text" class="form-control" name="configOfficeHour" id="configOfficeHour" value="{{ $config->configOfficeHour }}">
                            @error('configOfficeHour') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="configPhone">Telepon</label>
                            <input type="text" class="form-control" name="configPhone" id="configPhone" value="{{ $config->configPhone }}">
                            @error('configPhone') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="configAddress">Alamat</label>
                            <input type="text" class="form-control" name="configAddress" id="configAddress" value="{{ $config->configAddress }}">
                            @error('configAddress') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="configEmail">E-mail</label>
                            <input type="text" class="form-control" name="configEmail" id="configEmail" value="{{ $config->configEmail }}">
                            @error('configEmail') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="configDescription">Deskripsi</label>
                            <input type="text" class="form-control" name="configDescription" id="configDescription" value="{{ $config->configDescription }}">
                            @error('configDescription') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xl-6">
                                <button type="submit" class="btn btn-warning btn-block"><i class="fas fa-plus"></i> Update</button>
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