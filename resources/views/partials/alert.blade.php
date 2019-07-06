@foreach(['info','success','warning','danger'] as $type)
    @if(Session::has($type))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-{{ $type }} alert-dismissible no-print">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {!! Session::get($type) !!}
                </div>
            </div>
        </div>
        {{ Session::forget($type) }}
    @endif
@endforeach