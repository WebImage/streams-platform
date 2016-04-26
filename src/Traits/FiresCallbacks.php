<?php namespace Anomaly\Streams\Platform\Traits;

use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class FiresCallbacks
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Traits
 */
trait FiresCallbacks
{

    /**
     * The local callbacks.
     *
     * @var array
     */
    protected $callbacks = [];

    /**
     * The static callbacks.
     *
     * @var array
     */
    protected static $listeners = [];

    /**
     * Register a new callback.
     *
     * @param $trigger
     * @param $callback
     * @return $this
     */
    public function on($trigger, $callback)
    {
        if (!isset($this->callbacks[$trigger])) {
            $this->callbacks[$trigger] = [];
        }

        $this->callbacks[$trigger][] = $callback;

        return $this;
    }

    /**
     * Register a new listener.
     *
     * @param $trigger
     * @param $callback
     * @return $this
     */
    public function listen($trigger, $callback)
    {
        if (!isset(self::$listeners[$trigger])) {
            self::$listeners[$trigger] = [];
        }

        self::$listeners[$trigger][] = $callback;

        return $this;
    }

    /**
     * Fire a set of closures by trigger.
     *
     * @param       $trigger
     * @param array $parameters
     * @return $this
     */
    public function fire($trigger, array $parameters = [])
    {

        /**
         * Fire listeners first.
         */
        foreach (array_get(self::$listeners, $trigger, []) as $callback) {

            if (is_string($callback) || $callback instanceof \Closure) {
                app()->call($callback, $parameters);
            }

            if ($callback instanceof SelfHandling) {
                app()->call([$callback, 'handle'], $parameters);
            }
        }

        $method = camel_case('on_' . $trigger);

        if (method_exists($this, $method)) {
            app()->call([$this, $method], $parameters);
        }

        $handler = get_class($this) . ucfirst(camel_case('on_' . $trigger));

        if (class_exists($handler)) {
            app()->call($handler . '@handle', $parameters);
        }

        $observer = get_class($this) . 'Callbacks';

        if (class_exists($observer) && $observer = app($observer, $parameters)) {
            if (method_exists($observer, $method)) {
                app()->call([$observer, $method], $parameters);
            }
        }

        foreach (array_get($this->callbacks, $trigger, []) as $callback) {

            if (is_string($callback) || $callback instanceof \Closure) {
                app()->call($callback, $parameters);
            }

            if ($callback instanceof SelfHandling) {
                app()->call([$callback, 'handle'], $parameters);
            }
        }

        return $this;
    }

    /**
     * Return if the callback exists.
     *
     * @param $trigger
     * @return bool
     */
    public function hasCallback($trigger)
    {
        return isset(self::$callbacks[$trigger]);
    }
}
