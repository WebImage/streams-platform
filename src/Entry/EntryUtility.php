<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Command\GenerateEntryModel;
use Anomaly\Streams\Platform\Entry\Command\GenerateEntryTranslationsModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class EntryUtility
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry
 */
class EntryUtility
{

    use DispatchesJobs;

    /**
     * Recompile entry models for a given stream.
     *
     * @param StreamInterface $stream
     */
    public function recompile(StreamInterface $stream)
    {
        // Generate the base model.
        $this->dispatch(new GenerateEntryModel($stream));

        /**
         * If the stream is translatable generate
         * the translations model too.
         */
        if ($stream->isTranslatable()) {
            $this->dispatch(new GenerateEntryTranslationsModel($stream));
        }
    }
}
