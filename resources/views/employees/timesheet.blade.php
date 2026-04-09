@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Timesheet</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Timesheet</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_todaywork"><i class="fa fa-plus"></i> Add Today Work</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Timesheet Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0" id="timesheet_table">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Date</th>
                                <th>Project</th>
                                <th class="text-center">Assigned Hours</th>
                                <th class="text-center">Worked Hours</th>
                                <th class="d-none d-sm-table-cell col-md-4">Description</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                          <tbody>
@foreach ($timesheets as $timesheet)
<tr>
    <td>
        {{ $timesheet->employee->name ?? 'N/A' }}<br>
        <small>{{ $timesheet->employee->position ?? '' }}</small>
    </td>
    <td>{{ \Carbon\Carbon::parse($timesheet->date)->format('d M Y') }}</td>
    <td>{{ $timesheet->project }}</td>
    <td class="text-center">{{ $timesheet->assigned_hours }}</td>
    <td class="text-center">{{ $timesheet->worked_hours }}</td>
    <td>{{ $timesheet->description }}</td>
    <td class="text-right">
    <div style="display:flex; justify-content:flex-end; align-items:center; gap:8px;"class="dropdown dropdown-action">
         <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
        <div class="dropdown-menu dropdown-menu-right">
        <button class="edit-btn1 btn btn-info btn-sm" data-id="{{ $timesheet->id }}">
            Edit
        </button>

        <button class="delete-btn btn btn-danger btn-sm" data-id="{{ $timesheet->id }}">
            Delete
        </button>
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
        <!-- /Timesheet Table -->
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="add_todaywork" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Add Today Work</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                  <form id="todaywork_form">
@csrf
<input type="hidden" id="timesheet_id" name="id">

<div class="row">
    <div class="form-group col-sm-6">
        <label>Employee</label>
        <select class="form-control" name="employee_id" id="employee_id" required>
            <option value="">-- Select Employee --</option>
            @foreach($employees as $emp)
                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-sm-6">
        <label>Date</label>
        <input type="date" class="form-control" name="date" id="date">
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
        <label>Project</label>
        <input class="form-control" name="project" id="project">
    </div>

    <div class="form-group col-sm-6">
        <label>Assigned Hours</label>
        <input type="number" class="form-control" name="assigned_hours" id="assigned_hours">
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
        <label>Worked Hours</label>
        <input type="number" class="form-control" name="worked_hours" id="worked_hours">
    </div>
</div>

<div class="form-group">
    <label>Description</label>
    <textarea class="form-control" name="description" id="description"></textarea>
</div>

<button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
</form>
            </div>
        </div>
    </div>
</div>
<!-- EDIT MODAL -->
<div id="edit_todaywork" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Timesheet</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="edit_form">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Employee</label>
                            <select class="form-control" name="employee_id" id="edit_employee_id" required>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date" id="edit_date">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Project</label>
                            <input class="form-control" name="project" id="edit_project">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Assigned Hours</label>
                            <input type="number" class="form-control" name="assigned_hours" id="edit_assigned_hours">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Worked Hours</label>
                            <input type="number" class="form-control" name="worked_hours" id="edit_worked_hours">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" id="edit_description"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function(){

// ADD
$('#todaywork_form').submit(function(e){
    e.preventDefault();

    $.ajax({
        url: '/form/timesheet/save', // 🔥 FIX
        type: 'POST',
        data: $(this).serialize(),
        success: function(){
            location.reload();
        }
    });
});

// EDIT
$(document).on('click','.edit-btn1', function(){
    let id = $(this).data('id');

    $.ajax({
        url: '/form/timesheet/' + id, // 🔥 FIX IMPORTANT
        type: 'GET',
        success: function(data){
            $('#edit_id').val(data.id);
            $('#edit_employee_id').val(data.employee_id);
            $('#edit_date').val(data.date);
            $('#edit_project').val(data.project);
            $('#edit_assigned_hours').val(data.assigned_hours);
            $('#edit_worked_hours').val(data.worked_hours);
            $('#edit_description').val(data.description);

            $('#edit_todaywork').modal('show');
        },
        error: function(err){
            console.log(err);
            alert('Cannot load edit data!');
        }
    });
});

// UPDATE
$('#edit_form').submit(function(e){
    e.preventDefault();

    $.ajax({
        url: '/form/timesheet/update', // 🔥 FIX
        type: 'POST',
        data: $(this).serialize(),
        success: function(){
            $('#edit_todaywork').modal('hide');
            location.reload();
        }
    });
});

// DELETE
$(document).on('click','.delete-btn', function(){
    let id = $(this).data('id');

    if(confirm('Delete this record?')){
        $.ajax({
            url: '/form/timesheet/delete', // 🔥 FIX
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id
            },
            success: function(){
                location.reload();
            }
        });
    }
});

});
</script>
@endsection