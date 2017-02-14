define(['app'], function (app) {

    var filters = {};

    filters.noFractionCurrency = ['$filter', '$locale',
        function(filter, locale) {
            var currencyFilter = filter('currency');
            var formats = locale.NUMBER_FORMATS;
            return function(amount, currencySymbol) {
                var value = currencyFilter(amount, currencySymbol);
                var sep = value.indexOf(formats.DECIMAL_SEP);
                if(amount >= 0) {
                    return value.substring(0, sep);
                }
                return value.substring(0, sep);
            };
        }];

    filters.toTrusted =  ['$sce', function($sce){
        return function(text) {
            return $sce.trustAsHtml(text);
        };
    }];

// ==== REGISTER SERVICES IN ANGULAJRS APP
app.filter(filters);

});