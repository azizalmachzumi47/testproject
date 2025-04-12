@extends('layouts.app')

@section('title', 'Role')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Role: {{ $role->role }}</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="example4" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Access</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menu as $index => $m)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $m->menu }}</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    {{ check_access($role->id, $m->id) ? 'checked' : '' }}
                                    data-role="{{ $role->id }}" data-menu="{{ $m->id }}">
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
