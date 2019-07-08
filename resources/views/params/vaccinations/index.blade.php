@extends('layouts.master')
@section('title', 'Vacunas')
    @section('header-title','Listado de vacunas')
@section('header-content')
    <button class="btn btn-primary btn-lg" id="new" data-target="#edit" data-toggle="modal">Nuevo</button>
@endsection
@section('content')
        <table id="vaccinationTable" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>PRECIO</th>
                <th>PLAN</th>
                <th>OPERACIONES</th>
            </tr>
            </thead>
            <tbody>
            @foreach($vaccinations as $vaccination)
                <tr>
                <td>{{$vaccination->idvaccination}}</td>
                <td>{{$vaccination->vaccinationname}}</td>
                <td>{{$vaccination->price}}</td>
                <td>@foreach($vaccination->plans as $plan)
                    Dosis: {{$plan->dosisnumber}}
                    Plazo dias: {{$plan->daysnumber}}<br>
                    @endforeach
                </td>
                <td >
                    <a class="btn btn-info"
                       data-idvaccination="{{$vaccination->idvaccination}}"
                       data-vaccinationname="{{$vaccination->vaccinationname}}"
                       data-price="{{$vaccination->price}}"
                       data-plans="{{$vaccination->plans}}"
                       id="btnedit" data-target="#edit" data-toggle="modal" onclick="editClick()">
                        Editar
                    </a>
                    {!! Form::open(['route' => ['vaccinations.destroy',$vaccination->idvaccination],'method'=>'DELETE','style'=>'display: inline']) !!}
                    {{Form::token()}}
                    <button onclick="return confirm('¿Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                    {!! Form::close() !!}
                </td>
            @endforeach
                </tr>
            </tbody>
        </table>

    @include('params.vaccinations.modal')
    @push('scripts')
        {{--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>--}}
        {{--{!! JsValidator::formRequest('App\Http\Requests\UserRequest', '#userForm'); !!}--}}
        <script>
            $(function () {
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
                if(input.value.match(/^[a-zA-Z0-9]+$/)){
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
                var form= document.getElementById('vaccinationForm');
                form.action='{{route('vaccinations.store')}}';
                form.method='post';
                var inputMethod=document.getElementsByName('_method');
                for(var i=0;i<inputMethod.length;i++){
                    if(inputMethod[i].value==='PUT'){
                        _iMethod=inputMethod[i];
                        inputMethod[i].value='POST';
                    }
                }
                document.getElementById('htitle').innerText='Nueva vacuna';
                document.getElementById('btn').innerText='Guardar';
            });
            
            function editClick(){
                action=2;
                var form= document.getElementById('vaccinationForm');
                form.action='{{route('vaccinations.update',0)}}';
                form.method='post';
                if(_iMethod!=null)
                    _iMethod.value='PUT';
                document.getElementById('htitle').innerText='Editar vacuna';
                document.getElementById('btn').innerText='Editar';
            }

            $('#edit').on('show.bs.modal',function(event){
                var modal = $(this);
                if(action===2) {
                    var button = $(event.relatedTarget);
                    var idvaccination = button.data('idvaccination');
                    var vaccinationname = button.data('vaccinationname');
                    var price=button.data('price');
                    var plans= button.data('plans');
                    modal.find('.modal-body #idvaccination').val(idvaccination);
                    modal.find('.modal-body #vaccinationname').val(vaccinationname);
                    modal.find('.modal-body #price').val(price);
                    document.getElementById('create').style.display='none';
                    modal.find('.modal-body #tablePlans >tbody').empty();
                    if(plans.length>0) {
                        plans.forEach(element => {
                            var dosisnumber = element["dosisnumber"];
                            var daysnumber = element["daysnumber"];
                            var row = '<tr class="selected" id="row">' +
                                '<td><input type="hidden" name="dosis[]" value="' + dosisnumber + '">' + dosisnumber + '</td>' +
                                '<td><input type="hidden" name="days[]" value="' + daysnumber + '">' + daysnumber + '</td>' +
                                '</tr>';
                            modal.find('.modal-body #tablePlans').append(row);
                        });
                    }
                }
                else{
                    modal.find('.modal-body #idvaccination').val('');
                    modal.find('.modal-body #vaccinationname').val('');
                    modal.find('.modal-body #price').val('');
                    modal.find('.modal-body #tablePlans >tbody').empty();
                    document.getElementById('create').style.display='inline';
                 }
            });
        </script>
    @endpush
@endsection
