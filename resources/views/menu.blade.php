<section>
    <div class="card">
        <div class="card-header">
            <h1>{{ $title }}</h1>
        </div>
    <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xl-12">
                    <a href="javascript:void(0)" class="btn btn-success right" id=btnAddMenu><i class="fas fa-plus"></i> Tambah</a>
                </div>
            </div>
        <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-hover nowrap" style="width:100%" id="tableData">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Menu</th>
                            <th>Parent</th>
                            <th>URL</th>
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
                        <div class="col-md-6 col-sm-12 col-xl-6">
                            <div class="form-group">
                                <label for="menuName">Menu Name</label>
                                <input type="text" class="form-control" id="menuName" name="menuName">
                                <small class="text-danger" id="valid_menuName"></small>
                            </div>
                            <div class="form-group">
                                <label for="menuUrl">URL</label>
                                <input type="text" class="form-control" id="menuUrl" name="menuUrl">
                                <small class="text-danger" id="valid_menuUrl"></small>
                            </div>
                            <div class="form-group">
                                <label for="menuParent">Menu Parent</label>
                                <select name="menuParent" id="menuParent" class="form-control">
                                    <option value="0"><b>is Parent</b></option>
                                    @foreach ($parent as $p)
                                        <option value="{{ $p->menuId }}">{{ $p->menuName }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger" id="valid_menuParent"></small>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xl-6">
                            <div class="form-group">
                                <label for="menuActiveParent">Menu Active Parent</label>
                                <input type="text" class="form-control" id="menuActiveParent" name="menuActiveParent">
                                <small class="text-danger" id="valid_menuActiveParent"></small>
                            </div>
                            <div class="form-group">
                                <label for="menuName">Menu Active Url</label>
                                <input type="text" class="form-control" id="menuActiveUrl" name="menuActiveUrl">
                                <small class="text-danger" id="valid_menuActiveUrl"></small>
                            </div>
                            <div class="form-group">
                                <label for="menuName">Menu Icon</label>
                                <input type="text" class="form-control" id="menuIcon" name="menuIcon">
                                <small class="text-danger" id="valid_menuIcon"></small>
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

        $('#btnAddMenu').click(function(){
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
                url: 'menu/load',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'menuId', searchable: false, orderable: true, className: 'text-center' },
                { name: 'menuName'},
                { name: 'menuParent'},
                { name: 'menuUrl'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function tambahData(){
        var formData = $('#formData').serialize();
        $.ajax({
            url : '{{ url("admin/menu/insert") }}',
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
            url : '{{ url("admin/menu/edit") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            method : 'GET',
            success:function(res){
               $('#menuName').val(res.menuName);
               $('#menuUrl').val(res.menuUrl);
               $('#menuParent').val(res.menuParent).trigger('change');
               $('#menuActiveParent').val(res.menuActiveParent);
               $('#menuActiveUrl').val(res.menuActiveUrl);
               $('#menuIcon').val(res.menuIcon);
               $('#update').attr('onclick','updateData('+res.menuId+')');
            }
        })
    }

    function updateData(id){
        var formData = $('#formData').serialize();
        $.ajax({
            url : '{{ url("admin/menu/update") }}/'+id,
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
            url : '{{ url("admin/menu/delete") }}/'+id,
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