@extends('layouts.master')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">


<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<div class="page-wrapper">
<div class="content container-fluid">

    <!-- HEADER -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="page-title">Schedule Management</h3>

        <div>
            <button class="btn btn-primary" id="addScheduleBtn">
                <i class="fa fa-plus"></i> Add Schedule
            </button>

            <a href="{{ url('form/shiftlist/page') }}" class="btn btn-secondary">
                <i class="fa fa-exchange"></i> Shift List
            </a>
        </div>
    </div>

    <!-- ================= TABLE ================= -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Shift</th>
                            <th>Date</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $key => $sch)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $sch->employees_id->name ?? '' }}</td>
                            <td>{{ $sch->department->department ?? '' }}</td>
                            <td>{{ $sch->designation->name ?? '' }}</td>
                            <td>{{ $sch->shift->shift_name ?? '' }}</td>
                            <td>{{ $sch->work_date }}</td>
                            <td>
                                <button class="btn btn-sm btn-info editBtn" data-id="{{ $sch->id }}">
                                    Edit
                                </button>

                                <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $sch->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No Data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ================= CALENDAR ================= -->
    <div class="card mt-4">
        <div class="card-body">
            <h5>Schedule Calendar</h5>
            <div id="calendar"></div>
        </div>
    </div>

</div>
</div>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="scheduleModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Schedule Form</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="scheduleForm">
                    @csrf

                    <input type="hidden" id="schedule_id" name="schedule_id">

                    <select name="employee_id" id="employee_id" class="form-control mb-2" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $e)
                            <option value="{{ $e->id }}">{{ $e->name }}</option>
                        @endforeach
                    </select>

                    <select name="department_id" id="department_id" class="form-control mb-2" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $d)
                            <option value="{{ $d->id }}">{{ $d->department }}</option>
                        @endforeach
                    </select>

                    <select name="designation_id" id="designation_id" class="form-control mb-2" required>
                        <option value="">Select Designation</option>
                        @foreach($designations as $des)
                            <option value="{{ $des->id }}">{{ $des->name }}</option>
                        @endforeach
                    </select>

                    <select name="shiftlist_id" id="shiftlist_id" class="form-control mb-2" required>
                        <option value="">Select Shift</option>
                        @foreach($shiftlists as $s)
                            <option value="{{ $s->id }}">{{ $s->shift_name }}</option>
                        @endforeach
                    </select>

                    <input type="date" name="work_date" id="work_date" class="form-control mb-2" required>

                    <button type="submit" class="btn btn-success btn-block">
                        Save
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@section('script')

<script>
$.ajaxSetup({
    headers: { 
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
    }
});

// ================= OLD SYSTEM =================

// ADD
$('#addScheduleBtn').click(function(){
    $('#scheduleForm')[0].reset();
    $('#schedule_id').val('');
    $('#scheduleModal').modal('show');
});

// EDIT
$(document).on('click','.editBtn',function(){
    let id = $(this).data('id');

    $.get('/form/schedule/edit/' + id, function(data){
        $('#schedule_id').val(data.id);
        $('#employee_id').val(data.employee_id);
        $('#department_id').val(data.department_id);
        $('#designation_id').val(data.designation_id);
        $('#shiftlist_id').val(data.shiftlist_id);
        $('#work_date').val(data.work_date);

        $('#scheduleModal').modal('show');
    });
});

// SAVE
$('#scheduleForm').submit(function(e){
    e.preventDefault();

    // Validate worked hours before submit
    let worked_hours = parseFloat($('#worked_hours').val());
    if (worked_hours > 8) {
        alert('Worked hours exceed 8. Please use Overtime/OT Auto instead!');
        return false;
    }

    let id = $('#schedule_id').val();
    let url = id 
        ? "{{ route('shiftscheduling.update') }}" 
        : "{{ route('shiftscheduling.store') }}";

    $.ajax({
        url: url,
        type: 'POST',
        data: $(this).serialize(),
        success: function(res){
            if(res.status === 'success'){
                $('#scheduleModal').modal('hide');
                location.reload();
            }
        }
    });
});

// DELETE
$(document).on('click','.deleteBtn',function(){
    let id = $(this).data('id');

    if(confirm('Delete this schedule?')){
        $.post('/form/schedule/delete/' + id, function(){
            location.reload();
        });
    }
});

// ================= NEW CALENDAR =================
document.addEventListener('DOMContentLoaded', function () {

    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {

        initialView: 'dayGridMonth',
        editable: true,
        selectable: true,
        height: 650,

        events: @json($events),

        // ADD
        dateClick: function(info) {
            $('#scheduleForm')[0].reset();
            $('#schedule_id').val('');
            $('#work_date').val(info.dateStr);
            $('#scheduleModal').modal('show');
        },

        // EDIT
        eventClick: function(info) {
            let id = info.event.id;

            $.get('/form/schedule/edit/' + id, function(data){
                $('#schedule_id').val(data.id);
                $('#employee_id').val(data.employee_id);
                $('#department_id').val(data.department_id);
                $('#designation_id').val(data.designation_id);
                $('#shiftlist_id').val(data.shiftlist_id);
                $('#work_date').val(data.work_date);

                $('#scheduleModal').modal('show');
            });
        },

        // DRAG DROP
        eventDrop: function(info) {
            $.post('/schedule/update-date', {
                id: info.event.id,
                start: info.event.startStr,
                _token: $('meta[name="csrf-token"]').attr('content')
            });
        }

    });

    calendar.render();
});
</script>

@endsection