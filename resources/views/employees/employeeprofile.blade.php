@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ul>
                    </div>
                </div>
            </div>
              
            <!-- /Page Header -->
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#"><img class="user-profile" alt="" src="{{ URL::to('/assets/images/'. $users->avatar) }}" alt="{{ $users->name }}"></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">{{ $users->name }}</h3>
                                                <h6 class="text-muted"> {{ $users->department }}</h6>
                                                <small class="text-muted">{{ $users->position }}</small>
                                                <div class="staff-id">Employee ID : {{ $users->user_id }}</div>
                                                <div class="small doj text-muted">Date of Join : {{ $users->join_date }}</div>
                                                <div class="staff-msg"><a class="btn btn-custom" href="chat.html">Send Message</a></div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <div class="text">
                                                        @if(!empty($users->phone_number))
                                                            <a>{{ $users->phone_number }}</a>
                                                        @else
                                                            <a>N/A</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text">
                                                        @if(!empty($users->email))
                                                        <a>{{ $users->email }}</a>
                                                        @else
                                                            <a>N/A</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Birthday:</div>
                                                    <div class="text">
                                                        @if(!empty($users->birth_date))
                                                        <a>{{ $users->birth_date }}</a>
                                                        @else
                                                            <a>N/A</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Address:</div>
                                                    <div class="text">
                                                        @if(!empty($users->address))
                                                        <a>{{ $users->address }}</a>
                                                        @else
                                                            <a>N/A</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Gender:</div>
                                                    <div class="text">
                                                        @if(!empty($users->gender))
                                                        <a>{{ $users->gender }}</a>
                                                        @else
                                                            <a>N/A</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Reports to:</div>
                                                    <div class="text">
                                                        <div class="avatar-box">
                                                            <div class="avatar avatar-xs">
                                                                <img src="{{ URL::to('/assets/images/'. $users->avatar) }}" alt="">
                                                            </div>
                                                        </div>
                                                        <a>{{ $users->line_manager }}</a>
                                                    </div>
                                                </li> 
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
					
            <div class="card tab-box">
                <div class="row user-tabs">
                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active">Profile</a></li>
                            <li class="nav-item"><a href="#emp_projects" data-toggle="tab" class="nav-link">Projects</a></li>
                            <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Bank & Statutory <small class="text-danger">(Admin Only)</small></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="tab-content">
                <!-- Profile Info Tab -->
                <div id="emp_profile" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Personal Informations <a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a></h3>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Passport No.</div>
                                            @if (!empty($users->passport_no))
                                                <div class="text">{{ $users->passport_no }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Passport Exp Date.</div>
                                            @if (!empty($users->passport_expiry_date))
                                                <div class="text">{{ $users->passport_expiry_date }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Tel</div>
                                            @if (!empty($users->tel))
                                                <div class="text">{{ $users->tel }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Nationality</div>
                                            @if (!empty($users->nationality))
                                                <div class="text">{{ $users->nationality }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Religion</div>
                                            @if (!empty($users->religion))
                                                <div class="text">{{ $users->religion }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Marital status</div>
                                            @if (!empty($users->marital_status))
                                                <div class="text">{{ $users->marital_status }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Employment of spouse</div>
                                            @if (!empty($users->employment_of_spouse))
                                                <div class="text">{{ $users->employment_of_spouse }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">No. of children</div>
                                            @if ($users->children != null)
                                                <div class="text">{{ $users->children }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Emergency Contact <a href="#" class="edit-icon" data-toggle="modal" data-target="#emergency_contact_modal"><i class="fa fa-pencil"></i></a></h3>
                                    <h5 class="section-title">Primary</h5>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Name</div>
                                            @if (!empty($users->name_primary))
                                            <div class="text">{{ $users->name_primary }}</div>
                                            @else
                                            <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Relationship</div>
                                            @if (!empty($users->relationship_primary))
                                            <div class="text">{{ $users->relationship_primary }}</div>
                                            @else
                                            <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Phone </div>
                                            @if (!empty($users->phone_primary) && !empty($users->phone_2_primary))
                                            <div class="text">{{ $users->phone_primary }},{{ $users->phone_2_primary }}</div>
                                            @else
                                            <div class="text">N/A</div>
                                            @endif
                                        </li>
                                    </ul>
                                    <hr>
                                    <h5 class="section-title">Secondary</h5>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Name</div>
                                            @if (!empty($users->name_secondary))
                                            <div class="text">{{ $users->name_secondary }}</div>
                                            @else
                                            <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Relationship</div>
                                            @if (!empty($users->relationship_secondary))
                                            <div class="text">{{ $users->relationship_secondary }}</div>
                                            @else
                                            <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Phone </div>
                                            @if (!empty($users->phone_secondary) && !empty($users->phone_2_secondary))
                                            <div class="text">{{ $users->phone_secondary }},{{ $users->phone_2_secondary }}</div>
                                            @else
                                            <div class="text">N/A</div>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                            <div class="col-md-6 d-flex">
    <div class="card profile-box flex-fill">
        <div class="card-body">
            <h3 class="card-title">
                Bank information
                <a href="#" class="edit-icon" data-toggle="modal" data-target="#bank_information_modal">
                    <i class="fa fa-pencil"></i>
                </a>
            </h3>

            <ul class="personal-info">

                <li>
                    <div class="title">Bank name</div>
                    <div class="text">{{ $users->bank_name ?? 'No data' }}</div>
                </li>

                <li>
                    <div class="title">Bank account No.</div>
                    <div class="text">{{ $users->bank_account_no ?? 'No data' }}</div>
                </li>

                <li>
                    <div class="title">IFSC Code</div>
                    <div class="text">{{ $users->ifsc_code ?? 'No data' }}</div>
                </li>

                <li>
                    <div class="title">PAN No</div>
                    <div class="text">{{ $users->pan_no ?? 'No data' }}</div>
                </li>

            </ul>
        </div>
    </div>
</div>
                              <div class="col-md-6 d-flex">
    <div class="card profile-box flex-fill">
        <div class="card-body">
            <h3 class="card-title">Family Informations
                <a href="#" class="edit-icon" data-toggle="modal" data-target="#add_family_modal">
                    <i class="fa fa-plus"></i>
                </a>
            </h3>

            <div class="table-responsive">
                <table class="table table-nowrap">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Relationship</th>
                            <th>Date of Birth</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($family as $f)
                        <tr>
                            <td>{{ $f->name }}</td>
                            <td>{{ $f->relationship }}</td>
                            <td>{{ $f->dob ? \Carbon\Carbon::parse($f->dob)->format('M d, Y') : '-' }}</td>
                            <td>{{ $f->phone }}</td>
                            <td class="text-right">
                                <a href="#" data-toggle="modal" data-target="#edit_family_modal_{{ $f->id }}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="{{ route('family.delete', $f->id) }}" onclick="return confirm('Are you sure?')">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div id="edit_family_modal_{{ $f->id }}" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Family Member</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('family.update', $f->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" value="{{ $f->name }}" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Relationship</label>
                                                <input type="text" name="relationship" value="{{ $f->relationship }}" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <input type="date" name="dob" value="{{ $f->dob }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text" name="phone" value="{{ $f->phone }}" class="form-control">
                                            </div>
                                            <div class="submit-section mt-2">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5">No family information found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 d-flex">
    <div class="card profile-box flex-fill">
        <div class="card-body">
            <h3 class="card-title">
                excation Informations 
                <a href="#" class="edit-icon" data-toggle="modal" data-target="#excation_info">
                    <i class="fa fa-plus"></i>
                </a>
            </h3>
            <div class="table-responsive">
                <table class="table table-nowrap">
                    <thead>
                        <tr>
                            <th>Institution</th>
                            <th>Subject</th>
                            <th>Degree</th>
                            <th>Period</th>
                            <th>Grade</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($education as $edu)
                        <tr>
                            <td>{{ $edu->institution }}</td>
                            <td>{{ $edu->subject }}</td>
                            <td>{{ $edu->degree }}</td>
                            <td>{{ $edu->start_date ? \Carbon\Carbon::parse($edu->start_date)->format('Y') : '-' }} - {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('Y') : '-' }}</td>
                            <td>{{ $edu->grade }}</td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#education_edit_modal_{{ $edu->id }}">
                                            <i class="fa fa-pencil m-r-5"></i> Edit
                                        </a>
                                        <a href="{{ route('education.delete', $edu->id) }}" class="dropdown-item">
                                            <i class="fa fa-trash-o m-r-5"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                         
                          <div class="modal fade" id="education_edit_modal_{{ $edu->id }}" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Education</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="{{ route('education.update', $edu->id) }}" method="POST">
                    @csrf

                    <input type="hidden" name="user_id" value="{{ $edu->user_id }}">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Institution</label>
                                <input type="text" class="form-control" name="institution" value="{{ $edu->institution }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" class="form-control" name="subject" value="{{ $edu->subject }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Degree</label>
                                <input type="text" class="form-control" name="degree" value="{{ $edu->degree }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Grade</label>
                                <input type="text" class="form-control" name="grade" value="{{ $edu->grade }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="start_date" value="{{ $edu->start_date }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" class="form-control" name="end_date" value="{{ $edu->end_date }}">
                            </div>
                        </div>

                    </div>

                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

                        @empty
                        <tr>
                            <td colspan="6">No excation information found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                     <div class="col-md-6 d-flex">
    <div class="card profile-box flex-fill">
        <div class="card-body">
            <h3 class="card-title">
                Experience Informations 
                <a href="#" class="edit-icon" data-toggle="modal" data-target="#experience_info">
                    <i class="fa fa-plus"></i>
                </a>
            </h3>
            <div class="table-responsive">
                <table class="table table-nowrap">
                    <thead>
                        <tr>
                            <th>Company name</th>
                            <th>Location</th>
                            <th>Job position</th>
                            <th>Period from</th>
                            <th>Period to </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($experience as $ex)
                        <tr>
                            <td>{{ $ex->company_name }}</td>
                            <td>{{ $ex->location }}</td>
                            <td>{{ $ex->job_position}}</td>
                             <td>
    {{ $ex->period_from ? \Carbon\Carbon::parse($ex->period_from)->format('Y') : '-' }} 
    
   
</td>
                            <td> {{ $ex->period_to ? \Carbon\Carbon::parse($ex->period_to)->format('Y') : '-' }}</td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#experience_edit_modal_{{ $ex->id }}">
                                            <i class="fa fa-pencil m-r-5"></i> Edit
                                        </a>
                                        <a href="{{ route('experience.delete', $ex->id) }}" class="dropdown-item">
                                            <i class="fa fa-trash-o m-r-5"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="experience_edit_modal_{{ $ex->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit experience</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('experience.update', $ex->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Company name</label>
                                                <input type="text" name="company name" class="form-control" value="{{ $ex->company_name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input type="text" name="location" class="form-control" value="{{ $ex->location}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Job_position</label>
                                                <input type="text" name="job_position" class="form-control" value="{{ $ex->job_position}}">
                                            </div>
                                            <div class="form-group">
                                                <label>period_from</label>
                                                <input type="date" name="period_from" class="form-control" value="{{ $ex->period_from }}">
                                            </div>
                                            <div class="form-group">
                                                <label>period_to</label>
                                                <input type="date" name="period_to" class="form-control" value="{{ $ex->period_to }}">
                                            </div>
                                           
                                            <button type="submit" class="btn btn-primary mt-2">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="6">No experience information found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                    </div>
                </div>
                <!-- /Profile Info Tab -->
                
                <!-- Projects Tab -->
                <div class="tab-pane fade" id="emp_projects">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown profile-action">
                                        <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-target="#edit_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a data-target="#delete_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                    <h4 class="project-title"><a href="project-view.html">Office Management</a></h4>
                                    <small class="block text-ellipsis m-b-15">
                                        <span class="text-xs">1</span> <span class="text-muted">open tasks, </span>
                                        <span class="text-xs">9</span> <span class="text-muted">tasks completed</span>
                                    </small>
                                    <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. When an unknown printer took a galley of type and
                                        scrambled it...
                                    </p>
                                    <div class="pro-deadline m-b-15">
                                        <div class="sub-title">
                                            Deadline:
                                        </div>
                                        <div class="text-muted">
                                            17 Apr 2019
                                        </div>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>Project Leader :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>Team :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Doe"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Richard Miles"><img alt="" src="assets/img/profiles/avatar-09.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Smith"><img alt="" src="assets/img/profiles/avatar-10.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Mike Litorus"><img alt="" src="assets/img/profiles/avatar-05.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" class="all-users">+15</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="m-b-5">Progress <span class="text-success float-right">40%</span></p>
                                    <div class="progress progress-xs mb-0">
                                        <div style="width: 40%" title="" data-toggle="tooltip" role="progressbar" class="progress-bar bg-success" data-original-title="40%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown profile-action">
                                        <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-target="#edit_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a data-target="#delete_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                    <h4 class="project-title"><a href="project-view.html">Project Management</a></h4>
                                    <small class="block text-ellipsis m-b-15">
                                        <span class="text-xs">2</span> <span class="text-muted">open tasks, </span>
                                        <span class="text-xs">5</span> <span class="text-muted">tasks completed</span>
                                    </small>
                                    <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. When an unknown printer took a galley of type and
                                        scrambled it...
                                    </p>
                                    <div class="pro-deadline m-b-15">
                                        <div class="sub-title">
                                            Deadline:
                                        </div>
                                        <div class="text-muted">
                                            17 Apr 2019
                                        </div>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>Project Leader :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>Team :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Doe"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Richard Miles"><img alt="" src="assets/img/profiles/avatar-09.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Smith"><img alt="" src="assets/img/profiles/avatar-10.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Mike Litorus"><img alt="" src="assets/img/profiles/avatar-05.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" class="all-users">+15</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="m-b-5">Progress <span class="text-success float-right">40%</span></p>
                                    <div class="progress progress-xs mb-0">
                                        <div style="width: 40%" title="" data-toggle="tooltip" role="progressbar" class="progress-bar bg-success" data-original-title="40%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown profile-action">
                                        <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-target="#edit_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a data-target="#delete_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                    <h4 class="project-title"><a href="project-view.html">Video Calling App</a></h4>
                                    <small class="block text-ellipsis m-b-15">
                                        <span class="text-xs">3</span> <span class="text-muted">open tasks, </span>
                                        <span class="text-xs">3</span> <span class="text-muted">tasks completed</span>
                                    </small>
                                    <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. When an unknown printer took a galley of type and
                                        scrambled it...
                                    </p>
                                    <div class="pro-deadline m-b-15">
                                        <div class="sub-title">
                                            Deadline:
                                        </div>
                                        <div class="text-muted">
                                            17 Apr 2019
                                        </div>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>Project Leader :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>Team :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Doe"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Richard Miles"><img alt="" src="assets/img/profiles/avatar-09.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Smith"><img alt="" src="assets/img/profiles/avatar-10.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Mike Litorus"><img alt="" src="assets/img/profiles/avatar-05.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" class="all-users">+15</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="m-b-5">Progress <span class="text-success float-right">40%</span></p>
                                    <div class="progress progress-xs mb-0">
                                        <div style="width: 40%" title="" data-toggle="tooltip" role="progressbar" class="progress-bar bg-success" data-original-title="40%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown profile-action">
                                        <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-target="#edit_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a data-target="#delete_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                    <h4 class="project-title"><a href="project-view.html">Hospital Administration</a></h4>
                                    <small class="block text-ellipsis m-b-15">
                                        <span class="text-xs">12</span> <span class="text-muted">open tasks, </span>
                                        <span class="text-xs">4</span> <span class="text-muted">tasks completed</span>
                                    </small>
                                    <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. When an unknown printer took a galley of type and
                                        scrambled it...
                                    </p>
                                    <div class="pro-deadline m-b-15">
                                        <div class="sub-title">
                                            Deadline:
                                        </div>
                                        <div class="text-muted">
                                            17 Apr 2019
                                        </div>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>Project Leader :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>Team :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Doe"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Richard Miles"><img alt="" src="assets/img/profiles/avatar-09.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Smith"><img alt="" src="assets/img/profiles/avatar-10.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Mike Litorus"><img alt="" src="assets/img/profiles/avatar-05.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" class="all-users">+15</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="m-b-5">Progress <span class="text-success float-right">40%</span></p>
                                    <div class="progress progress-xs mb-0">
                                        <div style="width: 40%" title="" data-toggle="tooltip" role="progressbar" class="progress-bar bg-success" data-original-title="40%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Projects Tab -->
                
                <!-- Bank Statutory Tab -->
                <div class="tab-pane fade" id="bank_statutory">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"> Basic Salary Information</h3>
                            <form>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Salary basis <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>Select salary basis type</option>
                                                <option>Hourly</option>
                                                <option>Daily</option>
                                                <option>Weekly</option>
                                                <option>Monthly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Salary amount <small class="text-muted">per month</small></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Type your salary amount" value="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Payment type</label>
                                            <select class="select">
                                                <option>Select payment type</option>
                                                <option>Bank transfer</option>
                                                <option>Check</option>
                                                <option>Cash</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h3 class="card-title"> PF Information</h3>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">PF contribution</label>
                                            <select class="select">
                                                <option>Select PF contribution</option>
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">PF No. <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>Select PF contribution</option>
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Employee PF rate</label>
                                            <select class="select">
                                                <option>Select PF contribution</option>
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Additional rate <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>Select additional rate</option>
                                                <option>0%</option>
                                                <option>1%</option>
                                                <option>2%</option>
                                                <option>3%</option>
                                                <option>4%</option>
                                                <option>5%</option>
                                                <option>6%</option>
                                                <option>7%</option>
                                                <option>8%</option>
                                                <option>9%</option>
                                                <option>10%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Total rate</label>
                                            <input type="text" class="form-control" placeholder="N/A" value="11%">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Employee PF rate</label>
                                            <select class="select">
                                                <option>Select PF contribution</option>
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Additional rate <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>Select additional rate</option>
                                                <option>0%</option>
                                                <option>1%</option>
                                                <option>2%</option>
                                                <option>3%</option>
                                                <option>4%</option>
                                                <option>5%</option>
                                                <option>6%</option>
                                                <option>7%</option>
                                                <option>8%</option>
                                                <option>9%</option>
                                                <option>10%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Total rate</label>
                                            <input type="text" class="form-control" placeholder="N/A" value="11%">
                                        </div>
                                    </div>
                                </div>
                                
                                <hr>
                                <h3 class="card-title"> ESI Information</h3>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">ESI contribution</label>
                                            <select class="select">
                                                <option>Select ESI contribution</option>
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">ESI No. <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>Select ESI contribution</option>
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Employee ESI rate</label>
                                            <select class="select">
                                                <option>Select ESI contribution</option>
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Additional rate <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>Select additional rate</option>
                                                <option>0%</option>
                                                <option>1%</option>
                                                <option>2%</option>
                                                <option>3%</option>
                                                <option>4%</option>
                                                <option>5%</option>
                                                <option>6%</option>
                                                <option>7%</option>
                                                <option>8%</option>
                                                <option>9%</option>
                                                <option>10%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Total rate</label>
                                            <input type="text" class="form-control" placeholder="N/A" value="11%">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Bank Statutory Tab -->
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Profile Modal -->
        <div id="profile_info" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profile Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Avatar Upload -->
                        <div class="col-md-12">
                            <div class="profile-img-wrap edit-img">
                                <img class="inline-block" src="{{ URL::to('/assets/images/' . ($users->avatar ?? 'default.png')) }}" alt="{{ $users->name ?? '' }}">
                                <div class="fileupload btn">
                                    <span class="btn-text">edit</span>
                                    <input class="upload" type="file" id="image" name="images">
                                    <input type="hidden" name="hidden_image" value="{{ $users->avatar ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Full Name -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $users->name ?? '' }}">
                                <input type="hidden" name="user_id" value="{{ $users->user_id ?? '' }}">
                                <input type="hidden" name="email" value="{{ $users->email ?? '' }}">
                            </div>
                        </div>

                        <!-- Birth Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Birth Date</label>
                                <input class="form-control datetimepicker" type="text" name="birth_date" value="{{ $users->birth_date ?? '' }}">
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="select form-control" name="gender">
                                    <option value="Male" {{ (isset($users) && $users->gender == 'Male') ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ (isset($users) && $users->gender == 'Female') ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" value="{{ $users->address ?? '' }}">
                            </div>
                        </div>

                        <!-- State -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" class="form-control" name="state" value="{{ $users->state ?? '' }}">
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Country</label>
                                <input type="text" class="form-control" name="country" value="{{ $users->country ?? '' }}">
                            </div>
                        </div>

                        <!-- Pin Code -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pin Code</label>
                                <input type="text" class="form-control" name="pin_code" value="{{ $users->pin_code ?? '' }}">
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" class="form-control" name="phone_number" value="{{ $users->phone_number ?? '' }}">
                            </div>
                        </div>

                        <!-- Department -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Department <span class="text-danger">*</span></label>
                                <select class="select" name="department">
                                    <option value="Web Development" {{ (isset($users) && $users->department == 'Web Development') ? 'selected' : '' }}>Web Development</option>
                                    <option value="IT Management" {{ (isset($users) && $users->department == 'IT Management') ? 'selected' : '' }}>IT Management</option>
                                    <option value="Marketing" {{ (isset($users) && $users->department == 'Marketing') ? 'selected' : '' }}>Marketing</option>
                                </select>
                            </div>
                        </div>

                        <!-- Designation -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Designation <span class="text-danger">*</span></label>
                                <select class="select" name="designation">
                                    <option value="Web Designer" {{ (isset($users) && $users->designation == 'Web Designer') ? 'selected' : '' }}>Web Designer</option>
                                    <option value="Web Developer" {{ (isset($users) && $users->designation == 'Web Developer') ? 'selected' : '' }}>Web Developer</option>
                                    <option value="Android Developer" {{ (isset($users) && $users->designation == 'Android Developer') ? 'selected' : '' }}>Android Developer</option>
                                </select>
                            </div>
                        </div>

                        <!-- Reports To -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Reports To <span class="text-danger">*</span></label>
                                <select class="select" name="reports_to">
                                    @foreach($user as $u)
                                        <option value="{{ $u->name }}" {{ (isset($users) && $users->reports_to == $u->name) ? 'selected' : '' }}>{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
        <!-- /Profile Modal -->
    
        <!-- Personal Info Modal -->
        <div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Personal Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('user/information/save') }}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" name="user_id" value="{{ $users->user_id }}" readonly>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Passport No</label>
                                        <input type="text" class="form-control @error('passport_no') is-invalid @enderror" name="passport_no" value="{{ $users->passport_no }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Passport Expiry Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker @error('passport_expiry_date') is-invalid @enderror" type="text" name="passport_expiry_date" value="{{ $users->passport_expiry_date }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tel</label>
                                        <input class="form-control @error('tel') is-invalid @enderror" type="text" name="tel" value="{{ $users->tel }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nationality <span class="text-danger">*</span></label>
                                        <input class="form-control @error('nationality') is-invalid @enderror" type="text" name="nationality" value="{{ $users->nationality }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Religion</label>
                                        <div class="form-group">
                                            <input class="form-control @error('religion') is-invalid @enderror" type="text" name="religion" value="{{ $users->religion }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Marital status <span class="text-danger">*</span></label>
                                        <select class="select form-control @error('marital_status') is-invalid @enderror" name="marital_status">
                                            <option value="{{ $users->marital_status }}" {{ ( $users->marital_status == $users->marital_status) ? 'selected' : '' }} > {{ $users->marital_status }} </option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Employment of spouse</label>
                                        <input class="form-control @error('employment_of_spouse') is-invalid @enderror" type="text" name="employment_of_spouse" value="{{ $users->employment_of_spouse }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No. of children </label>
                                        <input class="form-control @error('children') is-invalid @enderror" type="text" name="children" value="{{ $users->children }}">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Personal Info Modal -->

        <!-- Bank information Modal -->
            <div id="bank_information_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Bank Information</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="{{ route('bank.save') }}" method="POST">
                    @csrf

                    <input type="hidden" name="user_id" value="{{ $users->user_id }}">

                    <div class="row">

                        <div class="col-md-6">
                            <label>Bank Name</label>
                            <input type="text" name="bank_name"
                                   class="form-control"
                                   value="{{ $bank->bank_name ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label>Bank Account No</label>
                            <input type="text" name="bank_account_no"
                                   class="form-control"
                                   value="{{ $bank->bank_account_no ?? '' }}"
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        </div>

                        <div class="col-md-6">
                            <label>IFSC Code</label>
                            <input type="text" name="ifsc_code"
                                   class="form-control"
                                   value="{{ $bank->ifsc_code ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label>PAN No</label>
                            <input type="text" name="pan_no"
                                   class="form-control"
                                   value="{{ $bank->pan_no ?? '' }}">
                        </div>

                    </div>

                    <div class="submit-section mt-3">
                        <button type="submit" class="btn btn-primary">
                            Save / Update
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
        <!-- /Bank information Modal -->
        
        <!-- Family Info Modal -->
  <div id="add_family_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Family Informations</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('family.save') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $users->user_id ?? null }}">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Relationship</label>
                            <input type="text" name="relationship" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Date of Birth</label>
                            <input type="date" name="dob" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                    </div>
                    <div class="submit-section mt-3">
                        <button type="submit" class="btn btn-primary">Save / Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        <!-- /Family Info Modal -->
        
        <!-- Emergency Contact Modal -->
        <div id="emergency_contact_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Personal Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="validation" action="{{ route('user/profile/emergency/contact/save') }}" method="POST">
                            @csrf
                            <input type="text" class="form-control" name="user_id" value="{{ $users->user_id }}">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Primary Contact</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                @if (!empty($users->name_primary))
                                                <input type="text" class="form-control" name="name_primary" value="{{ $users->name_primary }}">
                                                @else
                                                <input type="text" class="form-control" name="name_primary">
                                                @endif
                                            </li>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relationship <span class="text-danger">*</span></label>
                                                @if (!empty($users->relationship_primary))
                                                <input type="text" class="form-control" name="relationship_primary" value="{{ $users->relationship_primary }}">
                                                @else
                                                <input type="text" class="form-control" name="relationship_primary">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone <span class="text-danger">*</span></label>
                                                @if (!empty($users->phone_primary))
                                                <input type="text" class="form-control" name="phone_primary" value="{{ $users->phone_primary }}">
                                                @else
                                                <input type="text" class="form-control" name="phone_primary">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone 2</label>
                                                @if (!empty($users->phone_2_primary))
                                                <input type="text" class="form-control" name="phone_2_primary" value="{{ $users->phone_2_primary }}">
                                                @else
                                                <input type="text" class="form-control" name="phone_2_primary">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Secondary Contact</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                @if (!empty($users->name_secondary))
                                                <input type="text" class="form-control" name="name_secondary" value="{{ $users->name_secondary }}">
                                                @else
                                                <input type="text" class="form-control" name="name_secondary">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relationship <span class="text-danger">*</span></label>
                                                @if (!empty($users->relationship_secondary))
                                                <input type="text" class="form-control" name="relationship_secondary" value="{{ $users->relationship_secondary }}">
                                                @else
                                                <input type="text" class="form-control" name="relationship_secondary">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone <span class="text-danger">*</span></label>
                                                @if (!empty($users->phone_secondary))
                                                <input type="text" class="form-control" name="phone_secondary" value="{{ $users->phone_secondary }}">
                                                @else
                                                <input type="text" class="form-control" name="phone_secondary">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone 2</label>
                                                @if (!empty($users->phone_2_secondary))
                                                <input type="text" class="form-control" name="phone_2_secondary" value="{{ $users->phone_2_secondary }}">
                                                @else
                                                <input type="text" class="form-control" name="phone_2_secondary">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Emergency Contact Modal -->
        
        <!-- excation Modal -->
             <div id="excation_info" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">excation Informations</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('education.save') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $users->user_id ?? null }}">
                    <div class="form-scroll">
                        <div class="excation-card row">
                            <div class="col-md-6">
                                <label>Institution</label>
                                <input type="text" name="institution" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Subject</label>
                                <input type="text" name="subject" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Degree</label>
                                <input type="text" name="degree" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Grade</label>
                                <input type="text" name="grade" class="form-control">
                            </div>
                        </div>
                        <div class="add-more mt-2">
                            <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                        </div>
                    </div>
                    <div class="submit-section mt-3">
                        <button type="submit" class="btn btn-primary">Save / Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        <!-- /excation Modal -->
   
        <!-- Experience Modal -->
                              <div id="experience_info" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Experience Informations</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('experience.save') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $users->user_id ?? null }}">
                    <div class="form-scroll">
                        <div class="excation-card row">
                            <div class="col-md-6">
                                <label>Company_name</label>
                                <input type="text" name="company_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Location</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Job_position</label>
                                <input type="text" name="job_position" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Period_from</label>
                                <input type="date" name="period_from" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Period_to</label>
                                <input type="date" name="period_to" class="form-control">
                            </div>
                        
                        </div>
                        <div class="add-more mt-2">
                            <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                        </div>
                    </div>
                    <div class="submit-section mt-3">
                        <button type="submit" class="btn btn-primary">Save / Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        <!-- /Experience Modal -->
    <!-- /Page Content -->
    </div>
    @section('script')
    <script>
        $('#validation').validate({  
            rules: {  
                name_primary: 'required',  
                relationship_primary: 'required',  
                phone_primary: 'required',  
                phone_2_primary: 'required',  
                name_secondary: 'required',  
                relationship_secondary: 'required',  
                phone_secondary: 'required',  
                phone_2_secondary: 'required',  
            },  
            messages: {
                name_primary: 'Please input name primary',  
                relationship_primary: 'Please input relationship primary',  
                phone_primary: 'Please input phone primary',  
                phone_2_primary: 'Please input phone 2 primary',  
                name_secondary: 'Please input name secondary',  
                relationship_secondary: 'Please input relationship secondary',  
                phone_secondaryr: 'Please input phone secondary',  
                phone_2_secondary: 'Please input phone 2 secondary',  
            },  
            submitHandler: function(form) {  
                form.submit();
            }  
        });  
        function editBank(bank_name, account_no, ifsc, pan, user_id)
{
    document.getElementById('bank_name').value = bank_name;
    document.getElementById('bank_account_no').value = account_no;
    document.getElementById('ifsc_code').value = ifsc;
    document.getElementById('pan_no').value = pan;
    document.getElementById('user_id').value = user_id;
}
    </script>
    @endsection
@endsection