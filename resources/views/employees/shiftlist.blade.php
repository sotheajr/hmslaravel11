@extends('layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between">
            <h3 class="page-title">Shift List</h3>
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add_shift">
                <i class="fa fa-plus"></i> Add Shift
            </a>
        </div>
        <div class="page-header d-flex justify-content-between">
            <a href="{{route('shiftscheduling.index')}}" class="btn btn-primary" >
                <i class="fa fa-plus"></i> schedule
            </a>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Shift Name</th>
                        <th>Start Time</th>
                        <th>Break</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="shiftTable">
                    @foreach($shift as $key => $sh)
                    <tr id="row{{ $sh->id }}">
                        <td>{{ $key+1 }}</td>
                        <td>{{ $sh->shift_name }}</td>
                        <td>{{ $sh->start_time }}</td>
                        <td>{{ $sh->break_time }} mins</td>
                        <td>
                            <button class="btn btn-sm btn-info editBtn"
                                data-id="{{ $sh->id }}"
                                data-name="{{ $sh->shift_name }}"
                                data-start="{{ $sh->start_time }}"
                                data-minstart="{{ $sh->min_start_time }}"
                                data-maxstart="{{ $sh->max_start_time }}"
                                data-end="{{ $sh->end_time }}"
                                data-minend="{{ $sh->min_end_time }}"
                                data-maxend="{{ $sh->max_end_time }}"
                                data-break="{{ $sh->break_time }}">
                                Edit
                            </button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $sh->id }}">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ADD MODAL -->
<div id="add_shift" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Add Shift</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addForm">
                    @csrf
                    <input type="text" name="shift_name" class="form-control mb-2" placeholder="Shift Name">
                    <input type="time" name="start_time" class="form-control mb-2">
                    <input type="time" name="min_start_time" class="form-control mb-2" placeholder="Min Start Time">
                    <input type="time" name="max_start_time" class="form-control mb-2" placeholder="Max Start Time">
                    <input type="time" name="end_time" class="form-control mb-2" placeholder="End Time">
                    <input type="time" name="min_end_time" class="form-control mb-2" placeholder="Min End Time">
                    <input type="time" name="max_end_time" class="form-control mb-2" placeholder="Max End Time">
                    <input type="number" name="break_time" class="form-control mb-2" placeholder="Break Time (mins)">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Edit Shift</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">
                    <input type="text" id="edit_name" name="shift_name" class="form-control mb-2">
                    <input type="time" id="edit_start" name="start_time" class="form-control mb-2">
                    <input type="time" id="edit_min_start" name="min_start_time" class="form-control mb-2">
                    <input type="time" id="edit_max_start" name="max_start_time" class="form-control mb-2">
                    <input type="time" id="edit_end" name="end_time" class="form-control mb-2">
                    <input type="time" id="edit_min_end" name="min_end_time" class="form-control mb-2">
                    <input type="time" id="edit_max_end" name="max_end_time" class="form-control mb-2">
                    <input type="number" id="edit_break" name="break_time" class="form-control mb-2">
                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
});

// ADD SHIFT
$('#addForm').submit(function(e){
    e.preventDefault();
    $.post("{{ route('form/shiftlist/save') }}", $(this).serialize(), function(res){
        location.reload(); // reload to show all fields
    });
});

// EDIT SHIFT OPEN
$(document).on('click','.editBtn',function(){
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_start').val($(this).data('start'));
    $('#edit_min_start').val($(this).data('minstart'));
    $('#edit_max_start').val($(this).data('maxstart'));
    $('#edit_end').val($(this).data('end'));
    $('#edit_min_end').val($(this).data('minend'));
    $('#edit_max_end').val($(this).data('maxend'));
    $('#edit_break').val($(this).data('break'));
    $('#editModal').modal('show');
});

// UPDATE SHIFT
$('#editForm').submit(function(e){
    e.preventDefault();
    $.post("{{ route('form/shiftlist/update') }}", $(this).serialize(), function(){
        location.reload();
    });
});

// DELETE SHIFT
$(document).on('click','.deleteBtn',function(){
    let id = $(this).data('id');
    if(confirm('Delete this shift?')){
        $.post("{{ route('form/shiftlist/delete') }}",{id:id}, function(){
            location.reload();
        });
    }
});
</script>
@endsection