@extends('adminlte::page')

@section('title', 'Perjanjian Kredit')

@section('content_header')
    <h1>Perjanjian Kredit</h1>
@stop

@section('content')
    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Add New
            </button>
        </div>
        <div class="card-body">
            <table id="table-documents" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>No PK</th>
                        <th>Tgl PK</th>
                        <th>Nama Peminjam</th>
                        <th>Filename</th>
                        <th style="width: 15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $index => $doc)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $doc->nomor_dokumen }}</td>
                            <td>{{ $doc->tanggal_dokumen ? \Carbon\Carbon::parse($doc->tanggal_dokumen)->format('d-m-Y') : '-' }}</td>
                            <td>{{ $doc->nama_peminjam }}</td>
                            <td>{{ $doc->filename }}</td>
                            <td>
                                <a href="{{ $doc->file_url }}" target="_blank" class="btn btn-xs btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-edit-{{ $doc->id }}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.perjanjian-kredit.destroy', $doc->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.perjanjian-kredit.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCreateLabel">Add New Perjanjian Kredit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>No PK</label>
                            <input type="text" class="form-control" name="nomor_dokumen">
                        </div>
                        <div class="form-group">
                            <label>Tanggal PK</label>
                            <input type="date" class="form-control" name="tanggal_dokumen">
                        </div>
                        <div class="form-group">
                            <label>Nama Peminjam</label>
                            <input type="text" class="form-control" name="nama_peminjam">
                        </div>
                        <div class="form-group">
                            <label for="filename">Judul File (Filename)</label>
                            <input type="text" class="form-control" id="filename" name="filename" required>
                        </div>
                        <div class="form-group">
                            <label for="file">Upload File</label>
                            <input type="file" class="form-control-file" id="file" name="file" required>
                            <small class="form-text text-muted">Allowed: PDF, JPG, PNG. Max 10MB.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Modals (Loop) --}}
    @foreach($documents as $doc)
        <div class="modal fade" id="modal-edit-{{ $doc->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.perjanjian-kredit.update', $doc->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Perjanjian Kredit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>No PK</label>
                                <input type="text" class="form-control" name="nomor_dokumen" value="{{ $doc->nomor_dokumen }}">
                            </div>
                            <div class="form-group">
                                <label>Tanggal PK</label>
                                <input type="date" class="form-control" name="tanggal_dokumen" value="{{ $doc->tanggal_dokumen ? \Carbon\Carbon::parse($doc->tanggal_dokumen)->format('Y-m-d') : '' }}">
                            </div>
                            <div class="form-group">
                                <label>Nama Peminjam</label>
                                <input type="text" class="form-control" name="nama_peminjam" value="{{ $doc->nama_peminjam }}">
                            </div>
                            <div class="form-group">
                                <label>Judul File (Filename)</label>
                                <input type="text" class="form-control" name="filename" value="{{ $doc->filename }}" required>
                            </div>
                            <div class="form-group">
                                <label>File (Leave empty to keep current)</label>
                                <input type="file" class="form-control-file" name="file">
                                <small class="form-text text-muted">Current: <a href="{{ $doc->file_url }}" target="_blank">View File</a></small>
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

@stop

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('js')
    <script>
        $(document).ready(function() {
            $('#table-documents').DataTable({
                "order": [[ 2, "desc" ]], // Sort by Tgl PK
                "columnDefs": [
                    { "orderable": false, "targets": [5] }
                ],
                "responsive": true,
            });
        });
    </script>
@stop
