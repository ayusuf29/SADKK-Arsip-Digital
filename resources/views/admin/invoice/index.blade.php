@extends('adminlte::page')

@section('title', 'Invoice Masuk/Keluar')

@section('content_header')
    <h1>Invoice Masuk/Keluar</h1>
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
            <div class="row mb-3">
                <div class="col-md-3">
                    <label>Filter by Jenis:</label>
                    <select id="filter-jenis" class="form-control">
                        <option value="">All</option>
                        <option value="Masuk">Masuk</option>
                        <option value="Keluar">Keluar</option>
                    </select>
                </div>
            </div>

            <table id="table-documents" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Filename</th>
                        <th style="width: 15%">Jenis</th>
                        <th style="width: 20%">Created At</th>
                        <th style="width: 20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $index => $doc)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $doc->filename }}</td>
                            <td>{{ ucfirst($doc->jenis) }}</td>
                            <td>{{ $doc->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>
                                <a href="{{ $doc->file_url }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-edit-{{ $doc->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('admin.invoice.destroy', $doc->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
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
                <form action="{{ route('admin.invoice.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCreateLabel">Add New Invoice</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="filename">Filename</label>
                            <input type="text" class="form-control" id="filename" name="filename" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select class="form-control" id="jenis" name="jenis" required>
                                <option value="">-- Select Jenis --</option>
                                <option value="masuk">Masuk</option>
                                <option value="keluar">Keluar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file">File</label>
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
                    <form action="{{ route('admin.invoice.update', $doc->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Invoice</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Filename</label>
                                <input type="text" class="form-control" name="filename" value="{{ $doc->filename }}" required>
                            </div>
                            <div class="form-group">
                                <label>Jenis</label>
                                <select class="form-control" name="jenis" required>
                                    <option value="masuk" {{ $doc->jenis == 'masuk' ? 'selected' : '' }}>Masuk</option>
                                    <option value="keluar" {{ $doc->jenis == 'keluar' ? 'selected' : '' }}>Keluar</option>
                                </select>
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
            var table = $('#table-documents').DataTable({
                "order": [[ 3, "desc" ]], // Sort by Created At (column 3 now)
                "columnDefs": [
                    { "orderable": false, "targets": [4] } // Disable sort on Action column (column 4 now)
                ],
                "responsive": true,
            });

            $('#filter-jenis').on('change', function() {
                table.column(2).search(this.value).draw();
            });
        });
    </script>
@stop
