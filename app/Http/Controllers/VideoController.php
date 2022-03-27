<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Video;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    /**
     * Return video blade view and pass videos to it.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $userID = Auth::user()->id;

        $videos = Video::where(
            function ($query) use ($userID) {
                $query->where('created_by', '=', $userID);
            }
        )->get();

        return view('videos')->with('videos', $videos);
    }

    /**
     * Handles deleting video
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {

        $video = Video::find($id);
        $video->delete();

        return redirect('/')
            ->with(
                'message',
                $video->title . ' has been deleted'
            );
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
    public function store(StoreVideoRequest $request, $filetype)
    {
        $path = str_random(6) . '.' . $request->video->getClientOriginalExtension();
        $request->video->storeAs('/', $path);

        $video = Video::create([
            'disk'          => 'public',
            'original_name' => $request->video->getClientOriginalName(),
            'path'          => $path,
            'title'         => $request->video->getClientOriginalName() . ' to ' . $filetype,
            'created_by'    => Auth::user()->id,
        ]);

        ConvertVideoForStreaming::dispatch($video, $filetype);

        return redirect('/uploader')
            ->with(
                'message',
                'Your video will be available shortly after it has been processed'
            );
    }
}
