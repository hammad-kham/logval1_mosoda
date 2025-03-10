@extends('layouts.app')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">
                    Main Title <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Subtitle</small>
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">Examples</li>
                        <li class="breadcrumb-item">
                            <a href="">Blank
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right"></div>
       </div>
    </div>

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">Block Title</h3>
            </div>
            <div class="block-content">
                <p class="font-size-sm text-muted">
                    Your content..
                </p>
            </div>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->
@endsection
