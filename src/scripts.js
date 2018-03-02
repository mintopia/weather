var App = {
  clockTimer: null,
  updateTimer: null,
  
  init: function() {
    var self = this;
    jQuery(document).ready(function() {
      self.updateClock();
      self.clockTimer = setInterval(function() {
        self.updateClock();
      }, 5000);
      self.updateTimer = setInterval(function() {
        self.updateWeather();
      }, 60000);
    });
  },
  
  updateClock: function() {
    jQuery('#clock').html(moment().format('HH:mm'));
    jQuery('#date').html(moment().format('ddd D MMM'));
  },
  
  updateWeather: function() {
    var self = this;
    data = jQuery.get('', function(data) {
      self.processWeather(data);
    });
  },
  
  processWeather: function(data) {
    jQuery('#summary').html(data['minutely']['summary']);
    jQuery('#temperature').html('' + Math.round(data['currently']['temperature'], 0) + '&deg;C');
    jQuery('#feels').html('Feels ' + Math.round(data['currently']['apparentTemperature'], 0) + '&deg;C');
  }
};

App.init();