<?php

/**
 * @file
 * Contains \Drupal\mollo_dashboard\Plugin\views\display_extender\HeadMetadata.
 */

namespace Drupal\mollo_dashboard\Plugin\views\display_extender;

use Drupal\node\Entity\NodeType;
use Drupal\views\Plugin\views\display_extender\DisplayExtenderPluginBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Dashboard display extender plugin.
 *
 * @ingroup views_display_extender_plugins
 *
 * @ViewsDisplayExtender(
 *   id = "mollo_dashboard",
 *   title = @Translation("head metadata display extender"),
 *   help = @Translation("Settings to add metatag in document head for this
 *   view."), no_ui = FALSE
 * )
 */
class DashboardExtender extends DisplayExtenderPluginBase {


/*  protected function defineOptions(): array {
    $options = parent::defineOptions();

    return $options;
  }*/

  /**
   * Provide the key options for this plugin.
   */
  public function defineOptionsAlter(&$options) {
/*    $options['mollo_dashboard'] = [
      'contains' => [
        'title' => ['default' => ''],
        'description' => ['default' => ''],
      ],
    ];*/

    // Current Views Path
    $view_path = $this->view->getPath();

    // Read first View Row to get Content Type
    // $node_type = $this->getUsedNodeType();
    $node_type = 'basic_page';

    $options['mollo_dashboard'] = [
      'contains' => [

        // General
        'general' => [
          'enable' => ['default' => FALSE],
          'size' => ['default' => FALSE],
          'weight' => ['default' => 1],
        ],

        // Header
        'header' => [
          'title' => ['default' => 'title'],
          'info' => ['default' => 'info'],
        ],

        // Add New
        'add_new' => [
          'enable' => ['default' => TRUE],
          'node_type' => ['default' => $node_type],
        ],

        //  Go to List
        'list' => [
          'enable' => ['default' => TRUE],
          'path' => ['default' => '/admin/' . $node_type],
        ],

        // Buttons
        'buttons' => [
          'button_1' => [
            'enable' => ['default' => FALSE],
            'label' => ['default' => ''],
            'icon' => ['default' => ''],
            'path' => ['default' => ''],
          ],
          'button_2' => [
            'enable' => ['default' => FALSE],
            'label' => ['default' => ''],
            'icon' => ['default' => ''],
            'path' => ['default' => ''],
          ],
          'button_3' => [
            'enable' => ['default' => FALSE],
            'label' => ['default' => ''],
            'icon' => ['default' => ''],
            'path' => ['default' => ''],
          ],
        ],
      ],
    ];

  }

  /**
   * Provide the default summary for options and category in the views UI.
   */
  public function optionsSummary(&$categories, &$options) {
    $categories['mollo_dashboard'] = [
      'title' => t('Dashboard'),
      'column' => 'second',
    ];
    $mollo_dashboard = $this->dashboardEnabled() ? $this->getDashboardValues() : FALSE;
    $options['mollo_dashboard'] = [
      'category' => 'mollo_dashboard',
      'title' => t('Dashboard'),
      'value' => $mollo_dashboard ? $mollo_dashboard['title'] : $this->t('none'),
    ];
  }

  /**
   * Provide a form to edit options for this plugin.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {

    if ($form_state->get('section') == 'mollo_dashboard') {
      $form['#title'] .= t('The metadata for this display');
      $mollo_dashboard = $this->getDashboardValues();

      $form['mollo_dashboard']['#type'] = 'container';
      $form['mollo_dashboard']['#tree'] = TRUE;

      // Fieldset General
      $form['mollo_dashboard']['general'] = [
        '#type' => 'fieldset',
      ];

      // Enable
      $form['mollo_dashboard']['general']['enable'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Show this View on the Dashboard Page'),
        '#default_value' => $mollo_dashboard['general']['enable'],
        '#prefix' =>
          '<span class="mollo-form-button-inline">',
        '#suffix' => '</span>',
      ];

      // Size
      $form['mollo_dashboard']['general']['size'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Show as full size'),
        '#default_value' => $mollo_dashboard['general']['size'],
        '#prefix' =>
          '<span class="mollo-form-button-inline">',
        '#suffix' => '</span>',
      ];

      // Position
      $form['mollo_dashboard']['general']['weight'] = [
        '#title' => $this->t('Position'),
        '#type' => 'number',
        '#description' => $this->t('Digit for position weight'),
        '#default_value' => $mollo_dashboard['general']['weight'],
        '#attributes' => [
          'class' => ['mollo-form-input-number-dashboard'],
        ],
      ];

      // Fieldset Header
      $form['mollo_dashboard']['header'] = [
        '#type' => 'fieldset',
      ];

      // Title
      $form['mollo_dashboard']['header']['title'] = [
        '#title' => $this->t('Title'),
        '#type' => 'textfield',
        '#description' => $this->t('Provide a title for the Dashboard'),
        '#default_value' => $mollo_dashboard['title'],
      ];

      // Info Text
      $form['mollo_dashboard']['header']['info'] = [
        '#title' => $this->t('Info'),
        '#type' => 'textfield',
        '#description' => $this->t('Additional Text for Header'),
        '#default_value' => $mollo_dashboard['info'],
      ];


      //  Add new
      //  ----------------------------------------------

      // Fieldset
      $form['mollo_dashboard']['add_new'] = [
        '#type' => 'fieldset',
      ];
      // Button
      $form['mollo_dashboard']['add_new']['enable'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Button: Add new'),
        '#default_value' => $mollo_dashboard['add_new']['enable'],
        '#prefix' =>
          '<span class="mollo-form-button-inline">',
        '#suffix' => '</span>',

      ];
      // Select Node Type
      $form['mollo_dashboard']['add_new']['node_type'] = [
        '#title' => $this->t('Content Type'),
        '#type' => 'select',
        '#default_value' => $mollo_dashboard['add_new']['node_type'],
        '#options' => $this->getOptionsListOfNodeTypes(),
      ];


      //  Go to List
      //  ----------------------------------------------
      // Fieldset
      $form['mollo_dashboard']['list'] = [
        '#type' => 'fieldset',
      ];
      // Checkbox
      $form['mollo_dashboard']['list']['enable'] = [
        '#type' => 'checkbox',
        '#title' => $this
          ->t('Button: Go to list'),
        '#default_value' => $mollo_dashboard['list']['enable'],
        '#prefix' =>
          '<span class="mollo-form-button-inline">',
        '#suffix' => '</span>',
      ];
      // Destination path
      $form['mollo_dashboard']['list']['path'] = [
        '#type' => 'textfield',
        '#default_value' => $mollo_dashboard['list']['path'],
        '#description' => $this->t('Path destination'),
      ];


      //  Details Buttons
      //  ----------------------------------------------
      $form['mollo_dashboard']['buttons'] = [
        '#type' => 'details',
        '#title' => $this
          ->t('Add more buttons'),
      ];

      //  Button 1
      //  ----------------------------------------------
      $form['mollo_dashboard']['buttons']['button_1'] = [
        '#type' => 'fieldset',
      ];

      // Status
      $form['mollo_dashboard']['buttons']['button_1']['enable'] = [
        '#type' => 'checkbox',
        '#title' => $this
          ->t('Button 1'),
        '#default_value' => $mollo_dashboard['buttons']['button_1']['enable'],
      ];

      // Label
      $form['mollo_dashboard']['buttons']['button_1']['label'] = [
        '#type' => 'textfield',
        '#description' => $this->t('Button Label'),
        '#default_value' => $mollo_dashboard['buttons']['button_1']['label'],
      ];

      // Icon
      $form['mollo_dashboard']['buttons']['button_1']['icon'] = [
        '#type' => 'textfield',
        '#description' => $this->t('Icon | Example: fal fa-home'),
        '#default_value' => $mollo_dashboard['buttons']['button_1']['icon'],
      ];

      // Path
      $form['mollo_dashboard']['buttons']['button_1']['path'] = [
        '#type' => 'textfield',
        '#description' => $this->t('Path destination'),
        '#default_value' => $mollo_dashboard['buttons']['button_1']['path'],
      ];

      // use ajax
      $form['mollo_dashboard']['buttons']['button_1']['use_ajax'] = [
        '#type' => 'checkbox',
        '#title' => $this
          ->t('use ajax'),
        '#default_value' => $mollo_dashboard['buttons']['button_1']['ajax'],
      ];

      //  Button 2
      //  ----------------------------------------------
      $form['mollo_dashboard']['buttons']['button_2'] = [
        '#type' => 'fieldset',
      ];

      // Status
      $form['mollo_dashboard']['buttons']['button_2']['status'] = [
        '#type' => 'checkbox',
        '#title' => $this
          ->t('Button 2'),
        '#default_value' => $mollo_dashboard['buttons']['button_2']['status'],
      ];

      // Label
      $form['mollo_dashboard']['buttons']['button_2']['label'] = [
        '#type' => 'textfield',
        '#description' => $this->t('Button Label'),
        '#default_value' => $mollo_dashboard['buttons']['button_2']['label'],
      ];

      // Icon
      $form['mollo_dashboard']['buttons']['button_2']['icon'] = [
        '#type' => 'textfield',
        '#description' => $this->t('Icon | Example: fal fa-home'),
        '#default_value' => $mollo_dashboard['buttons']['button_2']['icon'],
      ];

      // Path
      $form['mollo_dashboard']['buttons']['button_2']['path'] = [
        '#type' => 'textfield',
        '#description' => $this->t('Path destination'),
        '#default_value' => $mollo_dashboard['buttons']['button_2']['path'],
      ];

      // use ajax
      $form['mollo_dashboard']['buttons']['button_2']['use_ajax'] = [
        '#type' => 'checkbox',
        '#title' => $this
          ->t('use ajax'),
        '#default_value' => $mollo_dashboard['buttons']['button_2']['ajax'],
      ];

      //  Button 3
      //  ----------------------------------------------
      $form['mollo_dashboard']['buttons']['button_3'] = [
        '#type' => 'fieldset',
      ];

      // Status
      $form['mollo_dashboard']['buttons']['button_3']['status'] = [
        '#type' => 'checkbox',
        '#title' => $this
          ->t('Button 3'),
        '#default_value' => $mollo_dashboard['buttons']['button_3']['status'],
      ];

      // Label
      $form['mollo_dashboard']['buttons']['button_3']['label'] = [
        '#type' => 'textfield',
        '#description' => $this->t('Button Label'),
        '#default_value' => $mollo_dashboard['buttons']['button_3']['label'],
      ];

      // Icon
      $form['mollo_dashboard']['buttons']['button_3']['icon'] = [
        '#type' => 'textfield',
        '#description' => $this->t('Icon | Example: fal fa-home'),
        '#default_value' => $mollo_dashboard['buttons']['button_3']['icon'],
      ];

      // Path
      $form['mollo_dashboard']['buttons']['button_3']['path'] = [
        '#type' => 'textfield',
        '#description' => $this->t('Path destination'),
        '#default_value' => $mollo_dashboard['buttons']['button_3']['path'],
      ];

      // use ajax
      $form['mollo_dashboard']['buttons']['button_3']['use_ajax'] = [
        '#type' => 'checkbox',
        '#title' => $this
          ->t('use ajax'),
        '#default_value' => $mollo_dashboard['buttons']['button_3']['ajax'],
      ];


    }
  }

  /**
   * Validate the options form.
   */
  public function validateOptionsForm(&$form, FormStateInterface $form_state) {
  }

  /**
   * Handle any special handling on the validate form.
   */
  public function submitOptionsForm(&$form, FormStateInterface $form_state) {
    if ($form_state->get('section') == 'mollo_dashboard') {
      $mollo_dashboard = $form_state->getValue('mollo_dashboard');
      $this->options['mollo_dashboard'] = $mollo_dashboard;
    }
  }

  /**
   * Set up any variables on the view prior to execution.
   */
  public function preExecute() {
  }

  /**
   * Inject anything into the query that the display_extender handler needs.
   */
  public function query() {
  }

  /**
   * Static member function to list which sections are defaultable
   * and what items each section contains.
   */
  public function defaultableSections(&$sections, $section = NULL) {
  }

  /**
   * Identify whether or not the current display has custom metadata defined.
   */
  public function dashboardEnabled() {
    $mollo_dashboard = $this->getDashboardValues();
    return !empty($mollo_dashboard['title']);
  }

  /**
   * Get the head metadata configuration for this display.
   *
   * @return array
   *   The head metadata values.
   */
  public function getDashboardValues() {
    $mollo_dashboard = $this->options['mollo_dashboard'] ?? '';

    return $mollo_dashboard;
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
   * @return mixed
   */
  protected function getUsedNodeType() {
    $content_type = '';

    if ($this->view && $this->view->display_handler->getOption('filters')) {
      $option_filters = $this->view->display_handler->getOption('filters');
      if (isset($option_filters['type']) && $option_filters['type']['value']) {
        $option_filters_types = $option_filters['type']['value'];
        $content_type = array_keys($option_filters_types)[0];
      }
      return $content_type;
    }
    return '';
  }


}
