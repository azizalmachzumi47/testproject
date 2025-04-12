@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">
            Add New Data Mahasiswa
        </a>

        <a href="{{ route('data_mhs.dataapi') }}" class="btn btn-success mb-3">
            Data Api
        </a>

        <button class="btn btn-danger btn-sm float-right" data-toggle="modal" data-target="#deleteAllModal">
            <i class="fa fa-trash"></i> Delete All Data
        </button>
        
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered first">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nim</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->nim }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->tanggal }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $d->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{ $d->id }}">
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
            <form action="{{ route('data_mhs.adddatamhs') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="Nim" required>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                    </div>

                    <div class="form-group">
                        <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal" required>
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
@foreach ($data as $d)
<div class="modal fade" id="edit{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $d->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $d->id }}">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('data_mhs.editdata_action', $d->id) }}" method="POST">
                    @csrf
                    @method('POST')  <!-- Menggunakan POST untuk update, bisa gunakan PUT atau PATCH jika ingin -->
                    
                    <div class="form-group">
                        <label>Nim</label>
                        <input type="text" name="nim" value="{{ $d->nim }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" value="{{ $d->nama }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" value="{{ $d->tanggal }}" class="form-control" required>
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
@foreach ($data as $d)
<div class="modal fade" id="delete{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $d->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $d->id }}">Delete {{ $d->nama }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Are you sure you want to delete this data...?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{ route('data_mhs.delete', $d->id) }}" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Konfirmasi Hapus Semua Data -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAllModalLabel">Konfirmasi Hapus Semua Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus semua data? Tindakan ini tidak dapat dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('data_mhs.destroyAll') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Semua</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


