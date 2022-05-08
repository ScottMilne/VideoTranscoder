<?php

namespace App\Jobs;

use App\Video;
use Carbon\Carbon;
use FFMpeg\Format\Video\WebM;
use Pbmedia\LaravelFFMpeg\FFMpegFacade as FFMpeg;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $video;
    public $filetype;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video, $filetype)
    {
        $this->video = $video;
        $this->filetype = $filetype;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filetype = '.'.$this->filetype;
        $converted_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->video->path) . $filetype;

        // open the uploaded video from the disk
        FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path)
            ->export()

            // tell the MediaExporter to which disk and in which format to export
            ->toDisk('public')
            ->inFormat((new WebM())-> setKiloBitrate(4000))
            ->save($converted_name);

        // update the database
        $this->video->update([
            'converted_for_streaming_at' => Carbon::now(),
            'processed' => true,
            'stream_path' => $converted_name
        ]);
    }
}
