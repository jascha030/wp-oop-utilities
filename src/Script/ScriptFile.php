<?php

namespace Jascha030\WP\Utilities\Script;

if (! defined('ABSPATH')) {
    die("Forbidden");
} // Abandon ship.

if (! class_exists('Jascha030\WP\Utilities\Script\ScriptFile')) {
    /**
     * Class ScriptFile
     *
     * @package Jascha030\WP\Utilities\Script
     */
    class ScriptFile
    {
        /**
         * @var string
         */
        private $handle;

        /**
         * @var string
         */
        private $src;

        /**
         * @var bool
         */
        private $enqueued;

        /**
         * @var
         */
        private $dependencies;

        /**
         * ScriptFile constructor.
         *
         * @param string $handle
         * @param string $src
         * @param array|null $dependencies
         */
        public function __construct(string $handle, string $src, array $dependencies = null)
        {
            $this->handle = $handle;

            $this->src = $src;

            $this->dependencies = (! empty($dependencies)) ? $dependencies : ['jquery'];
        }

        /**
         * @return string
         */
        public function getHandle(): string
        {
            return $this->handle;
        }

        /**
         * @return bool
         */
        public function isEnqueued(): bool
        {
            return $this->enqueued;
        }

        /**
         * Register script
         */
        public function register()
        {
            wp_register_script($this->handle, $this->src, $this->dependencies);
        }

        /**
         * Enqueue script
         */
        public function enqueue()
        {
            if (! $this->isEnqueued()) {
                $this->enqueued = true;

                wp_enqueue_script($this->handle);
            }
        }
    }
}
