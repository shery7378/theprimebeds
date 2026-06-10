@extends('master.back')

@section('content')

    <!-- Start of Main Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h3 class="mb-0 bc-title"><b>{{ __('Contact Support') }}</b></h3>
                </div>
            </div>
        </div>

        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="gd-responsive-table">
                    <table class="table table-bordered table-striped" id="admin-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="15%">{{ __('Contact Name') }}</th>
                                <th width="10%">{{ __('Contact Mail') }}</th>
                                <th width="10%">{{ __('Phone') }}</th>
                                <th width="10%">{{ __('Message') }}</th>
                                <th width="15%">{{ __('Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($queries as $data)
                                <tr>
                                    <td>{{$data->customer_name}}</td>
                                    <td>{{$data->customer_mail}}</td>
                                    <td>
                                        @php $queryData = json_decode($data->query, true); @endphp

                                        @if($queryData)
                                           <span>{{$queryData['message']}}</span>
                                        @else
                                            <span class="text-muted">No Message</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php $queryData = json_decode($data->query, true); @endphp

                                        @if($queryData)
                                           <span>{{$queryData['phone']}}</span>
                                        @else
                                            <span class="text-muted"></span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-list">
                                            <a class="btn btn-danger btn-sm "
                                                href="{{ route('back.contact.support.delete', $data->id) }}" >
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>

    </div>
    <!-- End of Main Content -->

    {{-- DELETE MODAL --}}

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirm-deleteModalLabel"
        aria-hidden="true">
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
                    {{ __('You are going to delete this Ticket. All contents related with this ticket will be lost.') }}
                    {{ __('Do you want to delete it?') }}
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