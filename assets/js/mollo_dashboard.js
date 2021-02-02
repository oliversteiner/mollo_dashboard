(function($, Drupal, drupalSettings) {
  Drupal.behaviors.molloDashboard = {
    attach(context, settings) {
      console.log('Mollo Dashboard');

      const $triggerElem = $('.mollo-dashboard-test-1-trigger');
      const $resultElem = $('.mollo-dashboard-test-1-result');
      let counter = 0;

      $('#mollo-dashboard', context)
        .once('mollo-dashboard')
        .each(() => {
          $triggerElem.click(event => {
            console.log('click!');
            event.preventDefault();
            counter++;
            $resultElem.html(counter);
          });
        });
    },
  };
})(jQuery, Drupal, drupalSettings);
