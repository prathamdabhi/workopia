<?php

/**
 * Helper function to get patch
 * @param String $name
 * @return String
 */

function getPatch($path)
{
    return __DIR__ . "/" . $path;
}

/**
 * load view function
 * @param String $name
 */
function loadView($name, $data = [])
{
    $viewPatch =  getPatch("App/views/$name.view.php");

    if (file_exists($viewPatch)) {
        extract($data);
        require $viewPatch;
    } else {
        echo "view $name is not found";
    }
}
/**
 * load partial function
 * @param String $name
 */
function loadpartial($name, $data = [])
{
    $partialPatch =  getPatch("App/views/partials/$name.php");
    if (file_exists($partialPatch)) {
        extract($data);
        require $partialPatch;
    } else {
        echo " partial $name is not found";
    }
}
/**
 * create a inspect function for print
 * @param mixed $value
 * @return void
 */
function inspect($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

/**
 * inspect and die function
 * @param mixed $value
 * @return void
 */
function inspectAndDie($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

/**
 * Format salary function
 * @param String $salary
 * @return String
 */

function formatSalary($salary)
{
    return '$' . number_format(floatval($salary));
}

/**
 * Sanitize function
 * @param String $data
 * @return String
 */

function sanitize($data)
{
    return filter_var(trim($data), FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * redirect function
 *
 * @param String $path
 * @return void
 */
function redirect($path)
{
    header("Location: {$path}");
    exit;
}
