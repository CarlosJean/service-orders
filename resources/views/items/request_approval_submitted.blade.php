@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card p-3">
        <div class="row justify-content-center">
            <div class="col-12">
                @if($approved)
                <h2>¡Materiales de orden de servicio aprobados satisfactoriamente!</h2>
                <p>Se aprobó la solicitud de materiales de la orden número <strong>{{$serviceOrderNumber}}</strong>.</p>
                @else
                <h2>¡Materiales de orden de servicio desaprobados satisfactoriamente!</h2>
                <hr class="opacity-100">
                <p>Se desaprobó la solicitud de materiales de la orden número <strong>{{$serviceOrderNumber}}</strong>.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection