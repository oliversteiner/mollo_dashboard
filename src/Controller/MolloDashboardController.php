<?php

namespace Drupal\mollo_dashboard\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\mollo_drupal\Utils\MolloDashboardTrait;
use Drupal\mollo_module\Utils\MolloModuleTrait;
use Drupal\views\Entity\View;
use Drupal\views\Views;


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

  public $views;

  public $name;

  public $title;

  public $icon;


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
        '#context' => $this->getViewsData(),
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

  /**
   * @return array
   *
   */
  private function getViewsData(): array {

    // Get List with all View Ids
    //  $views_on_site = Views::getViewsAsOptions(TRUE, 'enabled');
    //  $views = Views::getViewsAsOptions(TRUE, 'enabled');
    $views = Views::getAllViews();
    $vars = [];

    // dd($views);

    foreach ($views as $view_name => $view) {

      // dd($view);

      $displays = $view->get('display');

      foreach ($displays as $display_id => $display) {
        $title = '';

        //dd($display);
        if (isset($display['display_options']['display_extenders']['mollo_dashboard']['dashboard']['enable']) &&
          $display['display_options']['display_extenders']['mollo_dashboard']['dashboard']['enable'] === 1) {

          // dd($display['display_options']['display_extenders']['mollo_dashboard']);


          // Icon
          $icon = ' ';
          if (isset($display['display_options']['display_extenders']['views_admintools_icon']['views_admintools_icon']['icon'])) {
            $icon = $display['display_options']['display_extenders']['views_admintools_icon']['views_admintools_icon']['icon'] ?? 'fas fa-list';
          }

          // Dashboard
          $dashboard = $display['display_options']['display_extenders']['mollo_dashboard']['dashboard'];

          // Title:
          // 1. Get from Display Exposed
          if (empty($title)) {
            $title = $dashboard['title'];
          }

          // 2. Get from Display Title (Remove Word 'Dashboard' )
          if (empty($title)) {
            if (isset($display['display_options']['title'])) {
              $title = $display['display_options']['title'];
            }
          }

          // 3. Get from Display Name (Remove Word 'Dashboard' )
          if (empty($title)) {
            $title = $view->label();
          }

          $title = str_replace('Dashboard', '', $title);

          $var = [];
          $var['view_id'] = $view->id();
          $var['display_id'] = $display_id;
          $var['title'] = $title;
          $var['icon'] = $icon;
          $var['header'] = $dashboard;

          $vars[] = $var;

        }
      }
    }
    $variables['mollo_dashboard']['views'] = $vars;
    return $variables;
  }

}
