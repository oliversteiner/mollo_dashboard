<?php

/**
 * @file
 * Contains \Drupal\dashboard\Plugin\views\display_extender\HeadMetadata.
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


  /**
   * Provide the key options for this plugin.
   */
  public function defineOptionsAlter(&$options) {

    $node_type = 'article';
    $options['dashboard'] = [
      'contains' => [
        // General
        'enabled' => ['default' => FALSE, 'bool'],
        'size' => ['default' => FALSE, 'bool'],
        'weight' => ['default' => 1],

        // Header
        'title' => ['default' => 'title'],
        'info' => ['default' => 'info'],

        // Add New
        'add_new_enabled' => ['default' => FALSE, 'bool'],
        'add_new_node_type' => ['default' => $node_type],

        //  Go to List
        'list_enabled' => ['default' => FALSE, 'bool'],
        'list_path' => ['default' => '/admin/' . $node_type],

        // Buttons
        'button_1_enabled' => ['default' => FALSE, 'bool'],
        'button_1_label' => ['default' => ''],
        'button_1_icon' => ['default' => ''],
        'button_1_path' => ['default' => ''],
        'button_1_use_ajax' => ['default' => ''],

        'button_2_enabled' => ['default' => FALSE, 'bool'],
        'button_2_label' => ['default' => ''],
        'button_2_icon' => ['default' => ''],
        'button_2_path' => ['default' => ''],
        'button_2_use_ajax' => ['default' => ''],

        'button_3_enabled' => ['default' => FALSE, 'bool'],
        'button_3_label' => ['default' => ''],
        'button_3_icon' => ['default' => ''],
        'button_3_path' => ['default' => ''],
        'button_3_use_ajax' => ['default' => ''],
      ],
    ];
  }

  /**
   * Provide the default summary for options and category in the views UI.
   */
  public function optionsSummary(&$categories, &$options) {
    $categories['dashboard'] = [
      'title' => t('Dashboard'),
      'column' => 'second',
    ];
    $dashboard = $this->dashboardEnabled() ? $this->getDashboardValues() : FALSE;
    $options['dashboard'] = [
      'category' => 'dashboard',
      'title' => t('Dashboard'),
      'value' => $dashboard ? $this->t('yes') : $this->t('no'),
    ];
  }

  /**
   * Provide a form to edit options for this plugin.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {

    if ($form_state->get('section') == 'dashboard') {
      $form['#title'] .= t('The metadata for this display');
      $dashboard = $this->getDashboardValues();

      $form['dashboard']['#type'] = 'container';
      $form['dashboard']['#tree'] = TRUE;

      // Fieldset General
      $form['dashboard']['general'] = [
        '#type' => 'fieldset',
      ];

      // Enable
      $form['dashboard']['general']['enabled'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Show this View on the Dashboard Page'),
        '#default_value' => $dashboard['enabled'],
        '#prefix' =>
          '<span class="mollo-form-button-inline">',
        '#suffix' => '</span>',
      ];

      // Size
      $form['dashboard']['general']['size'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Show as full size'),
        '#default_value' => $dashboard['size'],
        '#prefix' =>
          '<span class="mollo-form-button-inline">',
        '#suffix' => '</span>',
      ];

      // Position
      $form['dashboard']['general']['weight'] = [
        '#title' => $this->t('Position'),
        '#type' => 'number',
        '#description' => $this->t('Digit for position weight'),
        '#default_value' => $dashboard['weight'],
        '#attributes' => [
          'class' => ['mollo-form-input-number-dashboard'],
        ],
      ];

      // Fieldset Header
      $form['dashboard']['header'] = [
        '#type' => 'fieldset',
      ];

      // Title
      $form['dashboard']['header']['title'] = [
        '#title' => $this->t('Title'),
        '#type' => 'textfield',
        '#description' => $this->t('Provide a title for the Dashboard'),
        '#default_value' => $dashboard['title'],
      ];

      // Info Text
      $form['dashboard']['header']['info'] = [
        '#title' => $this->t('Info'),
        '#type' => 'textfield',
        '#description' => $this->t('Additional Text for Header'),
        '#default_value' => $dashboard['info'],
      ];


      //  Add new
      //  ----------------------------------------------

      // Fieldset
      $form['dashboard']['add_new'] = [
        '#type' => 'fieldset',
      ];
      // Button
      $form['dashboard']['add_new']['enabled'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Button: Add new'),
        '#default_value' => $dashboard['add_new_enabled'],
        '#prefix' =>
          '<span class="mollo-form-button-inline">',
        '#suffix' => '</span>',

      ];
      // Select Node Type
      $form['dashboard']['add_new']['node_type'] = [
        '#title' => $this->t('Content Type'),
        '#type' => 'select',
        '#default_value' => $dashboard['add_new_node_type'],
        '#options' => $this->getOptionsListOfNodeTypes(),
      ];


      //  Go to List
      //  ----------------------------------------------
      // Fieldset
      $form['dashboard']['list'] = [
        '#type' => 'fieldset',
      ];
      // Checkbox
      $form['dashboard']['list']['enabled'] = [
        '#type' => 'checkbox',
        '#title' => $this
          ->t('Button: Go to list'),
        '#default_value' => $dashboard['list_enabled'],
        '#prefix' =>
          '<span class="mollo-form-button-inline">',
        '#suffix' => '</span>',
      ];
      // Destination path
      $form['dashboard']['list']['path'] = [
        '#type' => 'textfield',
        '#default_value' => $dashboard['list_path'],
        '#description' => $this->t('Path destination'),
      ];


      //  Details Buttons
      //  ----------------------------------------------
      $form['dashboard']['buttons'] = [
        '#type' => 'details',
        '#title' => $this
          ->t('Add more buttons'),
      ];


      foreach (range(1, 3) as $number) {

        $button_name = 'button_' . $number;

        //  Button 1
        //  ----------------------------------------------
        $form['dashboard']['buttons'][$button_name] = [
          '#type' => 'fieldset',
        ];

        // Status
        $form['dashboard']['buttons'][$button_name]['enabled'] = [
          '#type' => 'checkbox',
          '#title' => $this
            ->t('Button 1'),
          '#default_value' => $dashboard['button_' . $number . '_enabled'],
        ];

        // Label
        $form['dashboard']['buttons'][$button_name]['label'] = [
          '#type' => 'textfield',
          '#description' => $this->t('Button Label'),
          '#default_value' => $dashboard[$button_name . '_label'],
        ];

        // Icon
        $form['dashboard']['buttons'][$button_name]['icon'] = [
          '#type' => 'textfield',
          '#description' => $this->t('Icon | Example: fal fa-home'),
          '#default_value' => $dashboard[$button_name . '_icon'],
        ];

        // Path
        $form['dashboard']['buttons'][$button_name]['path'] = [
          '#type' => 'textfield',
          '#description' => $this->t('Path destination'),
          '#default_value' => $dashboard[$button_name . '_path'],
        ];

        // use ajax
        $form['dashboard']['buttons'][$button_name]['use_ajax'] = [
          '#type' => 'checkbox',
          '#title' => $this
            ->t('use ajax'),
          '#default_value' => $dashboard[$button_name . '_use_ajax'],
        ];
      }
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
    if ($form_state->get('section') == 'dashboard') {
      $new_values = $form_state->getValue('dashboard');
      dpm($new_values);

      // General
      $options['enabled'] = $new_values['general']['enabled'];
      $options['size'] = $new_values['general']['size'];
      $options['weight'] = $new_values['general']['weight'];

      // Header
      $options['title'] = $new_values['header']['title'];
      $options['info'] = $new_values['header']['info'];

      // Add New
      $options['add_new_enabled'] = $new_values['add_new']['enabled'];
      $options['add_new_node_type'] = $new_values['add_new']['node_type'];

      //  Go to List
      $options['list_enabled'] = $new_values['list']['enabled'];
      $options['list_path'] = $new_values['list']['path'];

      // Button 1
      $options['button_1_enabled'] = $new_values['buttons']['button_1']['enabled'];
      $options['button_1_label'] = $new_values['buttons']['button_1']['label'];
      $options['button_1_icon'] = $new_values['buttons']['button_1']['icon'];
      $options['button_1_path'] = $new_values['buttons']['button_1']['path'];
      $options['button_1_use_ajax'] = $new_values['buttons']['button_1']['use_ajax'];

      // Button 2
      $options['button_2_enabled'] = $new_values['buttons']['button_2']['enabled'];
      $options['button_2_label'] = $new_values['buttons']['button_2']['label'];
      $options['button_2_icon'] = $new_values['buttons']['button_2']['icon'];
      $options['button_2_path'] = $new_values['buttons']['button_2']['path'];
      $options['button_2_use_ajax'] = $new_values['buttons']['button_2']['use_ajax'];

      // Button 3
      $options['button_3_enabled'] = $new_values['buttons']['button_3']['enabled'];
      $options['button_3_label'] = $new_values['buttons']['button_3']['label'];
      $options['button_3_icon'] = $new_values['buttons']['button_3']['icon'];
      $options['button_3_path'] = $new_values['buttons']['button_3']['path'];
      $options['button_3_use_ajax'] = $new_values['buttons']['button_3']['use_ajax'];

      dpm($options);

      $this->options['dashboard'] = $options;
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
    $dashboard = $this->getDashboardValues();
    return !empty($dashboard['enabled']);
  }

  /**
   * Get the head metadata configuration for this display.
   *
   * @return array
   *   The head metadata values.
   */
  public function getDashboardValues(): array {
    return $this->options['dashboard'] ?? [];
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


}
