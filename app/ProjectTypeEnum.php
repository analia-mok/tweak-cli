<?php

namespace App;

/**
 * Enum for declaring project types.
 */
abstract class ProjectTypeEnum
{
    const DRUPAL = 'Drupal';
    const DRUPAL_COMPOSER = 'Drupal Composer';
    const WORDPRESS = 'WordPress';
    const WORDPRESS_COMPOSER = 'WordPress Composer';
    const UNKNOWN = 'Unknown';
}
