<?php

namespace App\Jobs;

use App\Video;
use Carbon\Carbon;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\WebM;
use Pbmedia\LaravelFFMpeg\FFMpegFacade as FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $video;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$converted_name = $this->getCleanFileName($this->video->path);

        $file_type = ".webm";
        $converted_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->video->path) . $file_type;

        // open the uploaded video from the right disk...
        FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path)

            // call the 'export' method...
            ->export()

            // tell the MediaExporter to which disk and in which format we want to export...
            ->toDisk('public')
            ->inFormat(new WebM())

            // call the 'save' method with a filename...
            ->save($converted_name);

        // update the database so we know the convertion is done!
        $this->video->update([
            'converted_for_streaming_at' => Carbon::now(),
            'processed' => true,
            'stream_path' => $converted_name
        ]);
    }
}
