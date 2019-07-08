@extends('layouts.master')
@section('title', 'Usuarios')
    @section('header-title','Listado de usuarios')
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
        <table id="userTable" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>NICK</th>
                <th>ROL</th>
                <th>EMPLEADO</th>
                <th>OPERACIONES</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                <td>{{$user->iduser}}</td>
                <td>{{$user->nick}}</td>
                <td>{{$user->role}}</td>
                <td>{{$user->person->firstname}} {{$user->person->lastname}}</td>
                <td >
                    <a class="btn btn-info"
                       data-iduser="{{$user->iduser}}"
                       data-personid="{{$user->personid}}"
                       data-nick="{{$user->nick}}"
                       data-password="{{$user->password}}"
                       data-name="{{$user->person->firstname}} {{$user->person->lastname}}"
                       data-toggle="modal" id="btnedit" data-target="#edit" onclick="editClick();">
                        Edit
                    </a>
                    {!! Form::open(['route' => ['users.destroy',$user->iduser],'method'=>'DELETE','style'=>'display: inline']) !!}
                    {{Form::token()}}
                    <button onclick="return confirm('¿Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                    {!! Form::close() !!}
                </td>
            @endforeach
                </tr>
            </tbody>
        </table>

    <div id="edit" class="modal fade" role="dialog">
        {!! Form::open(['route' => ['users.update','0'],'method'=>'PUT','id'=>"userForm"]) !!}
        {{Form::token()}}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="htitle">Editar Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <input type="hidden" name="iduser" id="iduser" class="form-control">
                        <div class="row">
                            <div class="col-4">
                                <label for="personid">EMPLEADO</label>
                                <select name="personid" id="personid" class="form-control">
                                    @foreach($people as $person)
                                        <option value="{{$person->person->idperson}}">{{$person->person->firstname}} {{$person->person->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="role">ROL</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="ADMINISTRADOR">Administrador</option>
                                    <option value="ASISTENTE">Asistente</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="packing">NICK</label>
                                <input type="text" name="nick" id="nick" class="form-control" placeholder="Ingrese el nick" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="packing">CONTRASEÑA</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese la contraseña" required>
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
            var action=1;
            $(function () {
                $("#userTable").DataTable();
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
                    case 'password':
                        if(!input.value.match(/[\!\@\#\$\%\^\&\*]/g) &&input.value.length>=3){
                            input.className='form-control is-valid';
                            flag=true;
                        }else{
                            flag=false;
                            input.className='form-control is-invalid';
                        }
                        break;
                    case 'nick':
                        if(input.value.match(/^[a-zA-Z0-9]+$/)){
                            input.className='form-control is-valid';
                            flag=true;
                        }else{
                            flag=false;
                            input.className='form-control is-invalid';
                        }
                        break;
                    default:
                        if(input.value.match(/^[A-Za-z\s]*$/)){
                            input.className='form-control is-valid';
                            flag=true;
                        }else{
                            flag=false;
                            input.className='form-control is-invalid';
                        }
                        break;
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
                action=1;
                var form= document.getElementById('userForm');
                form.action='{{route('users.store')}}';
                form.method='post';
                var inputMethod=document.getElementsByName('_method');

                for(var i=0;i<inputMethod.length;i++){
                    if(inputMethod[i].value==='PUT'){
                        _iMethod=inputMethod[i];
                        inputMethod[i].value='POST';
                    }
                }
                document.getElementById('htitle').innerText='Nuevo usuario';
                document.getElementById('btn').innerText='Guardar'

            });

            function editClick(){
                action=2;
                var form= document.getElementById('userForm');
                form.action='{{route('users.update',0)}}';
                form.method='post';
                //if(_iMethod.toString().length>0){
                _iMethod.value='PUT';
                console.log(_iMethod.value);
                //}
                document.getElementById('htitle').innerText='Editar usuario';
                document.getElementById('btn').innerText='Editar';
            }

            $('#edit').on('show.bs.modal',function(event){
                if(action===2) {
                    var button = $(event.relatedTarget);
                    var iduser = button.data('iduser');
                    var personid = button.data('personid');
                    var nick = button.data('nick');
                    var password = button.data('password');
                    var fullname=button.data('name');
                    var modal = $(this);
                    modal.find('.modal-body #iduser').val(iduser);
                    modal.find('.modal-body #nick').val(nick);
                    modal.find('.modal-body #personid').val(personid);
                    modal.find('.modal-body #password').val(password);
                    $("#personid").children('option:first').remove();
                    $("#personid").append(new Option(fullname, personid));
                }else{
                    var modal = $(this);
                    modal.find('.modal-body #iduser').val('');
                    modal.find('.modal-body #nick').val('');
                    modal.find('.modal-body #password').val('');
                }
            })
        </script>
    @endpush
@endsection