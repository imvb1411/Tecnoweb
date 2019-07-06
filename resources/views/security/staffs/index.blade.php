@extends('layouts.master')
@section('title', 'Empleados')
    @section('header-title','Listado de empleados')
@section('header-content')
    <button class="btn btn-primary btn-lg" id="new" data-toggle="modal" data-target="#edit">Nuevo</button>
@endsection
@section('content')
    <div class="form-group">
        <table id="staffTable" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRES</th>
                <th>APELLIDOS</th>
                <th>OCUPACION</th>
                <th>TELEFONO</th>
                <th>OPERACIONES</th>
            </tr>
            </thead>
            <tbody>
            @foreach($staffs as $staff)
                <tr>
                <td>{{$staff->idstaff}}</td>
                <td>{{$staff->person->firstname}}</td>
                <td>{{$staff->person->lastname}}</td>
                <td>{{$staff->occupation}}</td>
                <td>{{$staff->person->phone}}</td>
                <td >
                        <a class="btn btn-info"
                           data-idstaff="{{$staff->idstaff}}"
                           data-firstname="{{$staff->person->firstname}}"
                           data-lastname="{{$staff->person->lastname}}"
                           data-occupation="{{$staff->occupation}}"
                           data-phone="{{$staff->person->phone}}"
                           data-toggle="modal" id="btnedit" data-target="#edit">
                            Edit
                        </a>
                        {!! Form::open(['route' => ['staffs.destroy',$staff->idstaff],'method'=>'DELETE','style'=>'display: inline']) !!}
                        {{Form::token()}}
                        <button onclick="return confirm('¿Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                        {!! Form::close() !!}
                </td>
            @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    <div id="edit" class="modal fade" role="dialog">
        {!! Form::open(['route' => ['staffs.update','0'],'method'=>'PUT','id'=>"staffForm"]) !!}
        {{Form::token()}}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="htitle">Editar empleado</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <input type="hidden" name="idstaff" id="idstaff" class="form-control">
                        <div class="row">
                            <div class="col-4">
                                <label for="name">NOMBRES</label>
                                <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Ingrese los nombres" required>
                            </div>
                            <div class="col-4">
                                <label for="packing">APELLIDOS</label>
                                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Ingrese los apellidos" required>
                            </div>
                            <div class="col-4">
                                <label for="packing">OCUPACION</label>
                                <select name="occupation" id="occupation" class="form-control" required>
                                    <option value="Medico">Medico</option>
                                    <option value="Vendedor">Vendedor</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <label for="packing">TELEFONO</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Ingrese un teléfono">
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
                $("#staffTable").DataTable();
            });
            var inputs=document.querySelectorAll('input:not([type="submit"])');
            var flag=true;
            var action=1;
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
                    case 'phone':
                        if(input.value.match(/^[0-9]+$/)){
                            input.className='form-control is-valid';
                            flag=true;
                        }else{
                            flag=false;
                            input.className='form-control is-invalid';
                        }
                        break;
                    default:
                        if(input.value.match(/^[A-Za-z\s]*$/) && input.value.length>0){
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
                var form= document.getElementById('staffForm');
                form.action='{{route('staffs.store')}}';
                form.method='post';
                var inputMethod=document.getElementsByName('_method');

                for(var i=0;i<inputMethod.length;i++){
                    if(inputMethod[i].value==='PUT'){
                        _iMethod=inputMethod[i];
                        inputMethod[i].value='POST';
                    }
                }
                document.getElementById('htitle').innerText='Nuevo empleado';
                document.getElementById('btn').innerText='Guardar'

            });
            {{--$('#btnedit').click(function () {--}}
                {{--action=2;--}}
                {{--var form= document.getElementById('staffForm');--}}
                {{--form.action='{{route('staffs.update',0)}}';--}}
                {{--form.method='post';--}}
                {{--if(_iMethod.toString().length>0){--}}
                    {{--_iMethod.value='PUT';--}}
                {{--}--}}
                {{--document.getElementById('htitle').innerText='Editar empleado';--}}
                {{--document.getElementById('btn').innerText='Editar';--}}
            {{--});--}}
            $(document).ready(function () {
               $(".btn").click(function () {
                   action=2;
                   var form= document.getElementById('staffForm');
                   form.action='{{route('staffs.update',0)}}';
                   form.method='post';
                   if(_iMethod.toString().length>0){
                   _iMethod.value='PUT';
                   }
                   document.getElementById('htitle').innerText='Editar empleado';
                   document.getElementById('btn').innerText='Editar';
               });
            });
            $('#edit').on('show.bs.modal',function(event){
                console.log(action);
                if(action===2) {
                    var button = $(event.relatedTarget);
                    var idstaff = button.data('idstaff');
                    console.log(idstaff);
                    var firstname = button.data('firstname');
                    var lastname = button.data('lastname');
                    var occupation = button.data('occupation');
                    var phone = button.data('phone');
                    var modal = $(this);
                    modal.find('.modal-body #idstaff').val(idstaff);
                    modal.find('.modal-body #firstname').val(firstname);
                    modal.find('.modal-body #lastname').val(lastname);
                    modal.find('.modal-body #occupation').val(occupation);
                    modal.find('.modal-body #phone').val(phone);
                }else{
                    var modal = $(this);
                    modal.find('.modal-body #idstaff').val('');
                    modal.find('.modal-body #firstname').val('');
                    modal.find('.modal-body #lastname').val('');
                    modal.find('.modal-body #occupation').val('');
                    modal.find('.modal-body #phone').val('');
                }
            })
        </script>
    @endpush
@endsection