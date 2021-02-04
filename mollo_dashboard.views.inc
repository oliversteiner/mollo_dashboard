<?php


/**
 * Implements hook_preprocess_views_view().
 *
 * @param $variables
 */
function mollo_dashboard_preprocess_views_view(&$variables) {
  // $variables['debug'][] = 'mollo_dashboard_preprocess_views_view';
  $variables['mollo']['dashboard'] = [];

  if (!isset($variables['view'])) {
    return;
  }
  $view = $variables['view'];
  // Get the current display.
  $display = $view->getDisplay();

  // And get the list of extenders for this display.
  $extenders = $display->getExtenders();
  if (isset($extenders['mollo_dashboard'])) {

    // Retrieve the settings of our plugins using our custom plugin method.
    $dashboardValues = $extenders['mollo_dashboard']->getDashboardValues();

    // Add Dashboard Values for Twig.
    $variables['mollo']['dashboard'] = $dashboardValues;

  }

}

