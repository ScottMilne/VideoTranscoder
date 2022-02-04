@extends('layouts.app')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 mr-auto ml-auto mt-5">

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <h3 class="text-center">
            Upload Video
        </h3>
        <form method="post" action="{{ route('upload', ['filetype' => 'testing']) }}" enctype="multipart/form-data">
            <div class="form-group">
                <label for="video-title">Title</label>
                <input type="text" class="form-control" name="title" placeholder="Enter video title">
                @if ($errors->has('title'))
                    <span class="text-danger">
                        {{ $errors->first('title') }}
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="exampleFormControlFile1">Video File</label>
                <input type="file" class="form-control-file" name="video">

                @if ($errors->has('video'))
                    <span class="text-danger">
                        {{ $errors->first('video') }}
                    </span>
                @endif
            </div>

            <!--Filetype Dropdown-->
            <div id="formatDropdown" class="dropdown mb-3">
                Convert to: 
                <button id="formatBtn" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Select Format
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">MP4</a>
                    <a class="dropdown-item" href="#">FLV</a>
                    <a class="dropdown-item" href="#">AVI</a>
                    <a class="dropdown-item" href="#">WEBM</a>
                    <a class="dropdown-item" href="#">WMV</a>
                    <a class="dropdown-item" href="#">MOV</a>
                    <a class="dropdown-item" href="#">MKV</a>
                    <a class="dropdown-item" href="#">MPEG-2</a>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $(".dropdown-menu a").click(function() {
                        $("#formatBtn:first-child").html($(this).text());
                    });
                });
            </script>

            <div class="form-group">
                <input type="submit" class="btn btn-primary">
            </div>

            {{ csrf_field() }}
        </form>





    </div>
@endSection
