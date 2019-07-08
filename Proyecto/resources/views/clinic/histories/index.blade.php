@extends('layouts.master')
@section('title', 'Historiales')
    @section('header-title','Listado de historiales')
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
                       data-idhc="{{$history->idhistory}}"
                       data-petnc="{{$history->pet->petname}}"
                       data-consultations="{{$history->consultations}}"
                       data-toggle="modal" id="btneditH" data-target="#history">
                        H. Clinico
                    </a>
                    <a class="btn btn-warning"
                       data-idH="{{$history->idhistory}}"
                       data-petN="{{$history->pet->petname}}"
                       data-vaccinations="{{$history->vaccinations}}"
                       data-toggle="modal" id="btneditV" data-target="#historyVaccination">
                        H. Vacunas
                    </a>
                    <a class="btn btn-info"
                       data-idhistory="{{$history->idhistory}}"
                       data-ownerid="{{$history->pet->owner->idperson}}"
                       data-petname="{{$history->pet->petname}}"
                       data-birthdate="{{$history->pet->birthdate}}"
                       data-color="{{$history->pet->color}}"
                       data-toggle="modal" id="btnedit" data-target="#edit" onclick="historyEditClick();">
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
                                        <input type="radio" class="form-check-input" id="rnewOwner" name="newOwner">
                                        <label for="rnewOwner">Nuevo cliente</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="radio" class="form-check-input" id="rOwner" name="ownerExist">
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

    @include('clinic.histories.modalHistoryVaccination')
    @include('clinic.histories.modalHistoryConsultation')

    @push('scripts')
        <script>
            $(function () {
                $("#userTable").DataTable();
                $("#vaccinationTable").DataTable();
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
// -------------------------------------NUEVO HISTORIAL------------------------------------------------------------------------
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
// -------------------------------------------------------------------------------------------------------------------------------
            var _iMethod=null;
            var action=1;
// ---------------------------------------HISTORIAL CREACION-----------------------------------------------------------------------
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



            function historyEditClick(){
                var form= document.getElementById('historyForm');
                action=2;
                form.action='{{route('histories.update',0)}}';
                form.method='post';
                if(_iMethod!=null){
                    _iMethod.value='PUT';
                }
                document.getElementById('htitle').innerText='Editar historial';
                document.getElementById('btn').innerText='Editar';
            }

            $('#edit').on('show.bs.modal',function(event){
                 if(action===2) {
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
            });
//---------------------------------------------------HISTORIAL VACUNAS------------------------------------------------------------------------------------
            var actionV=1;
            $('#newVaccination').click(function () {
                actionV=1;
                var form= document.getElementById('historyVaccinationForm');
                form.action='{{route('historiesVaccination.addVaccination')}}';
                form.method='post';
                var inputMethod=document.getElementsByName('_method');

                for(var i=0;i<inputMethod.length;i++){
                    if(inputMethod[i].value==='PUT'){
                        inputMethod[i].value='POST';
                        _iMethod=inputMethod[i];
                    }
                }
                document.getElementById('htitle').innerText='Nueva vacuna';
                document.getElementById('btn').innerText='Guardar'
            });
            var vacs=[];
            $(document).ready(function(){
                @foreach($vaccinations as $vaccination)
                    vacs.push({id: '{{$vaccination->idvaccination}}',name:'{{$vaccination->vaccinationname}}'});
                @endforeach
            });

            $('#historyVaccination').on('show.bs.modal',function(event){
                    var buttonV = $(event.relatedTarget);
                    var idhistory = buttonV.data('idh');
                    var petname = buttonV.data('petn');
                    var vaccinations=buttonV.data('vaccinations');
                    var modal = $(this);
                    modal.find('.modal-body #idhistory').val(idhistory);
                    document.getElementById('htitleV').innerText='Historial de vacunas de '+petname;
                    $('#newVaccination').attr('data-idhv',idhistory);
                    modal.find('.modal-body #vaccinationTable >tbody').empty();
                    if(vaccinations.length>0) {
                        vaccinations.forEach(element => {
                            var vacuna = element["vaccinationid"];
                            var name='';
                            vacs.forEach(ele=>{
                                if(parseInt(ele.id)===parseInt(vacuna)){
                                    name=ele.name;
                                }
                            });
                            var dosis = element["dosisnumber"];
                            var date=element["createdat"];
                            var row = '<tr class="selected" id="row">' +
                                '<td><input type="hidden" name="vacuna[]" value="' + name + '">' + name + '</td>' +
                                '<td><input type="hidden" name="dosis[]" value="' + dosis + '">' + dosis + '</td>' +
                                '<td><input type="hidden" name="date[]" value="' + date + '">' + date + '</td>' +
                                '</tr>';
                            modal.find('.modal-body #vaccinationTable').append(row);
                        });
                }else{
                    modal.find('.modal-body #idhistory').val('');
                    modal.find('.modal-body #vaccinationTable >tbody').empty();
                    // modal.find('.modal-body #birthdate').val('');
                    // modal.find('.modal-body #color').val('');
                }
            });

            $('#addVaccination').on('show.bs.modal',function(event){
                var buttonV = $(event.relatedTarget);
                console.log(buttonV);
                var idhistory = buttonV.data('idhv');
                var modal = $(this);
                modal.find('.modal-body #idhistory').val(idhistory);
            });
// -----------------------------------------HISTORIAL CLINICO (CONSULTAS)-------------------------------------------------------------------------------
            $('#newConsultation').click(function () {
                actionV=1;
                var form= document.getElementById('historyConsultationForm');
                form.action='{{route('historiesConsultation.addConsultation')}}';
                form.method='post';
                var inputMethod=document.getElementsByName('_method');

                for(var i=0;i<inputMethod.length;i++){
                    if(inputMethod[i].value==='PUT'){
                        inputMethod[i].value='POST';
                        _iMethod=inputMethod[i];
                    }
                }
                document.getElementById('htitle').innerText='Nueva consulta';
                document.getElementById('btn').innerText='Guardar'
            });

            $('#history').on('show.bs.modal',function(event){
                var buttonC = $(event.relatedTarget);
                var idhistory = buttonC.data('idhc');
                var petname = buttonC.data('petnc');
                var consultations= buttonC.data('consultations');
                console.log(consultations);
                var modal = $(this);
                modal.find('.modal-body #idhistory').val(idhistory);
                document.getElementById('htitleC').innerText='Historial de consultas de '+petname;
                $('#newConsultation').attr('data-idhco',idhistory);
                modal.find('.modal-body #historyTable >tbody').empty();
                if(consultations.length>0) {
                    consultations.forEach(element => {
                        var diagnosis = element["diagnosis"];
                        var observation = element["observation"];
                        var date=element["createdat"];
                        var row = '<tr class="selected" id="row">' +
                            '<td><input type="hidden" name="diagnosis[]" value="' + diagnosis + '">' + diagnosis + '</td>' +
                            '<td><input type="hidden" name="observation[]" value="' + observation + '">' + observation + '</td>' +
                            '<td><input type="hidden" name="date[]" value="' + date + '">' + date + '</td>' +
                            '</tr>';
                        modal.find('.modal-body #historyTable').append(row);
                    });

                }else{
                    modal.find('.modal-body #idhistory').val();
                    modal.find('.modal-body #historyTable >tbody').empty();
                    // modal.find('.modal-body #birthdate').val('');
                    // modal.find('.modal-body #color').val('');
                }
            });

            $('#addConsultation').on('show.bs.modal',function(event){
                var buttonC = $(event.relatedTarget);
                var idhistoryc = buttonC.data('idhco');
                console.log(idhistoryc);
                var modal = $(this);
                modal.find('.modal-body #historyid').val(idhistoryc);
            });
        </script>
    @endpush
@endsection