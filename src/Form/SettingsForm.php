<?php

namespace Drupal\mollo_dashboard\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Dashboard settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mollo_dashboard_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['mollo_dashboard.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('mollo_dashboard.settings');
    $default_scheme = $this->config('system.file')->get('default_scheme');

    // Title :
    // Description :

    // General
    // - Clear Cache
    // - Media Browser
    // - Logout

    // Add New
    // - enable
    // - type
    // - Destination

    // Other Buttons
    // - Label
    // - Path
    // - Icon
    // - use ajax

    $form['info'] = [
      '#type' => 'markup',
      '#markup' => 'Set which buttons should appear on the dashboard page',
    ];

    // General
    // ------------------------------------------------
    $form['general'] = [
      '#type' => 'details',
      '#title' => t('Checkboxes'),
      '#open' => TRUE,
    ];

    // - Clear Cache
    $form['general']['clear_cache'] = [
      '#type' => 'checkbox',
      '#title' => t('Clear Cache'),
      '#default_value' => $config->get('clear_cache'),
      '#tree' => FALSE,
    ];

    // - Media Browser
    $form['general']['media_browser'] = [
      '#type' => 'checkbox',
      '#title' => t('Media Browser'),
      '#default_value' => $config->get('media_browser'),
      '#tree' => FALSE,
    ];

    // - Logout
    $form['general']['logout'] = [
      '#type' => 'checkbox',
      '#title' => t('Logout'),
      '#default_value' => $config->get('logout'),
      '#tree' => FALSE,
    ];

    // Add New
    // ------------------------------------------------

    $form['add'] = [
      '#type' => 'details',
      '#title' => t('Add new'),
      '#open' => TRUE,
      '#tree' => TRUE,
    ];


    $entities = \Drupal::service('entity_type.bundle.info')
      ->getBundleInfo('node');

    // Create a list of entity types.
    foreach ($entities as $entity_name => $info) {

      $title = $info['label'];

      $form['add'][$entity_name] = [
        '#type' => 'fieldset',
        '#title' => t(''),
        '#open' => TRUE,
      ];

      // - Enabled
      $form['add'][$entity_name]['enabled'] = [
        '#type' => 'checkbox',
        '#title' => $title,
        '#default_value' => $config->get('add.' . $entity_name . '.enabled'),
        '#tree' => TRUE,
        '#prefix' =>
          '<span class="mollo-form-elem-inline">',
        '#suffix' => '</span>',
      ];

      // Destination
      $form['add'][$entity_name]['destination'] = [
        '#type' => 'textfield',
        '#description' => t('Destination'),
        '#default_value' => $config->get('add.' . $entity_name . '.destination'),
        '#tree' => TRUE,
        '#prefix' =>
          '<span class="mollo-form-elem-inline">',
        '#suffix' => '</span>',
      ];
      // hidden label
      $form['add'][$entity_name]['label'] = [
        '#type' => 'hidden',
        '#value' => $title,
        '#tree' => TRUE,
      ];
      // hidden name
      $form['add'][$entity_name]['name'] = [
        '#type' => 'hidden',
        '#value' => $entity_name,
        '#tree' => TRUE,
      ];


      //  Other Buttons
      //  ----------------------------------------------
      $form['other'] = [
        '#type' => 'details',
        '#title' => $this
          ->t('Other buttons'),
        '#tree' => TRUE,

      ];


      foreach (range(1, 3) as $number) {

        $button_name = 'button_' . $number;

        $form['other'][$button_name] = [
          '#type' => 'fieldset',
          '#tree' => TRUE,

        ];

        // Status
        $form['other'][$button_name]['enabled'] = [
          '#type' => 'checkbox',
          '#title' => $this
            ->t('Button 1'),
          '#default_value' => $config->get('other.' . $button_name . '.enabled'),
          '#tree' => TRUE,

        ];

        // Label
        $form['other']['button_' . $number]['label'] = [
          '#type' => 'textfield',
          '#description' => $this->t('Button Label'),
          '#default_value' => $config->get('other.' . $button_name . '.label'),
          '#tree' => TRUE,

        ];

        // Icon
        $form['other']['button_' . $number]['icon'] = [
          '#type' => 'textfield',
          '#description' => $this->t('Icon | Example: fal fa-home'),
          '#default_value' => $config->get('other.' . $button_name . '.icon'),
          '#tree' => TRUE,

        ];

        // Path
        $form['other']['button_' . $number]['path'] = [
          '#type' => 'textfield',
          '#description' => $this->t('Path destination'),
          '#default_value' => $config->get('other.' . $button_name . '.path'),
          '#tree' => TRUE,

        ];

        // use ajax
        $form['other']['button_' . $number]['use_ajax'] = [
          '#type' => 'checkbox',
          '#title' => $this
            ->t('use ajax'),
          '#default_value' => $config->get('other.' . $button_name . '.use_ajax'),
          '#tree' => TRUE,

        ];


      }


    }


    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $values = $form_state->getValues();
    $config = $this->config('mollo_dashboard.settings');

    //dpm($values);

    foreach ($values as $key => $value) {

      // - Clear Cache
      if ($key === 'clear_cache') {
        $config->set('clear_cache', $value);
      }

      // - Media Browser
      elseif ($key === 'media_browser') {
        $config->set('media_browser', $value);
      }

      // - Logout
      elseif ($key === 'logout') {
        $config->set('logout', $value);
      }

      // Add New
      elseif ($key === 'add') {
        $add = $values['add'];

        foreach ($add as $node_type) {
          $name = $node_type['name'];
          $label = $node_type['label'];
          $enable = $node_type['enabled'];
          $dest = $node_type['destination'];
          // - enable
          // - type
          $config->set('add.' . $name . '.enabled', $enable);
          $config->set('add.' . $name . '.label', $label);
          $config->set('add.' . $name . '.name', $name);
          $config->set('add.' . $name . '.destination', $dest);
          // - Destination
        }


      }
      // Other
      elseif ($key === 'other') {
        $other = $values['other'];

        foreach (range(1, 3) as $number) {

          $button_name = 'button_' . $number;
          $button = $other[$button_name];

          $enable = $button['enabled'];
          $label = $button['label'];
          $path = $button['path'];
          $icon = $button['icon'];
          $use_ajax = $button['use_ajax'];

          $config->set('other.' . $button_name . '.enabled', $enable);
          $config->set('other.' . $button_name . '.label', $label);
          $config->set('other.' . $button_name . '.path', $path);
          $config->set('other.' . $button_name . '.icon', $icon);
          $config->set('other.' . $button_name . '.use_ajax', $use_ajax);

        }
      }


    }

    $config->save();
    // Rebuild the router.
    \Drupal::service('router.builder')->rebuild();
  }

}
