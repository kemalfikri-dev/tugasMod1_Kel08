@extends('admin.layout')
@section('content')
    <h4 class="mt-5">Trash - Data Admin Terhapus</h4>
    <div class="d-flex justify-content-between align-items-center text-end">
        <a href="{{ route('admin.index') }}" type="button" class="btn btn-secondary rounded-3">Kembali ke Data Utama</a>
        <a href="{{ route('admin.undoAll') }}" type ="button" class="btn btn-primary rounded-3 text-light">Undo All Data</a>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-3" role="alert">
            {{ $message }}
        </div>
    @endif
    <table class="table table-hover mt-2">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                <tr> 
                    <td>{{ $data->id_admin }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>{{ $data->alamat }}</td>
                    <td>{{ $data->username }}</td>
                    <td>
                        <a href="{{ route('admin.undo', $data->id_admin) }}" type="button"
                            class="btn btn-info rounded-3">Undo</a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#hapusModal{{ $data->id_admin }}">
                            Hapus Permanen
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="hapusModal{{ $data->id_admin }}" tabindex="-1"
                            aria-labelledby="hapusModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusModalLabel">Konfirmasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.deletePermanent', $data->id_admin) }}">
                                        @csrf
                                        <div class="modal-body">
                                            Apakah anda yakin ingin
                                            menghapus permanen data ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Ya</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
</table> @stop