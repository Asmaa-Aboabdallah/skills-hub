@extends('admin.layout')



@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Admins</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Admins</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @include('admin.inc.messages')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Admins</h3>
                                <div class="card-tools">
                                    <a href="{{ url('dashboard/admins/create') }}" class="btn btn-sm btn-primary">
                                        Add New
                                    </a>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name </th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Verified</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admins as $admin)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $admin->name }}</td>
                                                <td>{{ $admin->email }}</td>
                                                <td>{{ $admin->role->name }}</td>

                                                <td>
                                                    @if ($admin->email_verified_at !== null)
                                                        <span class="badge bg-success">Yes</span>
                                                    @else
                                                        <span class="badge bg-danger">No</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($admin->role->name == 'admin')
                                                        <a href="{{ url("dashboard/admins/promote/$admin->id") }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-level-up-alt"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ url("dashboard/admins/demote/$admin->id") }}"
                                                            class="btn btn-sm btn-secondary">
                                                            <i class="fas fa-level-down-alt"></i>
                                                        </a>
                                                    @endif

                                                    <button type="button" href="#"
                                                        class="btn btn-sm btn-info edit-btn" data-id="{{ $admin->id }}"
                                                        data-name="{{ $admin->name }}" data-email="{{ $admin->email }}"
                                                        data-toggle="modal" data-target="#edit-modal">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <a href="{{ url("dashboard/admins/delete/$admin->id")}}" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>



                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex my-3 justify-content-center">
                                    {{ $admins->links() }}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    </div>


    </div>

    <div class="modal fade" id="edit-modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">??</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('admin.inc.errors')
                    <form method="POST" action="{{ url('dashboard/admins/update') }}" id="edit-form">
                        @csrf
                        <input type="hidden" name="id" id="edit-form-id">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" id="edit-form-name">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" id="edit-form-email">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" form="edit-form" class="btn btn-primary">Submit</button>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('scripts')
   <script>
      $('.edit-btn').click(function(){
        let id = $(this).attr('data-id')
        let name = $(this).attr('data-name')
        let email = $(this).attr('data-email')

        // console.log(id , nameEn, nameAr);

        $('#edit-form-id').val(id)
        $('#edit-form-name').val(name)
        $('#edit-form-email').val(email)

      })
   </script>
@endsection