@extends('layouts.master')
@section('content')
  
<div class="page-wrapper">

    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Designations</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Designations</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_designation"><i class="fa fa-plus"></i> Add Designation</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Designation Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($designations as $index => $designation)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $designation->name }}</td>
                                    <td>{{ $designation->department->department ?? '-' }}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item edit-btn" href="javascript:void(0);" 
                                                   data-id="{{ $designation->id }}" 
                                                   data-name="{{ $designation->name }}" 
                                                   data-department="{{ $designation->department_id }}" 
                                                   data-toggle="modal" data-target="#edit_designation">
                                                   <i class="fa fa-pencil m-r-5"></i> Edit
                                                </a>
                                                <form action="{{ route('form/designations/delete') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $designation->id }}">
                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-trash-o m-r-5"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Add Designation Modal -->
    <div id="add_designation" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Designation</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('form/designations/save') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Designation Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Department <span class="text-danger">*</span></label>
                            <select name="department_id" class="form-control" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->department }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Designation Modal -->

    <!-- Edit Designation Modal -->
    <div id="edit_designation" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Designation</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="edit-form" action="{{ route('form/designations/update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="edit-id">
                        <div class="form-group">
                            <label>Designation Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Department <span class="text-danger">*</span></label>
                            <select name="department_id" id="edit-department" class="form-control" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->department }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Designation Modal -->

</div>

@endsection

@section('script')
<script>
    // Pass data to edit modal
    $('.edit-btn').click(function(){
        var id = $(this).data('id');
        var name = $(this).data('name');
        var dept = $(this).data('department');

        $('#edit-id').val(id);
        $('#edit-name').val(name);
        $('#edit-department').val(dept);
    });
</script>
@endsection