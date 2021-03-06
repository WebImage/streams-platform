<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Model\Contract\EloquentRepositoryInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class ForceDeleteActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class ForceDelete extends ActionHandler implements SelfHandling
{

    /**
     * ForceDelete the selected entries.
     *
     * @param TableBuilder $builder
     * @param array        $selected
     */
    public function handle(TableBuilder $builder, EloquentRepositoryInterface $repository, array $selected)
    {
        $count = 0;

        $repository->setModel($builder->getTableModel());

        /* @var EloquentModel $entry */
        foreach ($selected as $id) {
            if ($entry = $repository->findTrashed($id)) {
                if ($entry->trashed() && $repository->forceDelete($entry)) {

                    $builder->fire('row_deleted', compact('builder', 'model', 'entry'));

                    $count++;
                }
            }
        }

        if ($count) {
            $builder->fire('rows_deleted', compact('count', 'builder', 'model'));
        }

        if ($selected) {
            $this->messages->success(trans('streams::message.delete_success', compact('count')));
        }
    }
}
