@extends('layouts.master')
@section('title', 'Compras')
    @section('header-title','Listado de compras')
@section('header-content')
    <div class="row">
        <div class="col-3">
            <button class="btn btn-primary btn-lg" id="new" data-target="#add" data-toggle="modal">Nueva</button>
        </div>
        <div class="col-9">
            <div class="col-md-3 col-sm-6 col-12 float-sm-right">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="far fa-flag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Visitas</span>
                        <span class="info-box-number">{{$view->views}}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
        <table id="purchasesTable" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>FECHA</th>
                <th>TOTAL</th>
                <th>OPERACIONES</th>
            </tr>
            </thead>
            <tbody>
            @foreach($purchases as $purchase)
                <tr>
                <td>{{$purchase->idpurchase}}</td>
                <td>{{$purchase->date}}</td>
                <td>{{$purchase->total}}</td>
                <td >
                    <a class="btn btn-info"
                       data-products="{{$purchase->products}}"
                       data-target="#show" data-toggle="modal">
                        Ver
                    </a>
                    {!! Form::open(['route' => ['purchases.destroy',$purchase->idpurchase],'method'=>'DELETE','style'=>'display: inline']) !!}
                    {{Form::token()}}
                    <button onclick="return confirm('¿Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                    {!! Form::close() !!}
                </td>
            @endforeach
                </tr>
            </tbody>
        </table>
        <div id="show" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detalle</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <table id="tableShow" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>PRODUCTO</th>
                                <th>CANTIDAD</th>
                                <th>COSTO</th>
                            </tr>
                            <tbody>

                            </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="add" class="modal fade" role="dialog">
            {!! Form::open(['route' => ['purchases.store'],'method'=>'POST']) !!}
            {{Form::token()}}
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Nueva compra</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <label for="date">Fecha</label>
                                <input type="date" name="date" class="form-control" placeholder="Enter date">
                            </div>
                        </div>
                        <br>
                        <label for="Detail">Detalle</label>

                        <div class="row">
                            <div class="col-4">
                                <label for="productid">Producto</label>
                                <select name="productid" id="productid" class="form-control">
                                    @foreach($products as $product)
                                        <option value="{{$product->idproduct}}">
                                            {{$product->productname}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="quantity">Cantidad</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter Quantity">
                            </div>
                            <div class="col-3">
                                <label for="Price">Costo(Bs)</label>
                                <input type="number" id="cost" name="cost" class="form-control" min=".5" step=".5" placeholder="Enter Price">
                            </div>
                            <div class="col-1">
                                <label for="add">Agregar</label>
                                <input type="button" id="add" onclick="addRow()" class="btn btn-primary" value="+">
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-12">
                                <table id="details" class="table table-bordered table-hover">
                                    <tr>
                                        <th>NRO</th>
                                        <th>PRODUCTO</th>
                                        <th>CANTIDAD</th>
                                        <th>COSTO</th>
                                        <th>SUBTOTAL</th>
                                        <th>REMOVE</th>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Total</th>
                                            <th id=total><h4 id="total">Bs/ 0.00</h4></th>
                                        </tr>
                                        </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" id="btn" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    @push('scripts')
        {{--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>--}}
        {{--{!! JsValidator::formRequest('App\Http\Requests\UserRequest', '#userForm'); !!}--}}
        <script>
            $('#show').on('show.bs.modal',function(event){
                var button=$(event.relatedTarget);
                var products=button.data('products');
                var modal=$(this)
                modal.find('.modal-body #tableShow >tbody').empty();
                products.forEach(element=>{
                    var name=element["productname"];
                    console.log(element);
                    var quantity=element["pivot"]["quantity"];
                    var cost=element["pivot"]["cost"];
                    var row='<tr class="selected" id="row">' +
                        '<td><input type="hidden" name="products[]" value="'+name+'">'+name + '</td>' +
                        '<td><input type="hidden" name="quantities[]" value="'+quantity+'">'+quantity+'</td>' +
                        '<td><input type="hidden" name="costs[]" value="'+cost+'">'+cost+'</td>' +
                        '</tr>';
                    modal.find('.modal-body #tableShow').append(row);
                });
            });

            $(function () {
                $("#purchasesTable").DataTable();
            });

            var cont=0;
            var subtotal=[];
            var total=0;
            function addRow() {
                var quantity=$("#quantity").val();
                var cost=$("#cost").val();
                var product=$("#productid option:selected").text();
                var productid=$("#productid").val();
                if ( (cost>0) && (quantity>0 )) {
                    subtotal[cont]=(quantity*cost);
                    total=total+subtotal[cont];
                    var fila='<tr class="selected" id="row'+cont+'">' +
                        '<td>'+cont+1+'</td>'+
                        '<td><input type="hidden" name="products[]" value="'+productid+'">'+product+'</td>' +
                        '<td><input type="hidden" name="quantities[]" value="'+quantity+'">'+quantity+'</td>' +
                        '<td><input type="hidden" name="costs[]" value="'+cost+'">'+cost+'</td>' +
                        '<td>'+subtotal[cont]+'</td>' +
                        '<td id="option"><button type="button" class="btn btn-warning" onclick="remove('+cont+');">X</button></td>' +
                        '</tr>';
                    cont++;
                    clean();
                    $("#total").html("Bs/"+total);
                    $('#details').append(fila);
                }
                else
                {
                    alert("Error al ingresar el detalle de venta, revise los datos");
                }
            }

            function clean(){
                $("#quantity").val("");
                $("#cost").val("");
            }
            function remove(index){
                total=total-subtotal[index];
                $("#total").html("Bs/ " +total+".00");
                $("#row"+index).remove();
            }

            var inputs=document.querySelectorAll('input:not([type="submit"])');
            var flag=true;

            var submit = document.getElementById('btn');
            for (var i=0;i<inputs.length;i++){
                inputs[i].addEventListener('keyup',function () {
                    validate(this);
                });
            }

            submit.addEventListener('click', function() {
                for (var i = 0; i < inputs.length; i++) {
                    validate(inputs[i]);
                }
            });

            function validate(input){
                if(input.name==='vaccinationname') {
                    if (input.value.match(/^[a-zA-Z0-9\s]*$/)) {
                        input.className = 'form-control is-valid';
                        flag = true;
                    } else {
                        flag = false;
                        input.className = 'form-control is-invalid';
                    }
                }
                validateSubmit();
            }
            function validateSubmit(){
                if(flag===false) {
                    submit.style.display='none';
                }else{
                    submit.style.display='inline';
                }
            }

        </script>
    @endpush
@endsection