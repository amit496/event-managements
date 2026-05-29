<div class="modal fade" id="permissionCreateModal" tabindex="-1"><div class="modal-dialog"><form method="POST" action="{{ route('admin.permissions.store') }}" class="modal-content">@csrf
<div class="modal-header"><h5 class="modal-title">Create Permission</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
<div class="modal-body"><div class="form-group"><label>Name</label><input name="name" class="form-control" required></div></div>
<div class="modal-footer"><button class="btn btn-primary">Save</button></div></form></div></div>

<div class="modal fade" id="permissionEditModal" tabindex="-1"><div class="modal-dialog"><form method="POST" id="permissionEditForm" class="modal-content">@csrf @method('PUT')
<div class="modal-header"><h5 class="modal-title">Update Permission</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
<div class="modal-body"><div class="form-group"><label>Name</label><input name="name" id="edit_permission_name" class="form-control" required></div></div>
<div class="modal-footer"><button class="btn btn-primary">Update</button></div></form></div></div>
