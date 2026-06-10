@extends('master.back')

@section('content')

    <!-- Start of Main Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h3 class=" mb-0 "><b>{{ __('Order Dispatch Details') }}</b></h3>
                </div>
            </div>
        </div>
        <div class="container">
            <form action="{{ route('back.order.dispatch') }}" method="POST">

                @csrf
                <input type="text" name="order" value={{$Orderid}} hidden>
                <input type="text" name="delivery_type" value="{{$deliveryType}}" hidden>
                @if ($deliveryType === 'collect')
                    @include('back.components.collection')
                @elseif($deliveryType === 'Delivery')
                    @include('back.components.delivery')
                @endif
                <div class="d-flex justify-content-center align-items-center">
                    <button type="submit" class="btn" style="background:{{$setting->primary_color}};color:#ffff;">Submit</button>

                </div>
            </form>
        </div>

    </div>

    </div>

@endsection