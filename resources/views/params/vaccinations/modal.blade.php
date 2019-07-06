<div id="edit" class="modal fade" role="dialog">
    {!! Form::open(['route' => ['vaccinations.update','0'],'method'=>'PUT','id'=>"vaccinationForm"]) !!}
    {{Form::token()}}
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="htitle">Editar Vacuna</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="idvaccination" id="idvaccination" class="form-control">
                <div class="row">
                    <div class="col-6">
                        <label for="name">NOMBRE</label>
                        <input type="text" name="vaccinationname" id="vaccinationname" class="form-control" placeholder="Ingrese el nombre" required>
                    </div>
                    <div class="col-6">
                        <label for="name">PRECIO</label>
                        <input type="number" name="price" id="price" class="form-control" placeholder="0.00" required>
                    </div>
                </div>
                <br>
                <label for="tablePlans">PLAN</label>
                <div id="create">
                <div class="row">
                    <div class="col-4">
                        <label for="quantity">DOSIS</label>
                        <input type="number" name="dosis" id="dosis" class="form-control">
                    </div>
                    <div class="col-3">
                        <label for="Price">#DIAS</label>
                        <input type="number" id="days" name="days" class="form-control">
                    </div>
                    <div class="col-1">
                        <label for="add">AGREGAR</label>
                        <button type="button" id="add" onclick="addRow()" class="btn btn-primary">+</button>
                    </div>
                </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12">
                        <table id="tablePlans" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>DOSIS</th>
                                    <th>#DIA</th>
                                    <th>QUITAR</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btn">Editar</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<script>
    var cont=0;
    function addRow() {
        var days=$("#days").val();
        var dosis=$("#dosis").val();
        if ( (dosis>0) && (days>0 )) {
            var fila='<tr class="selected" id="row'+cont+'">' +
                '<td><input type="hidden" name="dosis[]" value="'+dosis+'">'+dosis+'</td>' +
                '<td><input type="hidden" name="days[]" value="'+days+'">'+days+'</td>' +
                '<td id="option"><button type="button" class="btn btn-warning" onclick="remove('+cont+');">X</button></td>' +
                '</tr>';
            cont++;
            clean();
            $('#tablePlans').append(fila);
        }
        else
        {
            alert("Error al ingresar el detalle de venta, revise los datos");
        }
    }

    function clean(){
        $("#days").val("");
        $("#dosis").val("");
    }
    function remove(index){
        $("#row"+index).remove();
    }
</script>