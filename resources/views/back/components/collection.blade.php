
<div class="card mb-4 shadow-sm p-4">
    <h4 class="mb-3">Collection Details</h4>
    <div class="form-group mb-3">
        <label for="order_number">Order Number</label>
        <input type="text" name="order_number" id="order_number" class="form-control" value="{{$order_number}}" readonly required>
    </div>

    <div class="form-group mb-3">
        <label for="pickup_location">Pickup Location</label>
        <input type="text" name="pickup_location" id="pickup_location" class="form-control" required>
    </div>

    <div class="form-group mb-3">
        <label for="opening_hours">Opening Hours</label>
        <input type="text" name="opening_hours" id="opening_hours" class="form-control" placeholder="e.g. Monday – Friday, 9:00 AM – 5:00 PM">
    </div>

    <div class="form-group mb-3">
        <label for="contact_number">Contact Number</label>
        <input type="text" name="contact_number" id="contact_number" class="form-control" required>
    </div>
</div>
