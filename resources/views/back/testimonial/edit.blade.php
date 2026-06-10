@extends('master.back')

@section('content')

<div class="container-fluid">

	<!-- Page Heading -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class=" mb-0 bc-title"><b>{{ __('Edit Testimonial') }}</b> </h3>
                <a class="btn btn-primary btn-sm" href="{{route('back.testimonial.index')}}"><i class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
                </div>
        </div>
    </div>

	<!-- Form -->
	<div class="row">

		<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card o-hidden border-0 shadow-lg">
				<div class="card-body ">
					<!-- Nested Row within Card Body -->
					<div class="row justify-content-center">
						<div class="col-lg-8">
								<form class="admin-form" action="{{ route('back.testimonial.update', $testimonial->id) }}" method="POST">

                                    @csrf
                                    @method('PUT')

									@include('alerts.alerts')

									<div class="form-group">
										<label for="client_name">{{ __('Client Name') }} *</label>
										<input type="text" name="client_name" class="form-control" id="client_name"
											placeholder="{{ __('Enter Client Name') }}" value="{{ old('client_name', $testimonial->client_name) }}" required>
									</div>

									<div class="form-group">
										<label for="client_title">{{ __('Client Title/Position') }} *</label>
										<input type="text" name="client_title" class="form-control" id="client_title"
											placeholder="{{ __('e.g., Homeowner, Business Owner, etc.') }}" value="{{ old('client_title', $testimonial->client_title) }}" required>
									</div>

									<div class="form-group">
										<label for="testimonial_text">{{ __('Testimonial Text') }} *</label>
										<textarea name="testimonial_text" id="testimonial_text" class="form-control" rows="6"
											placeholder="{{ __('Enter the testimonial message') }}"
											required>{{ old('testimonial_text', $testimonial->testimonial_text) }}</textarea>
									</div>

									<div class="form-group">
										<label for="rating">{{ __('Rating') }} *</label>
										<select name="rating" id="rating" class="form-control" required>
											<option value="" selected disabled>{{ __('Select Rating') }}</option>
											<option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>1 {{ __('Star') }}</option>
											<option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>2 {{ __('Stars') }}</option>
											<option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>3 {{ __('Stars') }}</option>
											<option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>4 {{ __('Stars') }}</option>
											<option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>5 {{ __('Stars') }}</option>
										</select>
									</div>

									<div class="form-group">
										<label for="status">{{ __('Status') }} *</label>
										<select name="status" id="status" class="form-control" required>
											<option value="" selected disabled>{{ __('Select Status') }}</option>
											<option value="1" {{ old('status', $testimonial->status) == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
											<option value="0" {{ old('status', $testimonial->status) == 0 ? 'selected' : '' }}>{{ __('Inactive') }}</option>
										</select>
									</div>

									<button type="submit" class="btn btn-primary">{{ __('Update Testimonial') }}</button>

								</form>

						</div>
					</div>

				</div>

			</div>

		</div>

	</div>

</div>

@endsection
