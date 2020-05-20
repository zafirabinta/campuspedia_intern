<!DOCTYPE html>
<html>
    <head>
        <title>Intern Campuspedia</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css"/>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>        
        
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

<!-- Latest compiled JavaScript -->
    </head>
    <body>
        <div class="container">
            <br>
            <h3 align="center">DATA ANAK MAGANG</h3>
            <br>
            <div align="right">
                <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Add</button>
            </div>
            <br>
            <table id="intern_table" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Lama Bekerja</th>
                        <th>Tugas yang Dikerjakan</th>
                        <th>Kendala</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div id="interndataModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="interndata_form">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Data</h4>
                        </div>
                        <div class="modal-body">
                            {{csrf_field()}}
                            <span id="form-output"></span>
                            <div class="form-group">
                                <label>Tanggal Bekerja</label>
                                <input type="date" name="tanggal_kerja" id="tanggal_kerja" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Jam Masuk</label>
                                <input type="time" name="jam_masuk" id="jam_masuk" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Jam Pulang</label>
                                <input type="time" name="jam_pulang" id="jam_pulang" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Tugas yang Dikerjakan</label>
                                <input type="text" name="tugas" id="tugas" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Kendala</label>
                                <input type="text" name="kendala" id="kendala" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="button_action" id="button_action" value="insert">
                            <input type="submit" name="submit" id="action" value="Add" class="btn btn-info">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#intern_table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ route('ajaxdata.getdata') }}",
                    "columns":[
                        { "data": "tanggal" },
                        { "data": "jumlah_jam" },
                        { "data": "tugas" },
                        { "data": "kendala" }
                    ]
                });

                $('#add_data').click(function(){
                    $('#interndataModal').modal('show');
                    $('#interndata_form')[0].reset();
                    $('#form_output').html('');
                    $('#button_action').val('insert');
                    $('#action').val('Add');
                });

                $('#interndata_form').on('submit', function(event){
                    event.preventDefault();
                    var form_data = $(this).serialize();
                    $.ajax({
                        url: "{{route('ajaxdata.postdata')}}",
                        method: "POST",
                        data:form_data,
                        dataType: "json",
                        success:function(data){
                            if(data.error.length > 0){
                                var error_html = '';
                                for(var count = 0; count < data.error.length; count++){
                                    error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                                }
                                $('#form_output').html(error_html);
                            }
                            else{
                                $('#form_output').html(data).success;
                                $('#interndata_form')[0].reset();
                                $('#action').val('Add');
                                $('.modal-title').html('Add Data');
                                $('#button_action').val('insert');
                                $('#intern_table').DataTable().ajax.reload();
                            }
                        }
                    })
                });
            });
        </script>
    
</html>
