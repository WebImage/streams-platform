<?php namespace Anomaly\Streams\Platform\Ui\Icon;

/**
 * Class IconRegistry
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Icon
 */
class IconRegistry
{

    /**
     * Available icon.
     *
     * @var array
     */
    protected $icons = [
        'folder-open'  => 'glyphicons glyphicons-folder-open',
        'glyphicons'   => 'glyphicons glyphicons-eyedropper',
        'cloud-upload' => 'fa fa-cloud-upload',
        'map-marker'   => 'fa fa-map-marker',
        'dashboard'    => 'fa fa-dashboard',
        'arrows-h'     => 'fa fa-arrows-h',
        'arrows-v'     => 'fa fa-arrows-v',
        'options'      => 'fa fa-options',
        'refresh'      => 'fa fa-refresh',
        'warning'      => 'fa fa-warning',
        'upload'       => 'fa fa-upload',
        'search'       => 'fa fa-search',
        'pencil'       => 'fa fa-pencil',
        'users'        => 'fa fa-users',
        'trash'        => 'fa fa-trash',
        'check'        => 'fa fa-check',
        'save'         => 'fa fa-save',
        'cog'          => 'fa fa-cog'
    ];

    /**
     * Get a button.
     *
     * @param  $icon
     * @return array|null
     */
    public function get($icon)
    {
        return array_get($this->icons, $icon, $icon);
    }

    /**
     * Register a button.
     *
     * @param       $icon
     * @param array $parameters
     * @return $this
     */
    public function register($icon, array $parameters)
    {
        array_set($this->icons, $icon, $parameters);

        return $this;
    }
}