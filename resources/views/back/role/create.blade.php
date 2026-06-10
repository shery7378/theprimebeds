@extends('master.back')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-0 bc-title"><b>{{ __('Role Create') }}</b></h3>
                <a class="btn btn-primary btn-sm" href="{{ route('back.role.index') }}">
                    <i class="fas fa-chevron-left"></i> {{ __('Back') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="p-4">
                                <form class="admin-form" action="{{ route('back.role.store') }}" method="POST">
                                    @csrf
                                    @include('alerts.alerts')

                                    <div class="form-group mb-4">
                                        <label for="name">{{ __('Role Name') }} *</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="{{ __('Enter Role Name') }}" value="{{ old('name') }}">
                                    </div>

                                    <h5 class="mb-3 font-weight-bold text-dark">
                                        <i class="fas fa-lock mr-2"></i>{{ __('Permissions') }}
                                    </h5>

                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle text-center">
                                            <thead style="background-color:#343a40; color:#fff;">
                                                <tr>
                                                    <th class="text-left" style="width:220px;">{{ __('Module') }}</th>
                                                    <th style="width:120px;">
                                                        <i class="fas fa-plus-circle mr-1"></i>{{ __('Add') }}
                                                    </th>
                                                    <th style="width:120px;">
                                                        <i class="fas fa-edit mr-1"></i>{{ __('Update') }}
                                                    </th>
                                                    <th style="width:120px;">
                                                        <i class="fas fa-trash mr-1"></i>{{ __('Delete') }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                {{-- CATEGORIES --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fas fa-list-alt mr-2 text-primary"></i>{{ __('Categories') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Add Categories" id="add_categories">
                                                            <label class="custom-control-label" for="add_categories"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Update Categories" id="update_categories">
                                                            <label class="custom-control-label" for="update_categories"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete Categories" id="delete_categories">
                                                            <label class="custom-control-label" for="delete_categories"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- PRODUCTS --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fab fa-product-hunt mr-2 text-success"></i>{{ __('Products') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Add Products" id="add_products">
                                                            <label class="custom-control-label" for="add_products"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Update Products" id="update_products">
                                                            <label class="custom-control-label" for="update_products"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete Products" id="delete_products">
                                                            <label class="custom-control-label" for="delete_products"></label>
                                                        </div>
                                                    </td>
                                                </tr>



                                                {{-- ORDERS --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fab fa-first-order mr-2 text-warning"></i>{{ __('Orders') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Manage Orders" id="manage_orders">
                                                            <label class="custom-control-label" for="manage_orders"></label>
                                                        </div>
                                                        <small class="text-muted d-block">{{ __('View') }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Update Orders" id="update_orders">
                                                            <label class="custom-control-label" for="update_orders"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete Orders" id="delete_orders">
                                                            <label class="custom-control-label" for="delete_orders"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- TRANSACTIONS --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fas fa-random mr-2 text-secondary"></i>{{ __('Transactions') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Transactions" id="view_transactions">
                                                            <label class="custom-control-label" for="view_transactions"></label>
                                                        </div>
                                                        <small class="text-muted d-block">{{ __('View') }}</small>
                                                    </td>
                                                    <td><span class="text-muted">—</span></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete Transactions" id="delete_transactions">
                                                            <label class="custom-control-label" for="delete_transactions"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- ECOMMERCE --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fas fa-newspaper mr-2 text-primary"></i>{{ __('Ecommerce') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Add Ecommerce" id="add_ecommerce">
                                                            <label class="custom-control-label" for="add_ecommerce"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Update Ecommerce" id="update_ecommerce">
                                                            <label class="custom-control-label" for="update_ecommerce"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete Ecommerce" id="delete_ecommerce">
                                                            <label class="custom-control-label" for="delete_ecommerce"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- CUSTOMERS --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fas fa-users mr-2 text-success"></i>{{ __('Customers') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Customer List" id="view_customers">
                                                            <label class="custom-control-label" for="view_customers"></label>
                                                        </div>
                                                        <small class="text-muted d-block">{{ __('View') }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Update Customers" id="update_customers">
                                                            <label class="custom-control-label" for="update_customers"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete Customers" id="delete_customers">
                                                            <label class="custom-control-label" for="delete_customers"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- MANAGES TICKETS --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fas fa-comments mr-2 text-info"></i>{{ __('Manages Tickets') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Add Tickets" id="add_tickets">
                                                            <label class="custom-control-label" for="add_tickets"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Update Tickets" id="update_tickets">
                                                            <label class="custom-control-label" for="update_tickets"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete Tickets" id="delete_tickets">
                                                            <label class="custom-control-label" for="delete_tickets"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- MANAGE SITE --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fas fa-tasks mr-2 text-warning"></i>{{ __('Manage Site') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Add Site Content" id="add_site">
                                                            <label class="custom-control-label" for="add_site"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Update Site Content" id="update_site">
                                                            <label class="custom-control-label" for="update_site"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete Site Content" id="delete_site">
                                                            <label class="custom-control-label" for="delete_site"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- MANAGE FAQS --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fas fa-question-circle mr-2 text-secondary"></i>{{ __('Manage Faqs') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Add Faqs" id="add_faqs">
                                                            <label class="custom-control-label" for="add_faqs"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Update Faqs" id="update_faqs">
                                                            <label class="custom-control-label" for="update_faqs"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete Faqs" id="delete_faqs">
                                                            <label class="custom-control-label" for="delete_faqs"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- MANAGE BLOGS --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fas fa-rss-square mr-2 text-danger"></i>{{ __('Manage Blogs') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Add Blogs" id="add_blogs">
                                                            <label class="custom-control-label" for="add_blogs"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Update Blogs" id="update_blogs">
                                                            <label class="custom-control-label" for="update_blogs"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete Blogs" id="delete_blogs">
                                                            <label class="custom-control-label" for="delete_blogs"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- MANAGES PAGES --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fas fa-book mr-2 text-primary"></i>{{ __('Manages Pages') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Add Pages" id="add_pages">
                                                            <label class="custom-control-label" for="add_pages"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Update Pages" id="update_pages">
                                                            <label class="custom-control-label" for="update_pages"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete Pages" id="delete_pages">
                                                            <label class="custom-control-label" for="delete_pages"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- SUBSCRIBERS --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fab fa-telegram-plane mr-2 text-info"></i>{{ __('Subscribers') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Subscribers List" id="view_subscribers">
                                                            <label class="custom-control-label" for="view_subscribers"></label>
                                                        </div>
                                                        <small class="text-muted d-block">{{ __('View') }}</small>
                                                    </td>
                                                    <td><span class="text-muted">—</span></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete Subscribers" id="delete_subscribers">
                                                            <label class="custom-control-label" for="delete_subscribers"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- TESTIMONIALS --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fas fa-star mr-2 text-warning"></i>{{ __('Testimonials') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Add Testimonials" id="add_testimonials">
                                                            <label class="custom-control-label" for="add_testimonials"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Update Testimonials" id="update_testimonials">
                                                            <label class="custom-control-label" for="update_testimonials"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete Testimonials" id="delete_testimonials">
                                                            <label class="custom-control-label" for="delete_testimonials"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- SYSTEM USERS --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="far fa-user mr-2 text-dark"></i>{{ __('System Users') }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Add System Users" id="add_system_users">
                                                            <label class="custom-control-label" for="add_system_users"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Update System Users" id="update_system_users">
                                                            <label class="custom-control-label" for="update_system_users"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="Delete System Users" id="delete_system_users">
                                                            <label class="custom-control-label" for="delete_system_users"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- SYSTEM BACKUP --}}
                                                <tr>
                                                    <td class="text-left font-weight-bold">
                                                        <i class="fas fa-hdd mr-2 text-secondary"></i>{{ __('System Backup') }}
                                                    </td>
                                                    <td colspan="3" class="text-center">
                                                        <div class="custom-control custom-checkbox d-inline-block">
                                                            <input type="checkbox" class="custom-control-input" name="section[]" value="System Backup" id="system_backup">
                                                            <label class="custom-control-label" for="system_backup">{{ __('Allow Backup') }}</label>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-dark px-5">
                                            <i class="fas fa-save mr-1"></i> {{ __('Submit') }}
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
