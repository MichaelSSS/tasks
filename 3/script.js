jQuery(function() {
  var options = {
    url: 'autocomplete.php',
    minChars: 3,
  };
  $('input').streetAutocomplete(options);
});
