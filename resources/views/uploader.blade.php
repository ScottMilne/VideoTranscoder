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
        <form id="convertForm" method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <input class="d-none" name="title" value=".">
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
                    MP4</button>
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


            <div class="form-group">
                <input type="submit" class="btn btn-primary">
            </div>

            {{ csrf_field() }}
        </form>

        <script>
            $(document).ready(function() {
                //setting form action
                var form = document.getElementById('convertForm');
                form.action = '/upload/filetype/' + "MP4";

                //On filetype change
                $(".dropdown-menu a").click(function() {
                    //change dropdown text
                    document.getElementById("formatBtn")
                    $("#formatBtn:first-child").html($(this).text());
                    var convertButtonText = $(this).text();
                    console.log(convertButtonText);

                    //updating form action
                    form.action = '/upload/filetype/' + convertButtonText;
                });
            });
        </script>



    </div>
@endSection
