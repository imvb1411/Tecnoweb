<div id="historyVaccination" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="htitleV">Historial de vacunas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="idhistory" id="idhistory" class="form-control">
                <a data-toggle="modal"
                   class="btn btn-info"
                   id="newVaccination"
                   data-target="#addVaccination">
                    +Vacuna
                </a>
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
                    {{--@foreach($hvaccinations as $h)--}}
                        {{--<tr>--}}
                            {{--<td>{{$h->vaccination->vaccinationname}}</td>--}}
                            {{--<td>{{$h->dosisnumber}}</td>--}}
                            {{--<td>{{$h->createdat}}</td>--}}
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

<div id="addVaccination" class="modal fade" role="dialog">
    {!! Form::open(['route' => ['historiesVaccination.addVaccination'],'method'=>'PUT','id'=>"historyVaccinationForm"]) !!}
    {{Form::token()}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="htitle">Nueva vacuna</h4>
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
    {!! Form::close() !!}
</div>