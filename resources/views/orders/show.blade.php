@extends('layouts.orders_template')

@section('title', 'Ordenes de servicio')

@section('screenName','Orden de servicio')
@push('orderNumber')
<input type="text" value="{{$order->number}}" readonly id="txt_order_number" class="form-control">
@endpush

@section('orderContent')
@if($userRole == 'maintenanceSupervisor')
@include('partials.orders.assign_technician')
@elseIf($userRole == 'technician')
@include('partials.orders.technician_order', ['order' => $order])
@else
@include('partials.orders.department_supervisor_order', ['order' => $order])
@endif
@endsection