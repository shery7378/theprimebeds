@extends('master.back')

@section('content')

<!-- Start of Main Content -->
<div class="container-fluid">

	<!-- Page Heading -->
    <div class="card mb-4">
        <div class="d-sm-flex align-items-center justify-content-between">
        <h5 class=" mb-0 text-gray-800 pl-3">{{ __('Manage Features') }}</h5>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('back.dashboard') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('Notifications List') }}</a></li>
        </ol>
        </div>
    </div>


	<div class="card shadow mb-4">
		<div class="card-body">
			@include('alerts.alerts')
            <div class="d-block text-right">
                <a class="btn  btn-primary btn-sm py-1" data-href="{{ route('back.notifications.clear') }}" href="javascript:;">
                    <small>{{ __('Clear All') }}</small>
                </a>
            </div>
			@php
                $admin = Auth::guard('admin')->user();
                $isMerchant = $admin->role && strtolower($admin->role->name) == 'merchant';
                
                if ($isMerchant) {
                    $merchantUser = \App\Models\User::where('email', $admin->email)->first();
                    $merchantUserId = $merchantUser ? $merchantUser->id : 0;
                    $notifications = \App\Models\Notification::where('user_id', $merchantUserId)
                        ->whereIn('type', ['price_approved', 'price_rejected'])
                        ->orderby('id','desc')
                        ->get();
                } else {
                    $notifications = \App\Models\Notification::where(function($q) {
                        $q->whereNull('type')
                          ->orWhereIn('type', ['registration', 'order', 'admin']);
                    })
                    ->orderby('id','desc')
                    ->get();
                }
            @endphp
            @forelse($notifications as $notf)
                @if($isMerchant)
                    @if($notf->type === 'price_approved' && $notf->merchantProduct && $notf->merchantProduct->item)
                        <div class="d-flex align-items-center">
                            <a class="btn btn-sm" href="{{route('back.notification.delete',$notf->id)}}">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('back.merchant.product_pricing') }}">
                            <div class="mr-3">
                                <div class="icon-circle bg-success">
                                <i class="fas fa-check text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $notf->created_at->diffForHumans() }}</div>
                                <span class="font-weight-bold">{{ __('Congrats! Your proposed price for ') . $notf->merchantProduct->item->name . __(' has been approved.') }}</span>
                            </div>
                            </a>
                        </div>
                        <br>
                    @elseif($notf->type === 'price_rejected' && $notf->merchantProduct && $notf->merchantProduct->item)
                        <div class="d-flex align-items-center">
                            <a class="btn btn-sm" href="{{route('back.notification.delete',$notf->id)}}">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('back.merchant.product_pricing') }}">
                            <div class="mr-3">
                                <div class="icon-circle bg-danger">
                                <i class="fas fa-times text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $notf->created_at->diffForHumans() }}</div>
                                <span>{{ __('Your proposed price for ') . $notf->merchantProduct->item->name . __(' has been rejected.') }}</span>
                            </div>
                            </a>
                        </div>
                        <br>
                    @endif
                @else
                    @if($notf->user_id != null)
                        <div class="d-flex align-items-center">
                            <a class="btn btn-sm" href="{{route('back.notification.delete',$notf->id)}}">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('back.user.show',$notf->user_id) }}">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                <i class="fas fa-user text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $notf->created_at->diffForHumans() }}</div>
                                {{ __('A new user has registered.') }}
                            </div>
                            </a>
                        </div>
                        <br>
                    @endif
                    @if($notf->order_id != null)
                        <div class="d-flex align-items-center">
                            <a class="btn btn-sm" href="{{route('back.notification.delete',$notf->id)}}">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('back.order.invoice',$notf->order_id) }}">
                            <div class="mr-3">
                                <div class="icon-circle bg-success">
                                <i class="fas fa-donate text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $notf->created_at->diffForHumans() }}</div>
                                {{ __('You have recieved a new order.') }}
                            </div>
                            </a>
                        </div>
                        <br>
                    @endif
                @endif
            @empty
                <p>{{__('No Notifications')}}</p>
            @endforelse
		</div>
	</div>

</div>

</div>
<!-- End of Main Content -->

{{-- DELETE MODAL --}}

  <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirm-deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

		<!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('Confirm Delete?') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
		</div>

		<!-- Modal Body -->
        <div class="modal-body">
			{{ __('You are going to delete this feature. All contents related with this feature will be lost.') }} {{ __('Do you want to delete it?') }}
		</div>

		<!-- Modal footer -->
        <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
			<form action="" class="d-inline btn-ok" method="POST">

                @csrf

                @method('DELETE')

                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>

			</form>
		</div>

      </div>
    </div>
  </div>

{{-- DELETE MODAL ENDS --}}

@endsection



