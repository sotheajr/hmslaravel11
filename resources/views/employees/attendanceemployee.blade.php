@extends('layouts.master')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<div class="page-wrapper">
<div class="content container-fluid">

    <!-- HEADER -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="page-title">Attendance Management</h3>

        <div>
            <button class="btn btn-primary" id="addAttendanceBtn">
                <i class="fa fa-plus"></i> Add Attendance
            </button>
            <button class="btn btn-success" id="punchInBtn">Punch In</button>
            <button class="btn btn-danger" id="punchOutBtn">Punch Out</button>
            <span id="liveTime" class="ml-3 font-weight-bold"></span>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Date</th>
                            <th>In</th>
                            <th>Out</th>
                            <th>Production</th>
                            <th>Break</th>
                            <th>OT</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $key => $att)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $att->employees->name ?? '' }}</td>
                            <td>{{ $att->date }}</td>
                            <td>{{ $att->punch_in }}</td>
                            <td>{{ $att->punch_out }}</td>
                            <td>{{ $att->production }}</td>
                            <td>{{ $att->break }}</td>
                            <td>{{ $att->overtime }}</td>
                            <td>
                                <button class="btn btn-info btn-sm editBtn" data-id="{{ $att->id }}">Edit</button>
                                <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $att->id }}">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No Data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- CALENDAR -->
    <div class="card mt-4">
        <div class="card-body">
            <h5>Attendance Calendar</h5>
            <div id="attendanceCalendar"></div>
        </div>
    </div>

</div>
</div>

<!-- MODAL -->
<div class="modal fade" id="attendanceModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Form</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="attendanceForm">
                    @csrf
                    <input type="hidden" id="attendance_id" name="attendance_id">

                    <select name="employee_id" id="employee_id" class="form-control mb-2" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $e)
                            <option value="{{ $e->id }}">{{ $e->name }}</option>
                        @endforeach
                    </select>

                    <input type="date" name="date" id="date" class="form-control mb-2" required>
                    <input type="time" name="punch_in" id="punch_in" class="form-control mb-2">
                    <input type="time" name="punch_out" id="punch_out" class="form-control mb-2">
                    <input type="number" name="production" id="production" class="form-control mb-2" placeholder="Production">
                    <input type="number" name="break" id="break" class="form-control mb-2" placeholder="Break">
                    <input type="number" name="overtime" id="overtime" class="form-control mb-2" placeholder="OT">

                    <button type="submit" class="btn btn-success btn-block">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

// ================= CLOCK =================
setInterval(function(){
    $('#liveTime').text(new Date().toLocaleTimeString());
}, 1000);

// ================= ADD =================
$('#addAttendanceBtn').click(function(){
    $('#attendanceForm')[0].reset();
    $('#attendance_id').val('');
    $('#attendanceModal').modal('show');
});

// ================= EDIT =================
$(document).on('click', '.editBtn', function(){
    let id = $(this).data('id');
    $.get('{{ route("attendance.edit", ":id") }}'.replace(':id', id), function(data){
        $('#attendance_id').val(data.id);
        $('#employee_id').val(data.employee_id);
        $('#date').val(data.date);
        $('#punch_in').val(data.punch_in);
        $('#punch_out').val(data.punch_out);
        $('#production').val(data.production);
        $('#break').val(data.break);
        $('#overtime').val(data.overtime);
        $('#attendanceModal').modal('show');
    });
});

// ================= SAVE =================
$('#attendanceForm').submit(function(e){
    e.preventDefault();
    let id = $('#attendance_id').val();
    let url = id 
        ? "{{ route('attendance.update') }}" 
        : "{{ route('attendance.store') }}";

    $.post(url, $(this).serialize(), function(res){
        $('#attendanceModal').modal('hide');
        location.reload();
    });
});

// ================= DELETE =================
$(document).on('click', '.deleteBtn', function(){
    let id = $(this).data('id');
    if(confirm('Delete this attendance?')){
        $.post('/attendance/delete/' + id, function(){ location.reload(); });
    }
});

// ================= PUNCH IN/OUT =================
$('#punchInBtn').click(function(){
    $.post('{{ route("attendance.punch") }}',{type:'in'},function(){ location.reload(); });
});
$('#punchOutBtn').click(function(){
    $.post('{{ route("attendance.punch") }}',{type:'out'},function(){ location.reload(); });
});

// ================= CALENDAR =================
document.addEventListener('DOMContentLoaded', function(){
    var calendar = new FullCalendar.Calendar(document.getElementById('attendanceCalendar'), {
        initialView: 'dayGridMonth',
        editable: true,
        selectable: true,
        height: 650,
        events: @json($events),

        dateClick: function(info){
            $('#attendanceForm')[0].reset();
            $('#attendance_id').val('');
            $('#date').val(info.dateStr);
            $('#attendanceModal').modal('show');
        },

        eventClick: function(info){
            let id = info.event.id;
            $.get('{{ route("attendance.edit", ":id") }}'.replace(':id', id), function(data){
                $('#attendance_id').val(data.id);
                $('#employee_id').val(data.employee_id);
                $('#date').val(data.date);
                $('#punch_in').val(data.punch_in);
                $('#punch_out').val(data.punch_out);
                $('#production').val(data.production);
                $('#break').val(data.break);
                $('#overtime').val(data.overtime);
                $('#attendanceModal').modal('show');
            });
        },

        eventDrop: function(info){
            $.post('/attendance/update-date', {
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