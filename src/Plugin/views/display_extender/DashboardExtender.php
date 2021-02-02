<?php

/**
 * @file
 * Contains \Drupal\mollo_dashboard\Plugin\views\display_extender\HeadMetadata.
 */

namespace Drupal\mollo_dashboard\Plugin\views\display_extender;

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
 *   help = @Translation("Settings to add metatag in document head for this view."),
 *   no_ui = FALSE
 * )
 */
class DashboardExtender extends DisplayExtenderPluginBase {

  /**
   * Provide the key options for this plugin.
   */
  public function defineOptionsAlter(&$options) {
    $options['mollo_dashboard'] =  array(
      'contains' => array(
        'title' => array('default' => ''),
        'description' => array('default' => ''),
      )
    );
  }

  /**
   * Provide the default summary for options and category in the views UI.
   */
  public function optionsSummary(&$categories, &$options) {
    $categories['mollo_dashboard'] = array(
      'title' => t('Dashboard'),
      'column' => 'second',
    );
    $mollo_dashboard = $this->hasMetadata() ? $this->getMetadataValues() : FALSE;
    $options['mollo_dashboard'] = array(
      'category' => 'mollo_dashboard',
      'title' => t('Dashboard'),
      'value' => $mollo_dashboard ? $mollo_dashboard['title'] : $this->t('none'),
    );
  }

  /**
   * Provide a form to edit options for this plugin.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {

    if ($form_state->get('section') == 'mollo_dashboard') {
      $form['#title'] .= t('The metadata for this display');
      $mollo_dashboard = $this->getMetadataValues();

      $form['mollo_dashboard']['#type'] = 'container';
      $form['mollo_dashboard']['#tree'] = TRUE;
      $form['mollo_dashboard']['title'] = array(
        '#title' => $this->t('Metadata title'),
        '#type' => 'textfield',
        '#description' => $this->t('Provide a title for the title metadata of this views'),
        '#default_value' => $mollo_dashboard['title'],
      );

      $form['mollo_dashboard']['description'] = array(
        '#title' => $this->t('Description metadata'),
        '#type' => 'textarea',
        '#description' => $this->t('Provide a short description for the description metadata of this views'),
        '#default_value' => $mollo_dashboard['description'],
      );

      //
      $form['mollo_dashboard'][]['#markup'] = 'icon';
      $form['mollo_dashboard'][]['#markup'] = 'Position';
      $form['mollo_dashboard'][]['#markup'] = 'Enable';
      $form['mollo_dashboard'][]['#markup'] = 'Size';

    }
  }

  /**
   * Validate the options form.
   */
  public function validateOptionsForm(&$form, FormStateInterface $form_state) { }

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
  public function preExecute() { }

  /**
   * Inject anything into the query that the display_extender handler needs.
   */
  public function query() { }

  /**
   * Static member function to list which sections are defaultable
   * and what items each section contains.
   */
  public function defaultableSections(&$sections, $section = NULL) { }

  /**
   * Identify whether or not the current display has custom metadata defined.
   */
  public function hasMetadata() {
    $mollo_dashboard = $this->getMetadataValues();
    return !empty($mollo_dashboard['title']);
  }

  /**
   * Get the head metadata configuration for this display.
   *
   * @return array
   *   The head metadata values.
   */
  public function getMetadataValues() {
    $mollo_dashboard = $this->options['mollo_dashboard'] ?? '';

    return $mollo_dashboard;
  }
}

?>
