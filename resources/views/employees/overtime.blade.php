@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Overtime</h3>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_overtime"><i class="fa fa-plus"></i> Add Overtime</a>
                </div>
            </div>
        </div>

        <!-- Overtime Table -->
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="overtimeTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th class="text-center">Hours</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th class="text-center">Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($overtimes as $ot)
                    <tr id="ot-{{ $ot->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ot->employee->name }}</td>
                        <td>{{ $ot->date }}</td>
                        <td class="text-center">{{ $ot->hours }}</td>
                        <td>{{ $ot->type }}</td>
                        <td>{{ $ot->description }}</td>
                        <td class="text-center">{{ $ot->status }}</td>
                        <td>
                            <button class="btn btn-sm btn-info editBtn" 
                                data-id="{{ $ot->id }}"
                                data-employee="{{ $ot->employee_id }}"
                                data-date="{{ $ot->date }}"
                                data-hours="{{ $ot->hours }}"
                                data-type="{{ $ot->type }}"
                                data-description="{{ $ot->description }}"
                                data-status="{{ $ot->status }}">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $ot->id }}"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Overtime Modal -->
<div id="add_overtime" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addOvertimeForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Overtime</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Employee <span class="text-danger">*</span></label>
                        <select name="employee_id" class="form-control" required>
                            <option value="">-- Select --</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Hours <span class="text-danger">*</span></label>
                        <input type="number" step="0.1" name="hours" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <input type="text" name="type" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="New">New</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Overtime Modal -->
<div id="edit_overtime" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editOvertimeForm">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Overtime</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Employee <span class="text-danger">*</span></label>
                        <select name="employee_id" id="edit_employee_id" class="form-control" required>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="edit_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Hours <span class="text-danger">*</span></label>
                        <input type="number" step="0.1" name="hours" id="edit_hours" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <input type="text" name="type" id="edit_type" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="edit_description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="edit_status" class="form-control">
                            <option value="New">New</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function(){

    $('#addOvertimeForm').submit(function(e){
    e.preventDefault();
    $.ajax({
        url: "{{ route('form/overtime/save') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(res){
            if(res.success){
                alert(res.message);
                location.reload(); // អាច dynamically append row
            }
        }
    });
});

// Update
$('#editOvertimeForm').submit(function(e){
    e.preventDefault();
    $.ajax({
        url: "{{ route('form/overtime/update') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(res){
            if(res.success){
                alert(res.message);
                location.reload();
            }
        }
    });
});

// Delete
$('.deleteBtn').click(function(){
    if(confirm('Are you sure to delete this overtime?')){
        let id = $(this).data('id');
        $.ajax({
            url: "{{ route('form/overtime/delete') }}",
            type: "POST",
            data: {_token: '{{ csrf_token() }}', id: id},
            success: function(res){
                if(res.success){
                    alert(res.message);
                    $('#ot-' + id).remove();
                }
            }
        });
    }
});
});
</script>
@endsection