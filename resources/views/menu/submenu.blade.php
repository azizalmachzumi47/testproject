@extends('layouts.app')

@section('title', 'SubMenu')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">
            Add New SubMenu
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered first">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Url</th>
                        <th scope="col">Active</th>
                        <th scope="col">Action Menu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subMenus as $index => $submenu)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $submenu->title }}</td>
                            <td>{{ $submenu->menu }}</td>
                            <td>{{ $submenu->url }}</td>
                            <td>
                                @if($submenu->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editSubMenuModal{{ $submenu->id }}">
                                    <i class="fas fa-edit"></i>
                                </a>                                
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteSubMenu{{ $submenu->id }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Add New Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('menu.addSubMenu') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title" required>
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control" required>
                            <option value="">Select Menu</option>
                            @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->menu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="Submenu Url" required>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
                            <label class="form-check-label" for="is_active">
                                Active?
                            </label>
                        </div>
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


@foreach ($subMenus as $index => $submenu)
<div class="modal fade" id="editSubMenuModal{{ $submenu->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editSubMenuModalLabel{{ $submenu->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModalLabel{{ $submenu->id }}">Edit Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('menu.editSubMenu', $submenu->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $submenu->title }}" required>
                    </div>
                    <div class="form-group">
                        <label for="menu_id">Select Menu</label>
                        <select name="menu_id" id="menu_id" class="form-control" required>
                            <option value="">Select Menu</option>
                            @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}" {{ $menu->id == $submenu->menu_id ? 'selected' : '' }}>{{ $menu->menu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="url">URL</label>
                        <input type="text" class="form-control" id="url" name="url" value="{{ $submenu->url }}" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active{{ $submenu->id }}" value="1" {{ $submenu->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active{{ $submenu->id }}">Active?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


@foreach ($subMenus as $sm)
    <!-- Modal -->
    <div class="modal fade" id="deleteSubMenu{{ $sm->id }}" tabindex="-1" role="dialog"
         aria-labelledby="deleteSubMenuLabel{{ $sm->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSubMenuLabel{{ $sm->id }}">Delete Sub Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('menu.deleteSubMenu', $sm->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Are you sure you want to delete {{ $sm->title }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach


@endsection
