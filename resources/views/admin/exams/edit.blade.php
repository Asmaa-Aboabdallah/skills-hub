@extends('admin.layout')



@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Edit Exam</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit</li>
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
                    <div class="col-12 pb-3">
                        @include('admin.inc.errors')
                        <form method="POST" action="{{ url("dashboard/exams/update/$exam->id") }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Name (en)</label>
                                            <input type="text" name="name_en" class="form-control" value="{{ $exam->name('en') }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Name (ar)</label>
                                            <input type="text" name="name_ar" class="form-control" value="{{ $exam->name('ar') }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Description (en)</label>
                                            <textarea name="desc_en" rows="5" class="form-control">{{ $exam->desc('en') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Description (ar)</label>
                                            <textarea name="desc_ar" rows="5" class="form-control">{{ $exam->desc('ar') }}</textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Skill</label>
                                            <select class="custom-select form-control" name="skill_id">
                                                @foreach ($skills as $skill)
                                                    <option value="{{ $skill->id }}" @if ($exam->skill_id == $skill->id) selected @endif >{{ $skill->name('en') }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="img">
                                                    <label class="custom-file-label">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Difficulty</label>
                                            <input type="number" name="difficulty"  class="form-control" value="{{ $exam->difficulty }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Duration (mins.)</label>
                                            <input type="number" name="duration_mins"  class="form-control" value="{{ $exam->duration_mins }}">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                                </div>
                        </form>

                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
