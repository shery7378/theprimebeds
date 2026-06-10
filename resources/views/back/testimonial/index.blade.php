@extends('master.back')

@section('content')

<!-- Start of Main Content -->
<div class="container-fluid">

	<!-- Page Heading -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-0 bc-title"><b>{{ __('Manage Testimonials') }}</b> </h3>

                <div class="right">
                  <a class="btn btn-primary  btn-sm" href="{{route('back.testimonial.create')}}"><i class="fas fa-plus"></i> {{ __('Add') }}</a>
                    <form class="d-inline-block" action="{{route('back.bulk.delete')}}" method="get">
                      <input type="hidden" value="" name="ids[]" id="bulk_delete">
                      <input type="hidden" value="testimonials" name="table">
                      <button class="btn btn-danger btn-sm">{{__('Delete')}}</button>
                    </form>
                </div>
              </div>

        </div>
    </div>

	<!-- DataTales -->
	<div class="card shadow mb-4">
		<div class="card-body">
			@include('alerts.alerts')
			<div class="gd-responsive-table">
				<table class="table table-bordered table-striped" id="admin-table" width="100%" cellspacing="0">

					<thead>
						<tr>
                            <th> <input type="checkbox" data-target="testimonial-bulk-delete" class="form-control bulk_all_delete"> </th>
                            <th>{{ __('Client Name') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Rating') }}</th>
                            <th>{{ __('Status') }}</th>
							<th>{{ __('Actions') }}</th>
						</tr>
					</thead>

					<tbody>
						@forelse($testimonials as $testimonial)
							<tr>
                                <td><input type="checkbox" value="{{$testimonial->id}}" class="form-control testimonial-bulk-delete" data-target="testimonial-bulk-delete"> </td>
                                <td>{{ $testimonial->client_name }}</td>
                                <td>{{ $testimonial->client_title }}</td>
                                <td>
                                    <span class="badge badge-warning">
                                        {{ $testimonial->rating }} <i class="fas fa-star"></i>
                                    </span>
                                </td>
                                <td>
                                    @if($testimonial->status == 1)
                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('back.testimonial.edit',$testimonial->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    <a data-toggle="modal" data-target="#confirm-delete" href="{{route('back.testimonial.destroy',$testimonial->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                </td>
							</tr>
						@empty
							<tr>
								<td colspan="6" class="text-center">{{ __('No Testimonials Found') }}</td>
							</tr>
						@endforelse

					</tbody>

				</table>
			</div>
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
          <h3 class="modal-title" id="exampleModalLabel">{{ __('Confirm Delete?') }}</h3>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
		</div>

		<!-- Modal Body -->
        <div class="modal-body">
			{{ __('You are going to delete this testimonial. Do you want to delete it?') }}
		</div>

		<!-- Modal footer -->
        <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
			<form action="" class="d-inline btn-ok" method="POST">
				@method('DELETE')
				@csrf
				<button type="submit" class="btn btn-danger ">{{ __('Delete') }}</button>
			</form>
		</div>

	  </div>
    </div>
  </div>

  <script>
    $('#confirm-delete').on('show.bs.modal', function (e) {
      var id = $(e.relatedTarget).attr("href");
      var action = "{{ route('back.testimonial.destroy', ":id") }}";
      action = action.replace(':id', id);
      $('.btn-ok form').attr('action', action);
    });
  </script>

@endsection
