<section>
    <div class="card">
        <div class="card-header">
            <h1>{{ $title }}</h1>
        </div>
    <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xl-12">
                    <a href="{{ url('admin/banner/create') }}" class="btn btn-success right" id=btnAddAdmin><i class="fas fa-plus"></i> Tambah</a>
                </div>
            </div>
        <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-hover nowrap" style="width:100%" id="tableData">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    $(function(){
        loadTable();
    });

    function loadTable(){
        $('#tableData').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: 'banner/load',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'bannerId', searchable: false, orderable: true, className: 'text-center' },
                { name: 'bannerImage'},
                { name: 'bannerName'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function deleteData(id){
        $.ajax({
            url : '{{ url("admin/banner/delete") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            method : 'GET',
            success:function(res){
                if(res.status == 200){
                    $('#tableData').DataTable().ajax.reload(null,false);
                }else{
                    alert(res.result);
                }
            }
        })
    }
</script>