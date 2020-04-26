<?php

namespace Jascha030\WP\Utilities\Template;

if (! defined('ABSPATH')) {
    die("Forbidden");
} // Abandon ship.

if (! class_exists('Jascha030\WP\Utilities\Template\TemplateRenderer')) {
    /**
     * Class TemplateRenderer
     *
     * @package Jascha030\WP\Utilities\Template
     */
    class TemplateRenderer
    {
        /**
         * Path to root folder
         *
         * @var string
         */
        public $templateRoot;

        /**
         * TemplateRenderer constructor.
         *
         * @param string $templateRoot
         */
        public function __construct(string $templateRoot)
        {
            $this->templateRoot = $templateRoot;
        }

        /**
         * @param $template
         * @param array|null $arguments
         *
         * @return false|string
         */
        public function renderTemplate($template, array $arguments = null)
        {
            $path = "{$this->templateRoot}/{$template}";

            if (! file_exists($path)) {
                throw new Exception("Path: {$path} is invalid.");
            }

            ob_start();

            if ($arguments) {
                foreach ($arguments as $key => $value) {
                    ${$key} = $value;
                }
            }

            include $path;

            return ob_get_clean();
        }
    }
}
