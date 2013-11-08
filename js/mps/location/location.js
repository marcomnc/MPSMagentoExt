(function($,window,undefined){
    $.fn.selectCountry = function (params) {
        var settings = $.extend({}, {'url': '', 'countryCode': '', "home": "0", "urlref" : '', 'enableEsc': false }, params);
        if (settings.url != "") {
            var url = settings.url;
            if (settings.countryCode != "") {
                url+='countryCode/'+settings.countryCode+'/';
            }
            url+='home/'+settings.home+'/urlref/'+settings.urlref+'/'
            $j.fancybox({autoScale   : true,
                         showCloseButton : false,
                         href        : url,
                         modal       : !settings.enableEsc,
                         titleShow   : false});
        }
    };
    
    $.fn.setCountryCookie = function(href) {
        $j.ajax({
            url     : href,
            success : function(response) {
                var data = $j.parseJSON(response);
                if (data.action.toString().toLowerCase() == 'redirect' && data.url != "") {
                    window.location = data.url;
                } else {
                    if (data.action.toString().toLowerCase() == 'reload' ) {
                        window.location.reload();
                    } else {
                        $j.fancybox.close();
                    }                    
                }                
            },
            error   : function() {
                alert('General Error');
                $j.fancybox.close();
            }
        });
    };
})(jQuery, this);

