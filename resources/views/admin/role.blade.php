@extends('layouts.app')

@section('title', 'Role')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">
            Add New Role
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered first">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $index => $role)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $role->role }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $role->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="{{ route('admin.roleaccess', $role->id) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-universal-access"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{ $role->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No roles found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.addrole') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="role" name="role" placeholder="Role" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
@foreach ($roles as $key => $value)
<div class="modal fade" id="edit{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $value->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $value->id }}">Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.role_update', $value->id) }}" method="POST">
                    @csrf
                    @method('POST')  <!-- Menggunakan POST untuk update, bisa gunakan PUT atau PATCH jika ingin -->
                    
                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" name="role" value="{{ $value->role }}" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Delete -->
@foreach ($roles as $key => $value)
<div class="modal fade" id="delete{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $value->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $value->id }}">Delete {{ $value->role }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Are you sure you want to delete this data...?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{ route('admin.role_delete', $value->id) }}" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
