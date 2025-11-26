/*
* Plugins
*/
import svg4everybody from 'svg4everybody';

/**
 * Pages
 */
import home from './pages/_home';


(($) => {
  'use strict';

  $(() => {
    svg4everybody();
    home();
  });
})(jQuery);