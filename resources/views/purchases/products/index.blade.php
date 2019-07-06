@extends('layouts.master')
@section('title', 'Productos')
    @section('header-title','Listado de Productos')
@section('header-content')
    <button class="btn btn-primary btn-lg" id="new" data-toggle="modal" data-target="#edit">Nuevo</button>
@endsection
@section('content')
        <table id="productTable" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>UNIDAD</th>
                <th>STOCK</th>
                <th>COSTO</th>
                <th>PRECIO</th>
                <th>CATEGORIA</th>
                <th>OPERACIONES</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                <td>{{$product->idproduct}}</td>
                <td>{{$product->productname}}</td>
                <td>{{$product->unit->unitabbreviation}}</td>
                <td>{{$product->currentstock}}</td>
                <td>{{$product->cost}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->category->categoryname}}</td>
                <td >
                        <a class="btn btn-info"
                           data-idproduct="{{$product->idproduct}}"
                           data-productname="{{$product->productname}}"
                           data-unitid="{{$product->unitid}}"
                           data-cost="{{$product->cost}}"
                           data-price="{{$product->price}}"
                           data-categoryid="{{$product->categoryid}}"
                           data-toggle="modal" id="btnedit" data-target="#edit">
                            Edit
                        </a>
                        {!! Form::open(['route' => ['products.destroy',$product->idproduct],'method'=>'DELETE','style'=>'display: inline']) !!}
                        {{Form::token()}}
                        <button onclick="return confirm('¿Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                        {!! Form::close() !!}
                </td>
            @endforeach
                </tr>
            </tbody>
        </table>

    <div id="edit" class="modal fade" role="dialog">
        {!! Form::open(['route' => ['products.update','0'],'method'=>'PUT','id'=>"productForm"]) !!}
        {{Form::token()}}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="htitle">Editar Producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <input type="hidden" name="idproduct" id="idproduct" class="form-control">
                        <div class="row">
                            <div class="col-8">
                                <label for="productname">NOMBRE</label>
                                <input type="text" name="productname" id="productname" class="form-control" placeholder="Ingrese el nombre" required>
                            </div>
                            <div class="col-4">
                                <label for="unitid">UNIDAD</label>
                                <select id="unitid" name="unitid" class="form-control"  required>
                                    @foreach($units as $unit)
                                    <option value="{{$unit->idproductunit}}">{{$unit->unitname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <label for="name">COSTO</label>
                                <input type="number" name="cost" id="cost" class="form-control" placeholder="0.00" required>
                            </div>
                            <div class="col-3">
                                <label for="name">PRECIO</label>
                                <input type="number" name="price" id="price" class="form-control" placeholder="0.00" required>
                            </div>
                            <div class="col-6">
                                <label for="categoryid">CATEGORIA</label>
                                <select name="categoryid" class="form-control" id="categoryid" required>
                                    @foreach($categories as $category)
                                        <option value="{{$category->idproductcategory}}">{{$category->categoryname}}</option>
                                    @endforeach
                                </select>
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
    @push('scripts')
        {{--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>--}}
        {{--{!! JsValidator::formRequest('App\Http\Requests\UserRequest', '#userForm'); !!}--}}
        <script>
            $(function () {
                $("#productTable").DataTable();
            });
            var inputs=document.querySelectorAll('input:not([type="submit"])');
            var selects=document.querySelectorAll('select');
            console.log(selects);
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
                if(input.value.match(/^[a-zA-Z0-9\s]*$/)){
                    input.className='form-control is-valid';
                    flag=true;
                }else{
                    flag=false;
                    input.className='form-control is-invalid';
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
            var _iMethod='';
            $('#new').click(function () {
                var form= document.getElementById('productForm');
                form.action='{{route('products.store')}}';
                form.method='post';
                var inputMethod=document.getElementsByName('_method');

                for(var i=0;i<inputMethod.length;i++){
                    if(inputMethod[i].value==='PUT'){
                        _iMethod=inputMethod[i];
                        inputMethod[i].value='POST';
                    }
                }
                document.getElementById('htitle').innerText='Nuevo Producto';
                document.getElementById('btn').innerText='Guardar'

            });
            $('#btnedit').click(function () {
                var form= document.getElementById('categoryForm');
                form.action='{{route('categories.update',0)}}';
                form.method='post';
                if(_iMethod.toString().length>0){
                    _iMethod.value='PUT';
                }
                document.getElementById('htitle').innerText='Editar producto';
                document.getElementById('btn').innerText='Editar'
            });
            $('#edit').on('show.bs.modal',function(event){
                if(_iMethod==='PUT' || _iMethod.toString().length===0) {
                    var button = $(event.relatedTarget);
                    var idproduct = button.data('idproduct');
                    var productname = button.data('productname');
                    var unitid = button.data('unitid');
                    var cost = button.data('cost');
                    var price = button.data('price');
                    var categoryid = button.data('categoryid');
                    var modal = $(this);
                    modal.find('.modal-body #idproduct').val(idproduct);
                    modal.find('.modal-body #productname').val(productname);
                    modal.find('.modal-body #unitid').val(unitid);
                    modal.find('.modal-body #cost').val(cost);
                    modal.find('.modal-body #price').val(price);
                    modal.find('.modal-body #categoryid').val(categoryid);
                }
            })
        </script>
    @endpush
@endsection