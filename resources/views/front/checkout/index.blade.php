@extends('master.front')

@section('title')
    {{ __('Billing') }}
@endsection

@section('content')
    <!-- Page Title-->
    <div class="page-title">
        <div class="container">
            <div class="column">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('front.index') }}">{{ __('Home') }}</a> </li>
                    <li class="separator"></li>
                    <li>{{ __('Billing address') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Page Content-->
    <style>
        .checkout-premium-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0,0,0,0.02);
            padding: 24px;
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }
        .checkout-premium-card:hover {
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
        }
        .checkout-section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2b2b2b;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f3f4f6;
        }
        .cart-item-premium {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 20px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .cart-item-premium:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .cart-item-img {
            width: 100px;
            height: 100px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .cart-item-details {
            flex: 1;
        }
        .cart-item-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 4px;
            text-decoration: none;
        }
        .cart-item-title:hover {
            color: var(--primary-color);
        }
        .cart-item-price-qty {
            font-size: 0.95rem;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 10px;
        }
        .cart-item-options {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 12px;
        }
        .option-badge {
            background: #f3f4f6;
            color: #4b5563;
            font-size: 0.8rem;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 600;
        }
        .customization-box {
            background: linear-gradient(145deg, #ffffff, #f3f6fa);
            border-radius: 16px;
            padding: 20px;
            margin-top: 15px;
            position: relative;
            box-shadow: 0 10px 30px -10px rgba(13, 110, 253, 0.15);
            border: 1px solid rgba(13, 110, 253, 0.1);
            overflow: hidden;
        }
        .customization-box::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: {{ $setting->primary_color }};
        }
        .customization-title {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 800;
            color: {{ $setting->primary_color }};
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .customization-title i {
            color: {{ $setting->primary_color }};
            font-size: 1.1rem;
        }
        .customization-notes {
            font-size: 0.95rem;
            color: #4b5563;
            font-style: italic;
            margin-bottom: 15px;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.6);
            border-left: 3px solid {{ $setting->primary_color }};
            border-radius: 0 8px 8px 0;
        }
        .customization-images {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .customization-images img {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .customization-images img:hover {
            transform: scale(1.15) translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .form-control-premium {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        .form-control-premium:focus {
            background-color: #fff;
            border-color: var(--primary-color, #0d6efd);
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }
        .form-group label {
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
            margin-bottom: 6px;
        }
    </style>
    <div class="container padding-bottom-3x mb-1 checkut-page mt-4">
        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <div class="row">
                    <div class="col-12">
                        <section class="checkout-premium-card">
                            <h3 class="checkout-section-title">{{ __('Items In Your Cart') }}</h3>
                            @foreach ($cart as $key => $item)
                                <div class="cart-item-premium">
                                    <a href="{{ route('front.product', $item['slug']) }}">
                                        <img class="cart-item-img" src="{{ url('assets/img/' . $item['photo']) }}" alt="Product">
                                    </a>
                                    <div class="cart-item-details">
                                        <a class="cart-item-title d-block" href="{{ route('front.product', $item['slug']) }}">
                                            {{ Str::limit($item['name'], 45) }}
                                        </a>
                                        <div class="cart-item-price-qty">
                                            {{ $item['qty'] }} x {{ PriceHelper::setCurrencyPrice($item['main_price']) }}
                                        </div>

                                        @if(count($item['attribute']['option_name']) > 0)
                                            <div class="cart-item-options">
                                                @foreach ($item['attribute']['option_name'] as $optionkey => $option_name)
                                                    <span class="option-badge">
                                                        {{ $option_name }}: {{ PriceHelper::setCurrencySign() }}{{ $item['attribute']['option_price'][$optionkey] }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if(!empty($item['preference_description']) || !empty($item['sample_image']))
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-sm btn-outline-primary" style="border-radius: 6px; font-weight: 600;" data-bs-toggle="collapse" data-bs-target="#customization-{{$key}}" aria-expanded="false" aria-controls="customization-{{$key}}">
                                                    <i class="fas fa-eye"></i> {{ __('Show Customization') }}
                                                </button>
                                            </div>
                                            <div class="customization-box collapse" id="customization-{{$key}}">
                                                <div class="customization-title">
                                                    <i class="fas fa-magic"></i> {{ __('Customized for You') }}
                                                </div>
                                                @if(!empty($item['preference_description']))
                                                    <div class="customization-notes">
                                                        "{{ $item['preference_description'] }}"
                                                    </div>
                                                @endif
                                                @if(!empty($item['sample_image']))
                                                    <div class="customization-images">
                                                        @php
                                                            $images = is_string($item['sample_image']) ? json_decode($item['sample_image'], true) : $item['sample_image'];
                                                            if (!is_array($images)) $images = [$item['sample_image']];
                                                        @endphp
                                                        @foreach($images as $img)
                                                            @php
                                                                $rawImg = is_array($img) ? (isset($img['image']) ? $img['image'] : $img[0]) : $img;
                                                                $cleanImg = trim(str_replace(['[', ']', '"'], '', html_entity_decode(stripslashes($rawImg), ENT_QUOTES)));
                                                            @endphp
                                                            @if($cleanImg && file_exists(public_path('assets/preferences/' . $cleanImg)))
                                                                <img src="{{ asset('assets/preferences/' . $cleanImg) }}" alt="Customization Image">
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </section>
                        <div class="checkout-premium-card">
                            <div>
                                <h3 class="checkout-section-title">{{ __('Billing Address') }}</h3>
                                <form id="checkoutBilling" action="{{ route('front.checkout.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="single_page_checkout" value="1">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="checkout-fn">{{ __('First Name') }}*</label>
                                                <input class="form-control form-control-premium {{ $errors->has('bill_first_name') ? 'requireInput' : '' }}" name="bill_first_name" type="text" 
                                                    id="checkout-fn" value="{{ isset($user) ? $user->first_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="checkout-ln">{{ __('Last Name') }}*</label>
                                                <input class="form-control form-control-premium {{ $errors->has('bill_last_name') ? 'requireInput' : '' }}" name="bill_last_name" type="text" 
                                                    id="checkout-ln" value="{{ isset($user) ? $user->last_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="checkout_email_billing">{{ __('E-mail Address') }}*</label>
                                                <input class="form-control form-control-premium {{ $errors->has('bill_email') ? 'requireInput' : '' }}" name="bill_email" type="email" 
                                                    id="checkout_email_billing"
                                                    value="{{ isset($user) ? $user->email : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="checkout-phone">{{ __('Phone Number') }}*</label>
                                                <input class="form-control form-control-premium {{ $errors->has('bill_phone') ? 'requireInput' : '' }}" name="bill_phone" type="text"
                                                    id="checkout-phone" 
                                                    value="{{ isset($user) ? $user->phone : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    @if (PriceHelper::CheckDigital())
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="checkout-address1">{{ __('Address') }}*</label>
                                                    <input class="form-control form-control-premium {{ $errors->has('bill_address1') ? 'requireInput' : '' }}" name="bill_address1" 
                                                        type="text" id="checkout-address1"
                                                        value="{{ isset($user) ? $user->bill_address1 : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="checkout-zip">{{ __('Zip Code') }}*</label>
                                                    <input class="form-control form-control-premium {{ $errors->has('bill_zip') ? 'requireInput' : '' }}" name="bill_zip" type="text"
                                                        id="checkout-zip"
                                                        value="{{ isset($user) ? $user->bill_zip : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="checkout-city">{{ __('City') }}*</label>
                                                    <input class="form-control form-control-premium {{ $errors->has('bill_city') ? 'requireInput' : '' }}" name="bill_city" type="text" 
                                                        id="checkout-city"
                                                        value="{{ isset($user) ? $user->bill_city : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="checkout-country">{{ __('Country') }}</label>
                                                    <select class="form-control form-control-premium"  name="bill_country"
                                                        id="billing-country">
                                                        <option selected>{{ __('Choose Country') }}</option>
                                                        @foreach (DB::table('countries')->get() as $country)
                                                            <option value="{{ $country->name }}"
                                                                {{ isset($user) && $user->bill_country == $country->name ? 'selected' : '' }}>
                                                                {{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar          -->
            <div class="col-xl-4 col-lg-4">
                @include('includes.single_checkout_sidebar', $cart)
                @include('includes.single_checkout_modal')
            </div>
        </div>
    </div>
@endsection
