<?php

if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}
if (!function_exists('order_by_field')) {

    /**
     * Get ordered by field string
     *
     *
     * @param string $field
     * @param array  $values
     * @return string
     */
    function order_by_field(string $field, array $values): string
    {
        $conditions = "";

        array_walk(
            $values,
            function ($value, $index) use (&$conditions) {
                $conditions .= "WHEN $value THEN $index ";
            }
        );

        return sprintf('CASE %s %s END', $field, $conditions);
    }
}
