
<div class="card mb-4 shadow-sm p-4">
    <h4 class="mb-3">Courier Delivery Details</h4>
    <div class="form-group mb-3">
        <label for="courier_name">Courier Name</label>
        <input type="text" name="courier_name" id="courier_name" class="form-control" value="{{$order_number}}" readonly required>
    </div>

    <div class="form-group mb-3">
        <label for="tracking_number">Tracking Number</label>
        <input type="text" name="tracking_number" id="tracking_number" class="form-control" required>
    </div>

    <div class="form-group mb-3">
        <label for="tracking_link">Tracking Link</label>
        <input type="url" name="tracking_link" id="tracking_link" class="form-control">
    </div>

    <div class="form-group mb-3">
        <label for="delivery_date">Estimated Delivery Date</label>
        <input type="date" name="delivery_date" id="delivery_date" class="form-control" required>
    </div>
</div>
