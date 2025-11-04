@extends('web.admin.layouts.master')

@push('css')
<!-- Custom styles for this page -->
<link href="{{ url('') }}/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('main-content')
   <h1 class="h3 mb-0 text-gray-800 mb-4">Data Film</h1>

    <div class="row">

        <div class="col-md-12">
        <div class="mt-3 mb-3">
            <button class="btn btn-primary w-100" id="btn-create">
            <i class="icon fas fa-plus pr-1"></i> Data Film</button>
        </div>

        <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="mt-2 font-weight-bold text-primary">Data Film</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Poster</th>
                        <th>Views</th>
                        <th>Release Date</th>
                        <th>Create Date</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Poster</th>
                        <th>Views</th>
                        <th>Release Date</th>
                        <th>Create Date</th>
                        <th>Menu</th>
                    </tr>
                </tfoot>
                <tbody></tbody>
            </table>
        </div>
        </div>
        
        
        </div>
    </div>


    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Film</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title" class="control-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="">
                </div>
                <div class="form-group">
                    <label for="category" class="control-label">Category</label>
                    <select name="category" id="category" class="form-control">
                        <option value="" disabled selected>Category</option>
                        <option value="documentary">Documentary</option>
                        <option value="fiction">Fiction</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-x"></i></button>
                <button type="button" class="btn btn-primary" id="store"><i class="fa fa-send"></i></button>
            </div>
        </div>
    </div>
  </div>
@endsection

@push('scripts')
<!-- Page level plugins -->
  <script src="{{ url('') }}/admin/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="{{ url('') }}/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <script>
    $(document).ready(function() {
      Movie.movies(AdminAuth.getToken());

      
    });
  </script>


@endpush