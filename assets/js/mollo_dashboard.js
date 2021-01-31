(function($, Drupal, drupalSettings) {
  Drupal.behaviors.molloDashboard = {
    attach(context, settings) {
      console.log("Mollo Dashboard");

        $('#mollo-dashboard', context)
          .once('mollo-dashboard')
          .each(() => {});

    },
  };
})(jQuery, Drupal, drupalSettings);
