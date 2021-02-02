<?php

namespace Drupal\mollo_dashboard\Controller;

use Drupal\Core\Controller\ControllerBase;


/**
 * Class MolloDashboardController.
 *
 *

 */
class MolloDashboardController extends ControllerBase {

  // public  Vars for Twig Var Suggestion. Use in Template via:
  // {# @var mollo_dashboard \Drupal\mollo_dashboard\Controller\MolloDashboardController #}

  public $mollo_dashboard;
  public $test;

  public $foo;

  public $bar;


  /**
   * Name of our module.
   *
   * @return string
   *   A module name.
   */
  public function getModuleName(): string {
    return 'mollo_dashboard';
  }


  /**
   * @return array[]
   */
  public function page(): array {

    $template_name = 'dashboard-page.html.twig';
    $template_file = $this->getTemplatePath() . $template_name;
    $template = file_get_contents($template_file);


    return [
      'description' => [
        '#type' => 'inline_template',
        '#template' => $template,
        '#context' => $this->getPageVars(),
      ],
    ];
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
   *
   */
  private function getPageVars(): array {

    $test = TRUE;
    $foo = 'Foo';
    $bar = 'Bar';

    $variables['mollo_dashboard']['test'] = $test;
    $variables['mollo_dashboard']['foo'] = $foo;
    $variables['mollo_dashboard']['bar'] = $bar;

    return $variables;
  }

}
