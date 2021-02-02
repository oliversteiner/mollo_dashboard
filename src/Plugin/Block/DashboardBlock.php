<?php

namespace Drupal\mollo_dashboard\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'mollo_dashboard_block' block.
 *
 * @Block(
 *  id = "mollo_dashboard_block",
 *  admin_label = @Translation("Dashboard"),
 *   category = @Translation("Mollo"),
 * )
 */
class DashboardBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $variables = $this->getVars();

    $build = [];
    $block = [
      '#theme' => 'dashboard_block',
      '#attached' => [
        'library' => ['mollo_dashboard/block'],
      ],
      '#attributes' => [
        'class' => ['mollo-dashboard-module'],
        'id' => 'mollo-dashboard-block',
      ],
      '#mollo_dashboard' => $variables,
      '#cache' => [
        'max-age' => 0,
      ],
    ];

    $build['mollo_dashboard_block'] = $block;
    return $build;


  }

  public function getVars() {

    // for Twig Variables Suggestion define Vars in MolloDashboardController:
    // and include
    // {# @var mollo_dashboard \Drupal\mollo_dashboard\Controller\MolloDashboardController #}
    // at top of your twig Template

    $variables['foo'] = 'foo';
    $variables['bar'] = 'bar';
    $variables['test'] = TRUE;

    return $variables;
  }

}
