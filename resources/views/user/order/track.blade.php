@if (!isset($error))
    <style>
    .timeline-card {
        background: #ffffff;
        border: 1px solid #EBE5DB;
        border-radius: 20px;
        padding: 3.5rem 2rem;
        box-shadow: 0 10px 30px rgba(140, 117, 88, 0.03);
        margin-top: 3.5rem;
        position: relative;
    }

    .timeline-steps {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        position: relative;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    /* Horizontal line across items */
    .timeline-steps::before {
        content: '';
        position: absolute;
        top: 32px;
        left: 8%;
        right: 8%;
        height: 3px;
        background: #F0EDE8;
        z-index: 1;
        transition: all 0.4s ease;
    }

    .timeline-step-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        z-index: 2;
        padding: 0 10px;
    }

    .timeline-icon-box {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #ffffff;
        border: 3px solid #F0EDE8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #A39688;
        margin-bottom: 1.25rem;
        box-shadow: 0 0 0 6px #ffffff;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .timeline-step-item.active .timeline-icon-box {
        border-color: #8C7558;
        color: #ffffff;
        background: #8C7558;
        box-shadow: 0 0 0 6px #ffffff, 0 8px 20px rgba(140, 117, 88, 0.25);
    }

    .timeline-icon-box i {
        font-size: 1.35rem;
    }

    .timeline-step-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: #8A7E70;
        margin-bottom: 0.4rem;
        transition: color 0.3s ease;
    }

    .timeline-step-item.active .timeline-step-title {
        color: #332B23;
    }

    .timeline-step-date {
        font-family: 'Outfit', sans-serif;
        font-size: 0.85rem;
        color: #8C7558;
        font-weight: 600;
        margin-bottom: 0.4rem;
    }

    .timeline-step-desc {
        font-family: 'Outfit', sans-serif;
        font-size: 0.85rem;
        color: #B5A89A;
        line-height: 1.4;
        max-width: 170px;
    }

    .timeline-step-item.active .timeline-step-desc {
        color: #6C6053;
        font-weight: 500;
    }

    .animate__animated {
        animation-duration: 0.6s;
        animation-fill-mode: both;
    }

    .animate__fadeIn {
        animation-name: fadeIn;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Mobile responsive timeline styling */
    @media (max-width: 767px) {
        .timeline-card {
            padding: 2.5rem 1.5rem;
        }

        .timeline-steps {
            flex-direction: column;
            align-items: flex-start;
            padding-left: 1rem;
        }
        
        .timeline-steps::before {
            top: 25px;
            bottom: 25px;
            left: 28px;
            width: 3px;
            height: auto;
        }
        
        .timeline-step-item {
            flex-direction: row;
            text-align: left;
            align-items: flex-start;
            gap: 1.25rem;
            width: 100%;
            padding: 1.25rem 0;
        }
        
        .timeline-icon-box {
            margin-bottom: 0;
            flex-shrink: 0;
            width: 54px;
            height: 54px;
            border-width: 2px;
            box-shadow: 0 0 0 4px #ffffff;
        }
        
        .timeline-step-content {
            display: flex;
            flex-direction: column;
            padding-top: 4px;
        }
        
        .timeline-step-desc {
            max-width: none;
        }
    }
    </style>

    <div class="timeline-card animate__animated animate__fadeIn">
        <ul class="timeline-steps">
            @for ($i = 0; $i <= $numbers; $i++)

                @if ($i == 0)
                    @if (!empty($track_orders[$i]))
                        @if ($track_orders[$i]['title'] == 'Pending')
                            <li class="timeline-step-item active">
                                <div class="timeline-icon-box"><i class="fas fa-clock"></i></div>
                                <div class="timeline-step-content">
                                    <div class="timeline-step-title">{{ __('Pending') }}</div>
                                    <div class="timeline-step-date">
                                        {{ date('l, d M, Y', strtotime($track_orders[$i]['created_at'])) }}
                                    </div>
                                    <div class="timeline-step-desc">{{ __('Product Pending For Approval') }}</div>
                                </div>
                            </li>
                        @else
                            <li class="timeline-step-item">
                                <div class="timeline-icon-box"><i class="fas fa-clock"></i></div>
                                <div class="timeline-step-content">
                                    <div class="timeline-step-title">{{ __('Pending') }}</div>
                                    <div class="timeline-step-desc">{{ __('Soon') }}</div>
                                </div>
                            </li>
                        @endif
                    @else
                        <li class="timeline-step-item">
                            <div class="timeline-icon-box"><i class="fas fa-clock"></i></div>
                            <div class="timeline-step-content">
                                <div class="timeline-step-title">{{ __('Pending') }}</div>
                                <div class="timeline-step-desc">{{ __('Soon') }}</div>
                            </div>
                        </li>
                    @endif
                @endif

                @if (!isset($track_orders[3]))

                    @if ($i == 1)
                        @if (!empty($track_orders[$i]))
                            @if ($track_orders[$i]['title'] == 'In Progress')
                                <li class="timeline-step-item active">
                                    <div class="timeline-icon-box"><i class="fas fa-truck"></i></div>
                                    <div class="timeline-step-content">
                                        <div class="timeline-step-title">{{ __('Processing') }}</div>
                                        <div class="timeline-step-date">
                                            {{ date('l, d M, Y', strtotime($track_orders[$i]['created_at'])) }}
                                        </div>
                                        <div class="timeline-step-desc">{{ __('Product Shift For Delevery') }}</div>
                                    </div>
                                </li>
                            @else
                                <li class="timeline-step-item">
                                    <div class="timeline-icon-box"><i class="fas fa-truck"></i></div>
                                    <div class="timeline-step-content">
                                        <div class="timeline-step-title">{{ __('Processing') }}</div>
                                        <div class="timeline-step-desc">{{ __('Soon') }}</div>
                                    </div>
                                </li>
                            @endif
                        @else
                            <li class="timeline-step-item">
                                <div class="timeline-icon-box"><i class="fas fa-truck"></i></div>
                                <div class="timeline-step-content">
                                    <div class="timeline-step-title">{{ __('Processing') }}</div>
                                    <div class="timeline-step-desc">{{ __('Soon') }}</div>
                                </div>
                            </li>
                        @endif
                    @endif

                    @if ($i == 2)
                        @if (!empty($track_orders[$i]))
                            @if ($track_orders[$i]['title'] == 'Delivered')
                                <li class="timeline-step-item active">
                                    <div class="timeline-icon-box"><i class="fas fa-check-circle"></i></div>
                                    <div class="timeline-step-content">
                                        <div class="timeline-step-title">{{ __('Delivered') }}</div>
                                        <div class="timeline-step-date">
                                            {{ date('l, d M, Y', strtotime($track_orders[$i]['created_at'])) }}
                                        </div>
                                        <div class="timeline-step-desc">{{ __('Product Delevery Compleate') }}</div>
                                    </div>
                                </li>
                            @else
                                <li class="timeline-step-item">
                                    <div class="timeline-icon-box"><i class="fas fa-check-circle"></i></div>
                                    <div class="timeline-step-content">
                                        <div class="timeline-step-title">{{ __('Delivered') }}</div>
                                        <div class="timeline-step-desc">{{ __('Soon') }}</div>
                                    </div>
                                </li>
                            @endif
                        @else
                            <li class="timeline-step-item">
                                <div class="timeline-icon-box"><i class="fas fa-check-circle"></i></div>
                                <div class="timeline-step-content">
                                    <div class="timeline-step-title">{{ __('Delivered') }}</div>
                                    <div class="timeline-step-desc">{{ __('Soon') }}</div>
                                </div>
                            </li>
                        @endif
                    @endif

                @endif

                @if ($i == 3)
                    @if (!empty($track_orders[$i]))
                        @if ($track_orders[$i]['title'] == 'Canceled')
                            <li class="timeline-step-item active">
                                <div class="timeline-icon-box"><i class="fas fa-times-circle"></i></div>
                                <div class="timeline-step-content">
                                    <div class="timeline-step-title">{{ __('Rejected') }}</div>
                                    <div class="timeline-step-date">
                                        {{ date('l, d M, Y', strtotime($track_orders[$i]['created_at'])) }}
                                    </div>
                                    <div class="timeline-step-desc">{{ __('Product Delevery Rejected') }}</div>
                                </div>
                            </li>
                        @else
                            <li class="timeline-step-item">
                                <div class="timeline-icon-box"><i class="fas fa-times-circle"></i></div>
                                <div class="timeline-step-content">
                                    <div class="timeline-step-title">{{ __('Rejected') }}</div>
                                    <div class="timeline-step-desc">{{ __('Not') }}</div>
                                </div>
                            </li>
                        @endif
                    @else
                        @if (isset($track_orders[3]))
                            <li class="timeline-step-item">
                                <div class="timeline-icon-box"><i class="fas fa-times-circle"></i></div>
                                <div class="timeline-step-content">
                                    <div class="timeline-step-title">{{ __('Rejected') }}</div>
                                    <div class="timeline-step-desc">{{ __('Not') }}</div>
                                </div>
                            </li>
                        @endif
                    @endif
                @endif

            @endfor
        </ul>
    </div>
@else
    <style>
    .track-error-card {
        background: #FFFDF9;
        border: 1px solid #F5E6D3;
        border-radius: 20px;
        padding: 3.5rem 2rem;
        text-align: center;
        box-shadow: 0 8px 24px rgba(227, 53, 53, 0.02);
        margin-top: 3.5rem;
    }

    .track-error-icon {
        width: 68px;
        height: 68px;
        background: #FDF2F2;
        border-radius: 50%;
        color: #E33535;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.85rem;
        margin: 0 auto 1.5rem;
        border: 1px solid rgba(227, 53, 53, 0.15);
        animation: shake 0.5s ease;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-6px); }
        75% { transform: translateX(6px); }
    }

    .track-error-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.65rem;
        color: #332B23;
        margin-bottom: 0.65rem;
        font-weight: 700;
    }

    .track-error-desc {
        font-family: 'Outfit', sans-serif;
        color: #7E7367;
        font-size: 1.05rem;
        max-width: 440px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .animate__animated {
        animation-duration: 0.6s;
        animation-fill-mode: both;
    }

    .animate__fadeIn {
        animation-name: fadeIn;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }
    </style>
    <div class="track-error-card animate__animated animate__fadeIn">
        <div class="track-error-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <h4 class="track-error-title">{{ __('Order Not Found') }}</h4>
        <p class="track-error-desc">{{ __('We couldn\'t find any active shipping records matching this order number. Please double check and try again.') }}</p>
    </div>
@endif
