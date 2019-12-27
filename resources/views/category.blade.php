<section>
    <div class="card">
        <div class="card-header">
            <h1>Data Kategori</h1>
        </div>
    <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-sm-12 col-xl-4">
                    <input type="text" class="form-control" name="categoryName" id="categoryName" placeholder="Nama Kategori Baru">
                    <small class="text-danger hide" id="valid_categoryName"></small>
                </div>
                <div class="col-md-4 col-sm-12 col-xl-4">
                    <input type="text" class="form-control" name="categoryDescription" id="categoryDescription" placeholder="Deskripsi Kategori">
                    <small class="text-danger hide" id="valid_categoryDescription"></small>
                </div>
                <div class="col-md-4 col-md-12 col-xl-4">
                    <button type="button" class="btn btn-success btn-block" onclick="insert()" id="tambah"><i class="fas fa-plus"></i> Tambah</button>
                    <button type="button" class="btn btn-warning" onclick="updateData()" id="update"><i class="fas fa-edit"></i> Update</button>
                    <button type="button" class="btn btn-danger" onclick="cancel()" id="cancel"><i class="fas fa-times"></i> Cancel</button>
                </div>
            </div>
        <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-hover nowrap" style="width:100%" id="tableData">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
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
        $('#update').hide();
        $('#cancel').hide();
    });

    function btnToEdit(){
        $('#update').show();
        $('#cancel').show();
        $('#tambah').hide();
    }

    function cancel(){
        $('#update').hide();
        $('#cancel').hide();
        $('#tambah').show();
        $('#categoryName').val('');
        $('#categoryDescription').val('');
    }

    function loadTable(){
        $('#tableData').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: 'category/load',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'categoryId', searchable: false, orderable: true, className: 'text-center' },
                { name: 'categoryName'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function insert(){
        var categoryName = $('#categoryName').val();
        var categoryDescription  = $('#categoryDescription').val();
        $.ajax({
            url : '{{ url("admin/category/insert") }}',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : {
                'categoryName' : categoryName,
                'categoryDescription' : categoryDescription
            },
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#tableData').DataTable().ajax.reload(null,false);
                    $('small').text('')
                }else if(res.status == 401){
                    $.each(res.errors,function (i,val) {  
                      $('#valid_'+i).removeClass('hide');
                      $('#valid_'+i).text(val)
                    });
                }else{
                    alert(res.result);
                }
            }
        })
    }

    function edit(id){
        btnToEdit();
        $.ajax({
            url : '{{ url("admin/category/edit") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            method : 'GET',
            success:function(res){
                $('#categoryName').val(res.categoryName);
                $('#categoryDescription').val(res.categoryDescription);
                $('#update').attr('onclick','updateData('+res.categoryId+')');
            }
        })
    }

    function updateData(id){
        var categoryName = $('#categoryName').val();
        var categoryDescription = $('#categoryDescription').val();
        $.ajax({
            url : '{{ url("admin/category/update") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : {
                'categoryName' : categoryName,
                'categoryDescription' : categoryDescription
            },
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#tableData').DataTable().ajax.reload(null,false);
                    $('small').text('')
                    cancel();
                }else if(res.status == 401){
                    $.each(res.errors,function (i,val) {  
                      $('#valid_'+i).removeClass('hide');
                      $('#valid_'+i).text(val)
                    });
                }else{
                    alert(res.result);
                }
            }
        })
    }

    function deleteData(id){
        $.ajax({
            url : '{{ url("admin/category/delete") }}/'+id,
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