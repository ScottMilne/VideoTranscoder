@extends('layouts.app')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 mr-auto ml-auto mt-5">

        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('message') }}

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                <!-- file drag form-->
                <div class="file-drop-area mb-3">
                    <span class="file-btn">Choose files</span>
                    <span class="file-msg">or drag and drop files here</span>
                    <input class="file-input" type="file" name="video">
                </div>

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
                //form variables
                var $fileInput = $('.file-input');
                var $droparea = $('.file-drop-area');

                // highlight drag area
                $fileInput.on('dragenter focus click', function() {
                    $droparea.addClass('is-active');
                });

                // back to normal state
                $fileInput.on('dragleave blur drop', function() {
                    $droparea.removeClass('is-active');
                });

                // change inner text
                $fileInput.on('change', function() {
                    var filesCount = $(this)[0].files.length;
                    var $textContainer = $(this).prev();

                    if (filesCount === 1) {
                        // if single file is selected, show file name
                        var fileName = $(this).val().split('\\').pop();
                        $textContainer.text(fileName);
                    } else {
                        // otherwise show number of files
                        $textContainer.text(filesCount + ' files selected');
                    }
                });

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

<style>
    .file-drop-area {
        position: relative;
        display: flex;
        align-items: center;
        width: 450px;
        max-width: 100%;
        padding: 25px;
        border: 1px dashed rgba(129, 129, 129);
        border-radius: 3px;
        transition: 0.2s;
    }

    .is-active {
        background-color: rgb(123 184 255 / 21%);
    }

    .file-btn {
        flex-shrink: 0;
        background-color: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 3px;
        padding: 8px 15px;
        margin-right: 10px;
        font-size: 12px;
        text-transform: uppercase;
    }

    .file-drop-area input {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        cursor: pointer;
        opacity: 0;
         !important
    }

</style>
