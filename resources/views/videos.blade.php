@extends('layouts.app')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mr-auto ml-auto mt-5">

        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('message') }}

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <h3 class="text-center">
            Videos
        </h3>

        @foreach ($videos as $video)
            <div class="row mt-5">
                <div class="video">
                    <div class="title">
                        <h4>
                            {{ $video->title }}
                        </h4>
                        <a href="{{ route('download', ['id' => $video->id]) }}"
                            class="btn btn-outline-primary mb-2">Download</a>
                        <a href="{{ route('destroy', ['id' => $video->id]) }}"
                            class="btn btn-outline-danger mb-2">Delete</a>
                    </div>
                    @if ($video->processed)
                        <video src="/storage/{{ $video->stream_path }}" class="w-100" controls></video>
                    @else
                        <div class="alert alert-info w-100">
                            Video processing and will be available shortly, try refreshing the page
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endSection
