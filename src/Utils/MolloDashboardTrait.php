<?php
/**
 *  Mollo Dashboard Trait
 *
 */


namespace Drupal\mollo_dashboard\Utils;


use Drupal\node\Entity\NodeType;

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

  /**
   * @return array
   */
  protected function getOptionsListOfNodeTypes(): array {
    $types = NodeType::loadMultiple();

    // Add Node types to Options Array
    $options_node_type = [];
    foreach ($types as $key => $type) {
      $options_node_type[$key] = $type->label();
    }
    return $options_node_type;
  }

  /**
   * @return array
   */
  protected function getOptionsPositions(): array {

    $options['top-1'] = 'Top 1';
    $options['top-2'] = 'Top 2';
    $options['top-3'] = 'Top 3';
    $options['left-1'] = 'Left 1';
    $options['right-1'] = 'Right 1';

    return $options;
  }

}
