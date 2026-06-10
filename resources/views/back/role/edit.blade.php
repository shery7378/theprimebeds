@extends('master.back')

@section('content')

@php
    $section = [];
    if($role->section && $role->section != 'null'){
        $decoded = json_decode($role->section, true);
        $section = is_array($decoded) ? $decoded : [];
    }
    function chk($val, $section){ return in_array($val, $section) ? 'checked' : ''; }
@endphp

<style>
.perm-table th, .perm-table td { vertical-align: middle !important; text-align: center; }
.perm-table td:first-child { text-align: left; font-weight: 600; }
.perm-table input[type=checkbox] { width: 18px; height: 18px; cursor: pointer; }
.section-header { background: #f8f9fa; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: .5px; color: #555; }
</style>

<div class="container-fluid">

    {{-- Page Heading --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-0 bc-title"><b>{{ __('Role Edit') }}</b></h3>
                <a class="btn btn-primary btn-sm" href="{{ route('back.role.index') }}">
                    <i class="fas fa-chevron-left"></i> {{ __('Back') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-4">

                    @include('alerts.alerts')

                    <form class="admin-form" action="{{ route('back.role.update', $role->id) }}" method="POST">
                        @method('PUT')
                        @csrf

                        {{-- Role Name --}}
                        <div class="form-group mb-4">
                            <label for="name"><strong>{{ __('Role Name') }} *</strong></label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="{{ __('Enter Role Name') }}" value="{{ $role->name }}">
                        </div>

                        {{-- Permissions Table --}}
                        <h5 class="mb-3 text-primary border-bottom pb-2">
                            <i class="fas fa-shield-alt mr-2"></i>{{ __('Permissions') }}
                        </h5>

                        <div class="table-responsive">
                            <table class="table table-bordered perm-table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:220px; text-align:left;">{{ __('Module') }}</th>
                                        <th style="width:130px;">{{ __('Add / View') }}</th>
                                        <th style="width:130px;">{{ __('Update') }}</th>
                                        <th style="width:130px;">{{ __('Delete') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- ===== CATALOG ===== --}}
                                    <tr class="section-header">
                                        <td colspan="4">🗂 {{ __('Catalog') }}</td>
                                    </tr>

                                    {{-- Categories --}}
                                    <tr>
                                        <td>{{ __('Categories') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Add Categories" {{ chk('Add Categories', $section) }}>
                                            <br><small class="text-muted">Add</small>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Update Categories" {{ chk('Update Categories', $section) }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete Categories" {{ chk('Delete Categories', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- Products --}}
                                    <tr>
                                        <td>{{ __('Products') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Add Products" {{ chk('Add Products', $section) }}>
                                            <br><small class="text-muted">Add</small>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Update Products" {{ chk('Update Products', $section) }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete Products" {{ chk('Delete Products', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- ===== SALES ===== --}}
                                    <tr class="section-header">
                                        <td colspan="4">🛒 {{ __('Sales') }}</td>
                                    </tr>

                                    {{-- Orders --}}
                                    <tr>
                                        <td>{{ __('Orders') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Manage Orders" {{ chk('Manage Orders', $section) }}>
                                            <br><small class="text-muted">View</small>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Update Orders" {{ chk('Update Orders', $section) }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete Orders" {{ chk('Delete Orders', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- Transactions --}}
                                    <tr>
                                        <td>{{ __('Transactions') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Transactions" {{ chk('Transactions', $section) }}>
                                            <br><small class="text-muted">View</small>
                                        </td>
                                        <td><span class="text-muted">—</span></td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete Transactions" {{ chk('Delete Transactions', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- Ecommerce --}}
                                    <tr>
                                        <td>{{ __('Ecommerce') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Add Ecommerce" {{ chk('Add Ecommerce', $section) }}>
                                            <br><small class="text-muted">Add</small>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Update Ecommerce" {{ chk('Update Ecommerce', $section) }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete Ecommerce" {{ chk('Delete Ecommerce', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- ===== CUSTOMERS ===== --}}
                                    <tr class="section-header">
                                        <td colspan="4">👥 {{ __('Customers') }}</td>
                                    </tr>

                                    {{-- Customer List --}}
                                    <tr>
                                        <td>{{ __('Customers') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Customer List" {{ chk('Customer List', $section) }}>
                                            <br><small class="text-muted">View</small>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Update Customers" {{ chk('Update Customers', $section) }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete Customers" {{ chk('Delete Customers', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- Subscribers --}}
                                    <tr>
                                        <td>{{ __('Subscribers') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Subscribers List" {{ chk('Subscribers List', $section) }}>
                                            <br><small class="text-muted">View</small>
                                        </td>
                                        <td><span class="text-muted">—</span></td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete Subscribers" {{ chk('Delete Subscribers', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- Tickets --}}
                                    <tr>
                                        <td>{{ __('Manages Tickets') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Add Tickets" {{ chk('Add Tickets', $section) }}>
                                            <br><small class="text-muted">Add</small>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Update Tickets" {{ chk('Update Tickets', $section) }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete Tickets" {{ chk('Delete Tickets', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- ===== CONTENT ===== --}}
                                    <tr class="section-header">
                                        <td colspan="4">📝 {{ __('Content') }}</td>
                                    </tr>

                                    {{-- Manage Site --}}
                                    <tr>
                                        <td>{{ __('Manage Site') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Add Site Content" {{ chk('Add Site Content', $section) }}>
                                            <br><small class="text-muted">Add</small>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Update Site Content" {{ chk('Update Site Content', $section) }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete Site Content" {{ chk('Delete Site Content', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- Faqs --}}
                                    <tr>
                                        <td>{{ __('Manage Faqs') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Add Faqs" {{ chk('Add Faqs', $section) }}>
                                            <br><small class="text-muted">Add</small>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Update Faqs" {{ chk('Update Faqs', $section) }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete Faqs" {{ chk('Delete Faqs', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- Blogs --}}
                                    <tr>
                                        <td>{{ __('Manage Blogs') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Add Blogs" {{ chk('Add Blogs', $section) }}>
                                            <br><small class="text-muted">Add</small>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Update Blogs" {{ chk('Update Blogs', $section) }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete Blogs" {{ chk('Delete Blogs', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- Testimonials --}}
                                    <tr>
                                        <td>{{ __('Testimonials') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Add Testimonials" {{ chk('Add Testimonials', $section) }}>
                                            <br><small class="text-muted">Add</small>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Update Testimonials" {{ chk('Update Testimonials', $section) }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete Testimonials" {{ chk('Delete Testimonials', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- Pages --}}
                                    <tr>
                                        <td>{{ __('Manages Pages') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Add Pages" {{ chk('Add Pages', $section) }}>
                                            <br><small class="text-muted">Add</small>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Update Pages" {{ chk('Update Pages', $section) }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete Pages" {{ chk('Delete Pages', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- ===== SYSTEM ===== --}}
                                    <tr class="section-header">
                                        <td colspan="4">⚙️ {{ __('System') }}</td>
                                    </tr>

                                    {{-- System Users --}}
                                    <tr>
                                        <td>{{ __('System Users') }}</td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Add System Users" {{ chk('Add System Users', $section) }}>
                                            <br><small class="text-muted">Add</small>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Update System Users" {{ chk('Update System Users', $section) }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="section[]" value="Delete System Users" {{ chk('Delete System Users', $section) }}>
                                        </td>
                                    </tr>

                                    {{-- System Backup --}}
                                    <tr>
                                        <td>{{ __('System Backup') }}</td>
                                        <td colspan="3" class="text-center">
                                            <input type="checkbox" name="section[]" value="System Backup" {{ chk('System Backup', $section) }}>
                                            <small class="text-muted ml-1">{{ __('Allow Backup') }}</small>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        {{-- Submit --}}
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-dark px-5">
                                <i class="fas fa-save mr-1"></i> {{ __('Update Role') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
