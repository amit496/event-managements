<div class="modal fade" id="roleCreateModal" tabindex="-1"><div class="modal-dialog"><form method="POST" action="{{ route('admin.roles.store') }}" class="modal-content">@csrf
<div class="modal-header"><h5 class="modal-title">Create Role</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
<div class="modal-body"><div class="form-group"><label>Role Name</label><input name="name" class="form-control" required></div><div class="form-group"><label>Permissions</label><select name="permissions[]" multiple class="form-control">@foreach($permissions as $permission)<option value="{{ $permission->name }}">{{ $permission->name }}</option>@endforeach</select></div></div>
<div class="modal-footer"><button class="btn btn-primary">Save</button></div></form></div></div>

<div class="modal fade" id="roleEditModal" tabindex="-1"><div class="modal-dialog"><form method="POST" id="roleEditForm" class="modal-content">@csrf @method('PUT')
<div class="modal-header"><h5 class="modal-title">Update Role</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
<div class="modal-body"><div class="form-group"><label>Role Name</label><input name="name" id="edit_role_name" class="form-control" required></div><div class="form-group"><label>Permissions</label><select name="permissions[]" id="edit_role_permissions" multiple class="form-control">@foreach($permissions as $permission)<option value="{{ $permission->name }}">{{ $permission->name }}</option>@endforeach</select></div></div>
<div class="modal-footer"><button class="btn btn-primary">Update</button></div></form></div></div>
