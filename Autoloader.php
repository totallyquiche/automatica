<?php declare(strict_types=1);

namespace TotallyQuiche\Automatica;

final class Autoloader
{
    /**
     * A map of vendor namespace prefixes to the location on the filesystem.
     *
     * Example: ['TotallyQuiche\Autoloader' => './Autoloader/']
     *
     * @var array
     */
    private $vendor_namespaces;

    /**
     * The base file path for the Autoloader.
     *
     * @var string
     */
    private $base_file_path;

    /**
     * Instantiate the object. Set the vendor namespaces.
     *
     * @param array  $vendor_namespaces
     * @param string $base_file_path
     *
     * @return void
     */
    public function __construct(array $vendor_namespaces = [], string $base_file_path = './')
    {
        $this->vendor_namespaces = $vendor_namespaces;
        $this->base_file_path = $base_file_path;
    }

    /**
     * Register the autoload method for this Autoloader.
     *
     * @return void
     */
    public function register() : void
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * The autolaod method. Given a fully qualified class name, this will require
     * the PHP file containing the class definition.
     *
     * @param string $fully_qualified_class_name
     *
     * @return void
     */
    public function autoload(string $fully_qualified_class_name) : void
    {
        $vendor_namespce = '';
        $namespace_parts = explode('\\', $fully_qualified_class_name);

        // Remove the class name before checking for vendor namespace prefixes
        array_pop($namespace_parts);

        // Check for vendor namespace prefixes. If a match is not found, remove
        // the last namespace segment and try again.
        while (!empty($namespace_parts)) {
            $vendor_namespce = implode('\\', $namespace_parts);

            if (isset($this->vendor_namespaces[$vendor_namespce])) {
                $this->base_file_path = $this->vendor_namespaces[$vendor_namespce];
                break;
            } else {
                array_pop($namespace_parts);
            }
        }

        $full_file_path = $this->base_file_path . $this->createFilePathFromClassName(
            $vendor_namespce,
            $fully_qualified_class_name
        );

        require_once($full_file_path);
    }

    /**
     * Given a vendor namespace and a fully qualified class name, this will return
     * the path to the PHP file containing the class definition.
     *
     * @param string $vendor_namespace
     * @param string $fully_qualified_class_name
     *
     * @return string
     */
    private function createFilePathFromClassName(string $vendor_namespace, string $fully_qualified_class_name) : string
    {
        return str_replace(
            [$vendor_namespace . '\\', '\\'],
            ['', DIRECTORY_SEPARATOR],
            $fully_qualified_class_name
        ) . '.php';
    }
}