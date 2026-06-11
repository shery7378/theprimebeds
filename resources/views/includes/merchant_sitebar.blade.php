@php
    $user = Auth::user();
@endphp
<div class="col-lg-4">
    <aside class="user-info-wrapper">
      <div class="user-info">
        <div class="user-avatar">
          <img id="avater_photo_view" src="{{$user->photo ? url('assets/img/'.$user->photo) : url('assets/img/placeholder.png')}}" alt="Merchant">
        </div>
        <div class="user-data">
          <h4 class="h5">{{$user->first_name}} {{$user->last_name}}</h4>
          <span class="badge badge-success">{{__('Merchant')}}</span>
          @if($user->store_name)
            <br><small class="text-muted mt-1 d-block">
                <a href="{{route('front.merchant.store', $user->store_name)}}" target="_blank" class="text-primary">
                    <i class="icon-external-link"></i> {{$user->store_name}}
                </a>
            </small>
          @endif
        </div>
      </div>
      <nav class="list-group">
        <a class="list-group-item {{ request()->is('user/merchant/dashboard') ? 'active' : '' }}" href="{{route('user.merchant.dashboard')}}"><i class="icon-command"></i>{{__('Dashboard')}}</a>
        <a class="list-group-item {{ request()->is('user/merchant/my-products') ? 'active' : '' }}" href="{{route('user.merchant.my_products')}}"><i class="icon-package"></i>{{__('My Products')}}</a>
        <a class="list-group-item {{ request()->is('user/merchant/catalog') ? 'active' : '' }}" href="{{route('user.merchant.catalog')}}"><i class="icon-plus-circle"></i>{{__('Browse Catalog')}}</a>
        <a class="list-group-item {{ request()->is('user/profile') ? 'active' : '' }}" href="{{route('user.profile')}}"><i class="icon-user"></i>{{__('Profile')}}</a>
        <a class="list-group-item {{ request()->is('user/ticket') ? 'active' : '' }}" href="{{route('user.ticket')}}"><i class="icon-file-text"></i>{{__('Support Ticket')}}</a>
        <a class="list-group-item remove-account with-badge" data-bs-toggle="modal" data-bs-target=".modal-merchant" href="javascript:;"><i class="icon-trash"></i>{{__('Delete Account')}}</a>
        <a class="list-group-item with-badge" href="{{route('user.logout')}}"><i class="icon-log-out"></i>{{__('Log out')}}</a>
      </nav>
    </aside>

    <div class="modal modal-merchant" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{__('Remove Account')}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>{{__('Are You Sure?')}}</p>
            <p>{{__('Do you remove you account?')}}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
            <a href="{{route('user.account.remove')}}" type="button" class="btn btn-danger">{{__('Remove Account')}}</a>
          </div>
        </div>
      </div>
    </div>

  </div>
