@extends('layouts.master')
@section('title', 'Historiales')
    @section('header-title','Listado de historiales')
@section('header-content')
    <button class="btn btn-primary btn-lg" id="new" data-toggle="modal" data-target="#edit">Nuevo</button>
@endsection
@section('content')
    <div class="form-group">
        <table id="userTable" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>PACIENTE</th>
                <th>DUEÑO</th>
                <th>OPERACIONES</th>
            </tr>
            </thead>
            <tbody>
            @foreach($histories as $history)
                <tr>
                <td>{{$history->idhistory}}</td>
                <td>{{$history->pet->petname}}</td>
                <td>{{$history->pet->owner->firstname}} {{$history->pet->owner->lastname}}</td>
                <td >
                    <a class="btn btn-success"
                       data-idhistory="{{$history->idhistory}}"
                       data-petname="{{$history->pet->petname}}"
                       data-toggle="modal" id="btneditH" data-target="#history">
                        H. Clinico
                    </a>
                    <a class="btn btn-warning"
                       data-idhistory="{{$history->idhistory}}"
                       data-petname="{{$history->pet->petname}}"
                       data-toggle="modal" id="btneditV" data-target="#historyVaccination">
                        H. Vacunas
                    </a>
                    <a class="btn btn-info"
                       data-idhistory="{{$history->idhistory}}"
                       data-ownerid="{{$history->pet->owner->idperson}}"
                       data-petname="{{$history->pet->petname}}"
                       data-birthdate="{{$history->pet->birthdate}}"
                       data-color="{{$history->pet->color}}"
                       data-toggle="modal" id="btnedit" data-target="#edit">
                        Editar
                    </a>
                </td>
            @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    <div id="edit" class="modal fade" role="dialog">
        {!! Form::open(['route' => ['histories.update','0'],'method'=>'PUT','id'=>"historyForm"]) !!}
        {{Form::token()}}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="htitle">Editar historial</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <input type="hidden" name="idhistory" id="idhistory" class="form-control">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">DUEÑO</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="radio" class="form-check-input" id="rnewOwner">
                                        <label for="rnewOwner">Nuevo cliente</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="radio" class="form-check-input" id="rOwner">
                                        <label for="rOwner">Cliente existente</label>
                                    </div>
                                </div>
                                <div id="newOwner">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="name">NOMBRES</label>
                                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Ingrese los nombres">
                                        </div>
                                        <div class="col-4">
                                            <label for="packing">APELLIDOS</label>
                                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Ingrese los apellidos">
                                        </div>
                                        <div class="col-3">
                                            <label for="packing">TELEFONO</label>
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Ingrese un teléfono">
                                        </div>
                                    </div>
                                </div>
                                <div id="owner">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="ownerid">DUEÑO</label>
                                            <select name="ownerid" id="ownerid" class="form-control">
                                                @foreach($clients as $client)
                                                    <option value="{{$client->idperson}}">{{$client->firstname}} {{$client->lastname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">MASCOTA</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="name">NOMBRE</label>
                                        <input type="text" name="petname" id="petname" class="form-control" placeholder="Ingrese el nombre" required>
                                    </div>
                                    <div class="col-4">
                                        <label for="raceid">RAZA</label>
                                        <select name="raceid" id="raceid" class="form-control">
                                            @foreach($races as $race)
                                                <option value="{{$race->idrace}}">{{$race->racename}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="packing">FECHA NAC.</label>
                                        <input type="date" name="birthdate" id="birthdate" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="packing">COLOR</label>
                                        <input type="text" name="color" id="color" class="form-control" placeholder="Ingrese el color">
                                    </div>
                                </div>
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

    <div id="historyVaccination" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="htitle">Historial de vacunas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idhistory" id="idhistory" class="form-control">
                    <a data-toggle="modal" class="btn btn-info" data-target="#addVaccination">+Vacuna</a>
                    <br>
                    <br>
                        <table id="vaccinationTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>VACUNA</th>
                                    <th>DOSIS</th>
                                    <th>FECHA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hvaccinations as $h)
                                    <tr>
                                        <td>{{$h->vaccination->vaccinationname}}</td>
                                        <td>{{$h->dosisnumber}}</td>
                                        <td>{{$h->createdat}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn">Editar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="addVaccination" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="htitle">Editar vacuna</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idhistory" id="idhistory" class="form-control">
                    <div class="row">
                        <div class="col-6">
                            <label for="vaccinationid">Vacuna</label>
                            <select name="vaccinationid" id="vaccinationid" class="form-control">
                            @foreach($vaccinations as $vaccination)
                                    <option value="{{$vaccination->idvaccination}}">{{$vaccination->vaccinationname}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="dosisnumber">#Dosis</label>
                            <input type="number" name="dosisnumber" id="dosisnumber" class="form-control" placeholder="Ingrese el # de dosis">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn">Editar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="history" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="htitle">Historial clinico</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idhistory" id="idhistory" class="form-control">
                    <a data-toggle="modal" class="btn btn-info" data-target="#addConsultation">+Consulta</a>
                    <br>
                    <br>
                    <table id="historyTable" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>FECHA</th>
                            <th>DETALLE</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($hvaccinations as $h)
                            <tr>
                                <td>{{$h->vaccination->vaccinationname}}</td>
                                <td>{{$h->dosisnumber}}</td>
                                <td>{{$h->createdat}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn">Editar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="addConsultation" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="htitle">Editar consultas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idhistory" id="idhistory" class="form-control">
                    <div class="row">
                        <div class="col-6">
                            <label for="vaccinationid">Vacuna</label>
                            <select name="vaccinationid" id="vaccinationid" class="form-control">
                                @foreach($vaccinations as $vaccination)
                                    <option value="{{$vaccination->idvaccination}}">{{$vaccination->vaccinationname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="dosisnumber">#Dosis</label>
                            <input type="number" name="dosisnumber" id="dosisnumber" class="form-control" placeholder="Ingrese el # de dosis">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn">Editar</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        {{--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>--}}
        {{--{!! JsValidator::formRequest('App\Http\Requests\UserRequest', '#userForm'); !!}--}}
        <script>
            $(function () {
                $("#userTable").DataTable();
                $("#vaccinationTable").DataTable();

            });
            var inputs=document.querySelectorAll('input:not([type="submit"])');
            var action=1;
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
                switch (input.id) {
                    // default:
                    //     if(input.value.match(/^[A-Za-z\s]*$/)){
                    //         input.className='form-control is-valid';
                    //         flag=true;
                    //     }else{
                    //         flag=false;
                    //         input.className='form-control is-invalid';
                    //     }
                    //     break;
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
            document.getElementById('rOwner').checked=true;
            document.getElementById('newOwner').style.display='none';
            document.getElementById('owner').style.display='inline';
            $('#rnewOwner').click(function () {
                $('#firstname').prop('required',true);
                $('#lastname').prop('required',true);
                document.getElementById('rOwner').checked=false;
                document.getElementById('owner').style.display='none';
                document.getElementById('newOwner').style.display='inline';
            });
            $('#rOwner').click(function () {
                $('#firstname').prop('required',false);
                $('#lastname').prop('required',false);
                document.getElementById('rnewOwner').checked=false;
                document.getElementById('newOwner').style.display='none';
                document.getElementById('owner').style.display='inline';
            });

            var _iMethod='';
            $('#new').click(function () {
                action=1;
                var form= document.getElementById('historyForm');
                form.action='{{route('histories.store')}}';
                form.method='post';
                var inputMethod=document.getElementsByName('_method');

                for(var i=0;i<inputMethod.length;i++){
                    if(inputMethod[i].value==='PUT'){
                        inputMethod[i].value='POST';
                        _iMethod=inputMethod[i];
                    }
                }
                document.getElementById('htitle').innerText='Nuevo historial';
                document.getElementById('btn').innerText='Guardar'

            });
            $(document).ready(function () {
                $(".btn").click(function () {
                var form= document.getElementById('historyForm');
                action=2;
                form.action='{{route('histories.update',0)}}';
                form.method='post';
                //if(_iMethod.toString().length>0){
                _iMethod.value='PUT';
                //}
                document.getElementById('htitle').innerText='Editar historial';
                document.getElementById('btn').innerText='Editar'
                });
            });
            $('#edit').on('show.bs.modal',function(event){
                 if((_iMethod.value==='PUT' || _iMethod.toString().length===0) && action===2) {
                     console.log(_iMethod);
                    var button = $(event.relatedTarget);
                    var idhistory = button.data('idhistory');
                    var ownerid=button.data('ownerid');
                    var petname = button.data('petname');
                    var birthdate=button.data('birthdate');
                    var color=button.data('color');
                    var modal = $(this);
                    modal.find('.modal-body #idhistory').val(idhistory);
                    modal.find('.modal-body #ownerid').val(ownerid);
                    modal.find('.modal-body #petname').val(petname);
                    modal.find('.modal-body #birthdate').val(birthdate);
                    modal.find('.modal-body #color').val(color);
                 }else{
                     var modal = $(this);
                     modal.find('.modal-body #idhistory').val();
                     modal.find('.modal-body #petname').val('');
                     modal.find('.modal-body #birthdate').val('');
                     modal.find('.modal-body #color').val('');
                 }
            })
        </script>
    @endpush
@endsection