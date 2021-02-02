<?php

/**
 * @file
 * Contains \Drupal\mollo_dashboard\Plugin\views\display_extender\HeadMetadata.
 */

namespace Drupal\mollo_dashboard\Plugin\views\display_extender;

use Drupal\views\Plugin\views\display_extender\DisplayExtenderPluginBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Head metadata display extender plugin.
 *
 * @ingroup views_display_extender_plugins
 *
 * @ViewsDisplayExtender(
 *   id = "head_metadata",
 *   title = @Translation("head metadata display extender"),
 *   help = @Translation("Settings to add metatag in document head for this view."),
 *   no_ui = FALSE
 * )
 */
class HeadMetadata extends DisplayExtenderPluginBase {

  /**
   * Provide the key options for this plugin.
   */
  public function defineOptionsAlter(&$options) {
    $options['head_metadata'] =  array(
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
    $categories['head_metadata'] = array(
      'title' => t('Head metadata'),
      'column' => 'second',
    );
    $head_metadata = $this->hasMetadata() ? $this->getMetadataValues() : FALSE;
    $options['head_metadata'] = array(
      'category' => 'head_metadata',
      'title' => t('Head metadata'),
      'value' => $head_metadata ? $head_metadata['title'] : $this->t('none'),
    );
  }

  /**
   * Provide a form to edit options for this plugin.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {

    if ($form_state->get('section') == 'head_metadata') {
      $form['#title'] .= t('The metadata for this display');
      $head_metadata = $this->getMetadataValues();

      $form['head_metadata']['#type'] = 'container';
      $form['head_metadata']['#tree'] = TRUE;
      $form['head_metadata']['title'] = array(
        '#title' => $this->t('Metadata title'),
        '#type' => 'textfield',
        '#description' => $this->t('Provide a title for the title metadata of this views'),
        '#default_value' => $head_metadata['title'],
      );

      $form['head_metadata']['description'] = array(
        '#title' => $this->t('Description metadata'),
        '#type' => 'textarea',
        '#description' => $this->t('Provide a short description for the description metadata of this views'),
        '#default_value' => $head_metadata['description'],
      );
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
    if ($form_state->get('section') == 'head_metadata') {
      $head_metadata = $form_state->getValue('head_metadata');
      $this->options['head_metadata'] = $head_metadata;
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
    $head_metadata = $this->getMetadataValues();
    return !empty($head_metadata['title']);
  }

  /**
   * Get the head metadata configuration for this display.
   *
   * @return array
   *   The head metadata values.
   */
  public function getMetadataValues() {
    $head_metadata = $this->options['head_metadata'] ?? '';

    return $head_metadata;
  }
}

?>
