<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Video;
use Illuminate\Http\Request;
use Pbmedia\LaravelFFMpeg\FFMpegFacade as FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\WebM;

class VideoController extends Controller
{
    /**
     * Return video blade view and pass videos to it.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $videos = Video::orderBy('created_at', 'DESC')->get();
        return view('videos')->with('videos', $videos);
    }

    /**
     * Return uploader form view for uploading videos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploader()
    {
        return view('uploader');
    }

    /**
     * Handles form submission after uploader form submits
     * @param StoreVideoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVideoRequest $request)
    {

        

        $path = str_random(4) . '.' . $request->video->getClientOriginalExtension();
        $request->video->storeAs('/', $path);

        //dd("saved file");

        $video = Video::create([
            'disk'          => 'public',
            'original_name' => $request->video->getClientOriginalName(),
            'path'          => $path,
            'title'         => $request->title,
        ]);

        ConvertVideoForStreaming::dispatch($video);

        return redirect('/uploader')
            ->with(
                'message',
                'Your video will be available shortly after it has been processed'
            );
    }
}
