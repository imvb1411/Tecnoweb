@extends('layouts.master')
@section('title', 'Razas')
    @section('header-title','Listado de razas de animales')
@section('header-content')
    <button class="btn btn-primary btn-lg" id="new" data-toggle="modal" data-target="#edit">Nuevo</button>
@endsection
@section('content')
        <table id="raceTable" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>ESPECIE</th>
                <th>OPERACIONES</th>
            </tr>
            </thead>
            <tbody>
            @foreach($races as $race)
                <tr>
                <td>{{$race->idrace}}</td>
                <td>{{$race->racename}}</td>
                <td>{{$race->specie->speciename}}</td>
                <td >
                        <a class="btn btn-info"
                           data-idrace="{{$race->idrace}}"
                           data-racename="{{$race->racename}}"
                           data-specieid="{{$race->specieid}}"
                           data-toggle="modal" id="btnedit" data-target="#edit">
                            Edit
                        </a>
                        {!! Form::open(['route' => ['races.destroy',$race->idrace],'method'=>'DELETE','style'=>'display: inline']) !!}
                        {{Form::token()}}
                        <button onclick="return confirm('¿Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                        {!! Form::close() !!}
                </td>
            @endforeach
                </tr>
            </tbody>
        </table>

    <div id="edit" class="modal fade" role="dialog">
        {!! Form::open(['route' => ['races.update','0'],'method'=>'PUT','id'=>"raceForm"]) !!}
        {{Form::token()}}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="htitle">Editar raza</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <input type="hidden" name="idrace" id="idrace" class="form-control">
                        <div class="row">
                            <div class="col-6">
                                <label for="name">NOMBRE</label>
                                <input type="text" name="racename" id="racename" class="form-control" placeholder="Ingrese el nombre" required>
                            </div>
                            <div class="col-6">
                                <label for="name">ESPECIE</label>
                                <select class="form-control" name="specieid" id="specieid" required>
                                    @foreach($species as $specie)
                                        <option value="{{$specie->idspecie}}">{{$specie->speciename}}</option>
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
                $("#raceTable").DataTable();
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
            var _iMethod=null;
            var action=1;
            $('#new').click(function () {
                action=1;
                var form= document.getElementById('raceForm');
                form.action='{{route('races.store')}}';
                form.method='post';
                var inputMethod=document.getElementsByName('_method');

                for(var i=0;i<inputMethod.length;i++){
                    if(inputMethod[i].value==='PUT'){
                        _iMethod=inputMethod[i];
                        inputMethod[i].value='POST';
                    }
                }
                document.getElementById('htitle').innerText='Nueva raza';
                document.getElementById('btn').innerText='Guardar'

            });

            $('#btnedit').click(function () {
                action=2;
                var form= document.getElementById('raceForm');
                form.action='{{route('races.update',0)}}';
                form.method='post';
                if(_iMethod!=null) {
                    _iMethod.value = 'PUT';
                }
                document.getElementById('htitle').innerText='Editar raza';
                document.getElementById('btn').innerText='Editar'
            });

            $('#edit').on('show.bs.modal',function(event){
                var modal = $(this);
                if(action===2) {
                    var button = $(event.relatedTarget);
                    var idrace = button.data('idrace');
                    var racename = button.data('racename');
                    console.log(racename);
                    var specieid = button.data('specieid');
                    modal.find('.modal-body #idrace').val(idrace);
                    modal.find('.modal-body #racename').val(racename);
                    modal.find('.modal-body #specieid').val(specieid);
                }else{
                    modal.find('.modal-body #idrace').val('');
                    modal.find('.modal-body #racename').val('');
                }
            })
        </script>
    @endpush
@endsection