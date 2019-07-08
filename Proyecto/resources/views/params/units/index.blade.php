@extends('layouts.master')
@section('title', 'Unidades de medida')
    @section('header-title','Listado de unidades')
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
        <table id="unitTable" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>ABREVIACION</th>
                <th>OPERACIONES</th>
            </tr>
            </thead>
            <tbody>
            @foreach($units as $unit)
                <tr>
                <td>{{$unit->idproductunit}}</td>
                <td>{{$unit->unitname}}</td>
                <td>{{$unit->unitabbreviation}}</td>
                <td >
                        <a class="btn btn-info"
                           data-idproductunit="{{$unit->idproductunit}}"
                           data-unitname="{{$unit->unitname}}"
                           data-unitabbreviation="{{$unit->unitabbreviation}}"
                           data-toggle="modal" id="btnedit" data-target="#edit" onclick="editClic()">
                            Edit
                        </a>
                        {!! Form::open(['route' => ['units.destroy',$unit->idproductunit],'method'=>'DELETE','style'=>'display: inline']) !!}
                        {{Form::token()}}
                        <button onclick="return confirm('¿Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                        {!! Form::close() !!}
                </td>
            @endforeach
                </tr>
            </tbody>
        </table>

    <div id="edit" class="modal fade" role="dialog">
        {!! Form::open(['route' => ['units.update','0'],'method'=>'PUT','id'=>"unitForm"]) !!}
        {{Form::token()}}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="htitle">Editar unidad</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <input type="hidden" name="idproductunit" id="idproductunit" class="form-control">
                        <div class="row">
                            <div class="col-6">
                                <label for="name">NOMBRE</label>
                                <input type="text" name="unitname" id="unitname" class="form-control" placeholder="Ingrese el nombre" required>
                            </div>
                            <div class="col-3">
                                <label for="name">ABREVIACION</label>
                                <input type="text" name="unitabbreviation" id="unitabbreviation" class="form-control" placeholder="Ingrese una abreviacion" required>
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
                $("#unitTable").DataTable();
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
                if(input.value.match(/^[a-zA-Z0-9\s]+\.*$/)){
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
            var _iMethod=null;

            $('#new').click(function () {
                var form= document.getElementById('unitForm');
                form.action='{{route('units.store')}}';
                form.method='post';
                var inputMethod=document.getElementsByName('_method');

                for(var i=0;i<inputMethod.length;i++){
                    if(inputMethod[i].value==='PUT'){
                        _iMethod=inputMethod[i];
                        inputMethod[i].value='POST';
                    }
                }
                document.getElementById('htitle').innerText='Nueva unidad';
                document.getElementById('btn').innerText='Guardar'

            });

            function editClic(){
                var form= document.getElementById('unitForm');
                form.action='{{route('units.update',0)}}';
                form.method='post';
                if(_iMethod!=null){
                    _iMethod.value='PUT';
                }
                document.getElementById('htitle').innerText='Editar unidad';
                document.getElementById('btn').innerText='Editar'
            }

            $('#edit').on('show.bs.modal',function(event){
                var button=$(event.relatedTarget);
                var idproductunit=button.data('idproductunit');
                var unitname=button.data('unitname');
                var unitabbreviation=button.data('unitabbreviation');
                var modal=$(this);
                modal.find('.modal-body #idproductunit').val(idproductunit);
                modal.find('.modal-body #unitname').val(unitname);
                modal.find('.modal-body #unitabbreviation').val(unitabbreviation);
            })
        </script>
    @endpush
@endsection