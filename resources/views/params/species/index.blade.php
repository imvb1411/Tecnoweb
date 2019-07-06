@extends('layouts.master')
@section('title', 'Especies')
    @section('header-title','Listado de especies de animales')
@section('header-content')
    <button class="btn btn-primary btn-lg" id="new" data-toggle="modal" data-target="#edit">Nuevo</button>
@endsection
@section('content')
        <table id="specieTable" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>OPERACIONES</th>
            </tr>
            </thead>
            <tbody>
            @foreach($species as $specie)
                <tr>
                <td>{{$specie->idspecie}}</td>
                <td>{{$specie->speciename}}</td>
                <td >
                        <a class="btn btn-info"
                           data-idspecie="{{$specie->idspecie}}"
                           data-speciename="{{$specie->speciename}}"
                           data-toggle="modal" id="btnedit" data-target="#edit">
                            Edit
                        </a>
                        {!! Form::open(['route' => ['species.destroy',$specie->idspecie],'method'=>'DELETE','style'=>'display: inline']) !!}
                        {{Form::token()}}
                        <button onclick="return confirm('¿Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                        {!! Form::close() !!}
                </td>
            @endforeach
                </tr>
            </tbody>
        </table>

    <div id="edit" class="modal fade" role="dialog">
        {!! Form::open(['route' => ['species.update','0'],'method'=>'PUT','id'=>"specieForm"]) !!}
        {{Form::token()}}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="htitle">Editar especie</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <input type="hidden" name="idspecie" id="idspecie" class="form-control">
                        <div class="row">
                            <div class="col-6">
                                <label for="name">NOMBRE</label>
                                <input type="text" name="speciename" id="speciename" class="form-control" placeholder="Ingrese el nombre" required>
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
                $("#specieTable").DataTable();
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
                var form= document.getElementById('specieForm');
                form.action='{{route('species.store')}}';
                form.method='post';
                var inputMethod=document.getElementsByName('_method');

                for(var i=0;i<inputMethod.length;i++){
                    if(inputMethod[i].value==='PUT'){
                        _iMethod=inputMethod[i];
                        inputMethod[i].value='POST';
                    }
                }
                document.getElementById('htitle').innerText='Nueva especie';
                document.getElementById('btn').innerText='Guardar'

            });
            $('#btnedit').click(function () {
                var form= document.getElementById('categoryForm');
                form.action='{{route('species.update',0)}}';
                form.method='post';
                if(_iMethod.toString().length>0){
                    _iMethod.value='PUT';
                }
                document.getElementById('htitle').innerText='Editar especie';
                document.getElementById('btn').innerText='Editar'
            });
            $('#edit').on('show.bs.modal',function(event){
                var button = $(event.relatedTarget);
                var idspecie = button.data('idspecie');
                var speciename = button.data('speciename');
                var modal = $(this);
                modal.find('.modal-body #idspecie').val(idspecie);
                modal.find('.modal-body #speciename').val(speciename)
            })
        </script>
    @endpush
@endsection