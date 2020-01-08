<section>
    <div class="card">
        <div class="card-header">
            <h1>{{ $title }}</h1>
        </div>
    <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xl-12">
                    <a href="javascript:void(0)" class="btn btn-success right" id="btnAddService"><i class="fas fa-plus"></i> Tambah</a>
                </div>
            </div>
        <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-hover nowrap" style="width:100%" id="tableData">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<form method="POST" id="formData">
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modalTitle"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xl-12">
                            <div class="form-group">
                                <label for="serviceName">Nama Service</label>
                                <input type="text" class="form-control" id="serviceName" name="serviceName">
                                <small class="text-danger" id="valid_serviceName"></small>
                            </div>
                            <div class="form-group">
                                <label for="serviceImage">Icon Service</label>
                                <input type="text" class="form-control" id="serviceImage" name="serviceImage">
                                <small class="text-danger" id="valid_serviceImage"></small>
                            </div>
                            <div class="form-group">
                                <label for="serviceDescription">Deskripsi Service</label>
                                <input type="text" class="form-control" id="serviceDescription" name="serviceDescription">
                                <small class="text-danger" id="valid_serviceDescription"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="tambahData()" id="tambah"><i class="fas fa-plus"></i> Simpan</button>
                    <button type="button" class="btn btn-warning" onclick="updateData()" id="update"><i class="fas fa-edit"></i> Update</button>
                    <button type="button" class="btn btn-danger" onclick="batal()" id="cancel"><i class="fas fa-times"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(function(){
        loadTable();

        $('#btnAddService').click(function(){
            $('#tambah').show();
            $('#update').hide();
            $('#cancel').hide();
            $('#formData').trigger('reset');
            $('#myModal').modal('show');
        })
    });

    function btnToEdit(){
        $('#update').show();
        $('#cancel').show();
        $('#tambah').hide();
        $('#myModal').modal('show');
    }

    function batal(){
        $('#update').hide();
        $('#cancel').hide();
        $('#tambah').show();
        $('#formData').trigger('reset');
    }

    function loadTable(){
        $('#tableData').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: 'service/load',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'serviceId', searchable: false, orderable: true, className: 'text-center' },
                { name: 'serviceName'},
                { name: 'serviceDescription'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function tambahData(){
        var formData = $('#formData').serialize();
        $.ajax({
            url : '{{ url("admin/service/insert") }}',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : formData,
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#tableData').DataTable().ajax.reload(null,false);
                    $('#myModal').modal('hide');
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

    function show(id){
        btnToEdit();
        $.ajax({
            url : '{{ url("admin/service/edit") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            method : 'GET',
            success:function(res){
               $('#serviceName').val(res.serviceName);
               $('#serviceImage').val(res.serviceImage);
               $('#serviceDescription').val(res.serviceDescription);
               $('#update').attr('onclick','updateData('+res.serviceId+')');
            }
        })
    }

    function updateData(id){
        var formData = $('#formData').serialize();
        $.ajax({
            url : '{{ url("admin/service/update") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data :formData,
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#tableData').DataTable().ajax.reload(null,false);
                    $('#myModal').modal('hide');
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

    function deleteData(id){
        $.ajax({
            url : '{{ url("admin/service/delete") }}/'+id,
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