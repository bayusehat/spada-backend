<section>
    <div class="card">
        <div class="card-header">
            <h1>{{ $title }}</h1>
        </div>
    <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xl-12">
                    <a href="javascript:void(0)" class="btn btn-success right" id=btnAddAdmin><i class="fas fa-plus"></i> Tambah</a>
                </div>
            </div>
        <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-hover nowrap" style="width:100%" id="tableData">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Posisi</th>
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
                                <label for="adminName">Admin Name</label>
                                <input type="text" class="form-control" id="adminName" name="adminName">
                                <small class="text-danger" id="valid_adminName"></small>
                            </div>
                            <div class="form-group">
                                <label for="adminUsername">Username</label>
                                <input type="text" class="form-control" id="adminUsername" name="adminUsername">
                                <small class="text-danger" id="valid_adminUsername"></small>
                            </div>
                            <div class="form-group">
                                <label for="adminPassword">Password</label>
                                <input type="password" class="form-control" id="adminPassword" name="adminPassword">
                                <small class="text-danger" id="valid_adminPassword"></small>
                            </div>
                            <div class="form-group">
                                <label for="roleId">Role</label>
                                <select name="roleId" id="roleId" class="form-control">
                                    <option value="">-- Choose Role --</option>
                                    @foreach ($role as $r)
                                        <option value="{{ $r->roleId }}">{{ $r->roleName }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger" id="valid_roleId"></small>
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

        $('#btnAddAdmin').click(function(){
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
                url: 'admin/load',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'adminId', searchable: false, orderable: true, className: 'text-center' },
                { name: 'adminName'},
                { name: 'adminUsername'},
                { name: 'roleName'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function tambahData(){
        var formData = $('#formData').serialize();
        $.ajax({
            url : '{{ url("admin/admin/insert") }}',
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
            url : '{{ url("admin/admin/edit") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            method : 'GET',
            success:function(res){
               $('#adminName').val(res.adminName);
               $('#adminUsername').val(res.adminUsername);
               $('#roleId').val(res.roleId).trigger('change');
               $('#adminPassword').attr('disabled',true);
               $('#update').attr('onclick','updateData('+res.adminId+')');
            }
        })
    }

    function updateData(id){
        var formData = $('#formData').serialize();
        $.ajax({
            url : '{{ url("admin/admin/update") }}/'+id,
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
            url : '{{ url("admin/admin/delete") }}/'+id,
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