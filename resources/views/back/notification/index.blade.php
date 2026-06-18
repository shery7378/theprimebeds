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

@if($notifications->count() > 0)
    <h6 class="dropdown-header">
        {{ __('Notifications') }}
        <a class="text-dark float-right" id="clear-notf" data-href="{{ route('back.notifications.clear') }}" href="javascript:;">
            <small>{{ __('Clear All') }}</small>
        </a>
    </h6>

    @foreach($notifications as $notf)
        @if($isMerchant)
            @if($notf->type === 'price_approved' && $notf->merchantProduct && $notf->merchantProduct->item)
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
            @elseif($notf->type === 'price_rejected' && $notf->merchantProduct && $notf->merchantProduct->item)
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
            @endif
        @else
            @if($notf->user_id != null)
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
            @endif
            @if($notf->order_id != null)
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
            @endif
        @endif
    @endforeach
    
    <a class="dropdown-header mt-1 d-block text-center" href="{{route('back.view.notification')}}"> {{__('View All')}} </a>
@else
    <h6 class="dropdown-header">
        {{ __('Notifications') }}
    </h6>
    <a class="dropdown-item d-flex align-items-center" href="javascript:;">
        <div>
            {{ __('No Notifications') }}
        </div>
    </a>
@endif
