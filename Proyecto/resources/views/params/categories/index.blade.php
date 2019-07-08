@extends('layouts.master')
@section('title', 'Categorias')
    @section('header-title','Listado de categorias de productos')
@section('header-content')
    <div class="row">
        <div class="col-3">
            <button class="btn btn-primary btn-lg" id="new" data-toggle="modal" data-target="#edit">Nuevo</button>
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
        <table id="categoryTable" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>OPERACIONES</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                <td>{{$category->idproductcategory}}</td>
                <td>{{$category->categoryname}}</td>
                <td >
                        <a class="btn btn-info"
                           data-idproductcategory="{{$category->idproductcategory}}"
                           data-categoryname="{{$category->categoryname}}"
                           data-toggle="modal" id="btnedit" data-target="#edit">
                            Edit
                        </a>
                        {!! Form::open(['route' => ['categories.destroy',$category->idproductcategory],'method'=>'DELETE','style'=>'display: inline']) !!}
                        {{Form::token()}}
                        <button onclick="return confirm('¿Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                        {!! Form::close() !!}
                </td>
            @endforeach
                </tr>
            </tbody>
        </table>

    <div id="edit" class="modal fade" role="dialog">
        {!! Form::open(['route' => ['categories.update','0'],'method'=>'PUT','id'=>"categoryForm"]) !!}
        {{Form::token()}}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="htitle">Editar Categoria</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <input type="hidden" name="idproductcategory" id="idproductcategory" class="form-control">
                        <div class="row">
                            <div class="col-6">
                                <label for="name">NOMBRE</label>
                                <input type="text" name="categoryname" id="categoryname" class="form-control" placeholder="Ingrese el nombre" required>
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
                $("#categoryTable").DataTable();
            });
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
                var form= document.getElementById('categoryForm');
                form.action='{{route('categories.store')}}';
                form.method='post';
                var inputMethod=document.getElementsByName('_method');

                for(var i=0;i<inputMethod.length;i++){
                    if(inputMethod[i].value==='PUT'){
                        _iMethod=inputMethod[i];
                        inputMethod[i].value='POST';
                    }
                }
                document.getElementById('htitle').innerText='Nueva categoria';
                document.getElementById('btn').innerText='Guardar'
            });

            $('#btnedit').click(function () {
                var form= document.getElementById('categoryForm');
                form.action='{{route('categories.update',0)}}';
                form.method='post';
                if(_iMethod.toString().length>0){
                    _iMethod.value='PUT';
                }
                document.getElementById('htitle').innerText='Editar categoria';
                document.getElementById('btn').innerText='Editar'
            });

            $('#edit').on('show.bs.modal',function(event){
                var button = $(event.relatedTarget);
                var idproductcategory = button.data('idproductcategory');
                var categoryname = button.data('categoryname');
                var modal = $(this);
                modal.find('.modal-body #idproductcategory').val(idproductcategory);
                modal.find('.modal-body #categoryname').val(categoryname);
            })
        </script>
    @endpush
@endsection