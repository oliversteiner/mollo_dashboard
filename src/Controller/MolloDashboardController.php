<?php

namespace Drupal\mollo_dashboard\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\mollo_drupal\Utils\MolloDashboardTrait;
use Drupal\mollo_module\Utils\MolloModuleTrait;
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

    $views_demo = [
      [
        'name' => 'dashboard_last_edit',
        'title' => 'Last Changes',
        'icon' => 'fal fa-clock',
      ],
      [
        'name' => 'dashboard_unpublished',
        'title' => 'Unpublished',
        'icon' => 'fal fa-eye-slash',
      ],
      [
        'name' => 'dashboard_intern',
        'title' => 'Intern',
        'icon' => 'fal fa-lock',
      ],
      [
        'name' => 'dashboard_blog',
        'title' => 'Blog',
        'icon' => 'fal fa-typewriter',
      ],
      [
        'name' => 'dashboard_pages',
        'title' => 'Basic Pages',
        'icon' => 'fal fa-file',
      ],
    ];

    $views_icons = [
      'dashboard_last_edit' => 'fal fa-clock',
      'dashboard_unpublished' => 'fal fa-eye-slash',
      'dashboard_intern' => 'fal fa-lock',
      'dashboard_blog' => 'fal fa-typewriter',
      'dashboard_pages' => 'fal fa-file',
    ];

    $views = [];

    // Get List with all View Ids
    $views_on_site = Views::getViewsAsOptions(TRUE, 'enabled');

    foreach ($views_on_site as $view_name => $view_title) {

      // take only View with 'dashboard_' in name
      $needle = 'dashboard_';
      if (strpos($view_name, $needle) !== FALSE) {

        // Title: Remove 'Dashboard' from Title
        $title = str_replace('Dashboard', '', $view_title);

        // Icon: Search in Predefined List
        $icon = $views_icons[$view_name] ?? '';

        $view['name'] = $view_name;
        $view['title'] = $title;
        $view['icon'] = $icon;
        $views[] = $view;
      }
    }
    //

    // dd($views);

    $variables['mollo_dashboard']['views'] = $views;

    return $variables;
  }

}
