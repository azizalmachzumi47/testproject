@extends('layouts.app')

@section('title', 'Menu')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">
            Add New Menu
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered first">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Icon Menu</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $menu->menu }}</td>
                        <td>{{ $menu->icon_menu }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $menu->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{ $menu->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('menu.addmenu') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="menu" name="menu" placeholder="Nama Menu" required>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="icon_menu" name="icon_menu" placeholder="Icon Menu" required>
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
@foreach ($menus as $menu)
<div class="modal fade" id="edit{{ $menu->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $menu->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $menu->id }}">Edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('menu.editmenu_action', $menu->id) }}" method="POST">
                    @csrf
                    @method('POST')  <!-- Menggunakan POST untuk update, bisa gunakan PUT atau PATCH jika ingin -->
                    
                    <div class="form-group">
                        <label>Nama Menu</label>
                        <input type="text" name="menu" value="{{ $menu->menu }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Icon Menu</label>
                        <input type="text" name="icon_menu" value="{{ $menu->icon_menu }}" class="form-control" required>
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
@foreach ($menus as $menu)
<div class="modal fade" id="delete{{ $menu->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $menu->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $menu->id }}">Delete {{ $menu->menu }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Are you sure you want to delete this data...?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{ route('menu.delete', $menu->id) }}" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection


