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

  public $dashboard;

  public $foo;

  public $bar;

  public $views;

  public $name;

  public $title;

  public $icon;

  public $add_new;

  public $view_id;

  public $display_id;

  public $enable;

  public $full_size;

  public $weight;

  public $info;

  public $list;

  public $buttons;

  public $button_1;

  public $button_2;

  public $button_3;

  public $label;

  public $path;

  public $use_ajax;

  public $position;



  /**
   * @return array[]
   */
  public function page(): array {

    $template_name = 'dashboard-page.html.twig';
    $template_file = $this->getTemplatePath() . $template_name;
    $template = file_get_contents($template_file);
    $dashboards = $this->getViewsData();
    $toolbar = $this->getToolbarData();

    return [
      'description' => [
        '#type' => 'inline_template',
        '#template' => $template,
        '#context' => [
          'dashboards' => $dashboards,
          'toolbar' => $toolbar,
        ],
      ],
    ];
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
    $variables = [];

    //  dd($views);

    foreach ($views as $view_name => $view) {

      // dd($view);

      $displays = $view->get('display');

      foreach ($displays as $display_id => $display) {
        $title = '';

/*      // Debug
        if (isset($display['display_options']['display_extenders']['mollo_dashboard'])) {
          dpm($display['display_options']['display_extenders']['mollo_dashboard']);
        }*/


        //dd($display);
        if (isset($display['display_options']['display_extenders']['mollo_dashboard']['dashboard']['enabled']) &&
          $display['display_options']['display_extenders']['mollo_dashboard']['dashboard']['enabled'] == 1) {

         // dpm($display['display_options']['display_extenders']['mollo_dashboard']);


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

          // General
          $var["enabled"] = $dashboard["enabled"];
          $var["full_size"] = $dashboard["full_size"];
          $var["position"] = $dashboard["position"];
          $var["weight"] = $dashboard["weight"];
          $var["title"] = $dashboard["title"];
          $var["info"] = $dashboard["info"];

          // Buttons
          $var['add_new']["enabled"] = $dashboard["add_new_enabled"];
          $var['add_new']["node_type"] = $dashboard["add_new_node_type"];
          $var['list']["enabled"] = $dashboard["list_enabled"];
          $var['list']["path"] = $dashboard["list_path"];

          // Aditional Buttons
          $var['buttons']['button_1']["enabled"] = $dashboard["button_1_enabled"];
          $var['buttons']['button_1']["label"] = $dashboard["button_1_label"];
          $var['buttons']['button_1']["icon"] = $dashboard["button_1_icon"];
          $var['buttons']['button_1']["path"] = $dashboard["button_1_path"];
          $var['buttons']['button_1']["use_ajax"] = $dashboard["button_1_use_ajax"];
          $var['buttons']['button_2']["enabled"] = $dashboard["button_2_enabled"];
          $var['buttons']['button_2']["label"] = $dashboard["button_2_label"];
          $var['buttons']['button_2']["icon"] = $dashboard["button_2_icon"];
          $var['buttons']['button_2']["path"] = $dashboard["button_2_path"];
          $var['buttons']['button_2']["use_ajax"] = $dashboard["button_2_use_ajax"];
          $var['buttons']['button_3']["enabled"] = $dashboard["button_3_enabled"];
          $var['buttons']['button_3']["label"] = $dashboard["button_3_label"];
          $var['buttons']['button_3']["icon"] = $dashboard["button_3_icon"];
          $var['buttons']['button_3']["path"] = $dashboard["button_3_path"];
          $var['buttons']['button_3']["use_ajax"] = $dashboard["button_3_use_ajax"];


          $variables[] = $var;

        }
      }
    }
    return $variables;
  }

  private function getToolbarData() {
    return $this->config('mollo_dashboard.settings')->get();
  }

}
