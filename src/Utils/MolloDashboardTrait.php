<?php
/**
 *  Mollo Dashboard Trait
 *
 */


namespace Drupal\mollo_dashboard\Utils;


trait MolloDashboardTrait {

  /**
   * Name of our module.
   *
   * @return string
   *   A module name.
   */

  protected function getModuleName(): string {
    return 'mollo_dashboard';
  }

  /**
   * Get full path to the template.
   *
   * @return string
   *   Path string.
   */
  protected function getTemplatePath(): string {
    return drupal_get_path('module', $this->getModuleName()) .
      '/templates/';
  }

}
