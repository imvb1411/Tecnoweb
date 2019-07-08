<div id="history" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="htitleC">Historial clinico</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="idhistory" id="idhistory" class="form-control">
                <a data-toggle="modal" class="btn btn-info" id="newConsultation" data-target="#addConsultation">+Consulta</a>
                <br>
                <br>
                <table id="historyTable" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>DIAGNOSTICO</th>
                        <th>OBSERVACIONES</th>
                        <th>FECHA</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--@foreach($consultations as $consultation)--}}
                    {{--<tr>--}}
                        {{--<td>{{$consultation->diagnosis}}</td>--}}
                        {{--<td>{{$consultation->observation}}</td>--}}
                        {{--<td>{{$consultation->staff->person->firstname}} {{$consultation->staff->person->lastname}}</td>--}}
                        {{--<td>{{$consultation->createdat}}</td>--}}
                    {{--</tr>--}}
                    {{--@endforeach--}}
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
    {!! Form::open(['route' => ['historiesConsultation.addConsultation'],'method'=>'PUT','id'=>"historyConsultationForm"]) !!}
    {{Form::token()}}
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="htitle">Editar consultas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="historyid" id="historyid" class="form-control">
                <div class="row">
                    <div class="col-3">
                        <label for="weight">PESO</label>
                        <input type="number" name="weight" id="weight" class="form-control" step="any" placeholder="Ingrese el peso">
                    </div>
                    <div class="col-3">
                        <label for="temperature">TEMPERATURA</label>
                        <input type="number" name="temperature" id="temperature" class="form-control" step="any" placeholder="Ingrese el peso">
                    </div>
                    <div class="col-6">
                        <label for="diagnosis">DIAGNOSTICO</label>
                        <input type="text" name="diagnosis" id="diagnosis" class="form-control" step="any" placeholder="Ingrese el diagnostico">
                    </div>
                </div>

                <div class="row">
                    <div class="col-5">
                        <label for="staffid">MEDICO</label>
                        <select name="staffid" id="staffid" class="form-control">
                            @foreach($staffs as $staff)
                                <option value="{{$staff->idstaff}}">{{$staff->person->fisrstname}} {{$staff->person->lastname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-7">
                        <label for="observation">OBSERVACIONES</label>
                        <textarea class="form-control" name="observation" id="observation" rows="2"></textarea>
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