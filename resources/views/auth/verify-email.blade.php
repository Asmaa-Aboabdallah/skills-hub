@extends('web.layout')

@section('title')
    Verify Email
@endsection

@section('main')
    <div class="alert alert-success">
        A Verification Eamil Sent Successfully, please check your inbox 
    </div>

    <!-- Contact -->
    <div id="contact" class="section">

        <!-- container -->
        <div class="container">

            <!-- row -->
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="contact-form">
                        <form action="{{ url('/email/verification-notification') }}" method="POST">
                            @csrf
                            <button type="submit" class="main-button icon-button pull-right">Resend Email</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection