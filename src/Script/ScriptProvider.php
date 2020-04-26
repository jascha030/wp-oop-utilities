<?php

namespace Jascha030\WP\Utilities\Script;

use Exception;
use Jascha030\WP\Subscriptions\Provider\ActionProvider;
use Jascha030\WP\Subscriptions\Provider\Provider;

if (! defined('ABSPATH')) {
    die("Forbidden");
} // Abandon ship.

if (! class_exists('Jascha030\WP\Utilities\Script\ScriptProvider')) {
    /**
     * Class ScriptProvider
     *
     * @package Jascha030\WP\Utilities\Script
     */
    class ScriptProvider implements ActionProvider
    {
        USE Provider;

        protected static $actions = [
            'wp_enqueue_scripts' => 'enqueueScripts'
        ];

        /**
         * @var array
         */
        protected $scripts = [];

        /**
         * @var array
         */
        protected $enqueued = [];

        /**
         * @param array $scripts
         *
         * @throws Exception
         */
        public function setScripts(array $scripts)
        {
            foreach ($scripts as $script) {
                $this->addScript($script);
            }
        }

        /**
         * @param ScriptFile $script
         *
         * @throws Exception
         */
        public function addScript(ScriptFile $script)
        {
            if ($this->scripts[$script->getHandle()]) {
                throw new Exception('Script ' . $script->getHandle() . ' already added.');
            }

            $this->scripts[$script->getHandle()] = $script;
        }

        /**
         * @param $handle
         *
         * @throws Exception
         */
        public function enqueue($handle)
        {
            if (! $this->scripts[$handle]) {
                throw new Exception("Script '{$handle}' does not exist.");
            }

            $this->enqueued[$handle] = $this->scripts[$handle];
        }

        /**
         * Enqueue scripts
         */
        public function enqueueScripts()
        {
            foreach ($this->enqueued as $script) {
                /** @var ScriptFile $script */
                $script->enqueue();
            }
        }
    }
}
