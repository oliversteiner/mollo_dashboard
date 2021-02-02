<?php

namespace Drupal\mollo_dashboard\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\mollo_drupal\Utils\MolloDashboardTrait;
use Drupal\mollo_module\Utils\MolloModuleTrait;


/**
 * Class MolloDashboardController.
 *
 *

 */
class MolloDashboardController extends ControllerBase {

  use \Drupal\mollo_dashboard\Utils\MolloDashboardTrait;

  // public  Vars for Twig Var Suggestion. Use in Template via:
  // {# @var mollo_dashboard \Drupal\mollo_dashboard\Controller\MolloDashboardController #}

  public $mollo_dashboard;

  public $test;

  public $foo;

  public $bar;


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
