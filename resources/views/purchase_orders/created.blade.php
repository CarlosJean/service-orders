@extends('layouts.app')

@section('title', 'Orden de compra creada')

@section('content')
<div class="container">
    <div class="card p-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2>¡Orden de compra creada!</h2>
                <hr>
            </div>
            <div class="col-12">
                <p>Orden de compra creada, bajo el número <strong>{{$purchaseOrderNumber}}</strong>.</p>
            </div>
            <div class="col-12">
                <div class="row justify-content-end">
                    <a class="btn btn-primary col-md-4 mx-md-2 mt-2 mt-md-0" href="{{url('/')}}">Ir a la página principal</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection