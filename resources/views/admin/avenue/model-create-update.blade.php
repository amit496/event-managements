<div class="modal fade" id="avenueCreateModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><form method="POST" action="{{ route('admin.avenues.store') }}" class="modal-content">@csrf
<div class="modal-header"><h5 class="modal-title">Create Avenue</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
<div class="modal-body row">
<div class="col-md-6 form-group"><label>Name</label><input type="text" name="name" class="form-control" required></div>
<div class="col-md-6 form-group"><label>Place</label><input type="text" name="place" class="form-control" required></div>
<div class="col-md-12 form-group"><label>Address</label><input type="text" name="address" class="form-control"></div>
<div class="col-md-4 form-group"><label>City</label><input type="text" name="city" class="form-control"></div>
<div class="col-md-4 form-group"><label>State</label><input type="text" name="state" class="form-control"></div>
<div class="col-md-4 form-group"><label>Country</label><input type="text" name="country" class="form-control"></div>
<div class="col-md-4 form-group"><label>Postal Code</label><input type="text" name="postal_code" class="form-control"></div>
<div class="col-md-4 form-group"><label>Latitude</label><input type="text" name="latitude" class="form-control"></div>
<div class="col-md-4 form-group"><label>Longitude</label><input type="text" name="longitude" class="form-control"></div>
<div class="col-md-6 form-group"><label>Status</label><select name="status" class="form-control">@foreach($statuses as $status)<option value="{{ $status->value }}">{{ ucfirst($status->value) }}</option>@endforeach</select></div>
</div>
<div class="modal-footer"><button class="btn btn-primary">Save</button></div></form></div></div>

<div class="modal fade" id="avenueEditModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><form method="POST" id="avenueEditForm" class="modal-content">@csrf @method('PUT')
<div class="modal-header"><h5 class="modal-title">Update Avenue</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
<div class="modal-body row">
<div class="col-md-6 form-group"><label>Name</label><input type="text" name="name" id="edit_avenue_name" class="form-control" required></div>
<div class="col-md-6 form-group"><label>Place</label><input type="text" name="place" id="edit_avenue_place" class="form-control" required></div>
<div class="col-md-12 form-group"><label>Address</label><input type="text" name="address" id="edit_avenue_address" class="form-control"></div>
<div class="col-md-4 form-group"><label>City</label><input type="text" name="city" id="edit_avenue_city" class="form-control"></div>
<div class="col-md-4 form-group"><label>State</label><input type="text" name="state" id="edit_avenue_state" class="form-control"></div>
<div class="col-md-4 form-group"><label>Country</label><input type="text" name="country" id="edit_avenue_country" class="form-control"></div>
<div class="col-md-4 form-group"><label>Postal Code</label><input type="text" name="postal_code" id="edit_avenue_postal_code" class="form-control"></div>
<div class="col-md-4 form-group"><label>Latitude</label><input type="text" name="latitude" id="edit_avenue_latitude" class="form-control"></div>
<div class="col-md-4 form-group"><label>Longitude</label><input type="text" name="longitude" id="edit_avenue_longitude" class="form-control"></div>
<div class="col-md-6 form-group"><label>Status</label><select name="status" id="edit_avenue_status" class="form-control">@foreach($statuses as $status)<option value="{{ $status->value }}">{{ ucfirst($status->value) }}</option>@endforeach</select></div>
</div>
<div class="modal-footer"><button class="btn btn-primary">Update</button></div></form></div></div>

