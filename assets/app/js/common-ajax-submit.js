 $(function () {
    $(document).on("submit", 'form[data-plugin="ajaxForm"]', function (e) {
        e.preventDefault();
        console.log('test');
        var send = $(this).triggerHandler("af.send");

        if ( typeof send !== 'undefined' && send == false) {
            return;
        }
        var $this = $(this);
        var url = $this.attr("action");
        var method = $this.attr("method");
        var data = {};
        var processData = true;
        var contentType = "application/x-www-form-urlencoded";
        
        var options = $.extend(true, {}, {}, $(this).data());
        
        if ("POST" == method.toUpperCase() && $this.attr('enctype') == "multipart/form-data") {
            data = new FormData($this[0]);
            processData = false;
            contentType = false;
        } else {
            data = $(this).serialize();
        }

        $.ajax({
            type: method,
            url: url,
            data:  data,
            dataType: 'json',
            processData : processData,
            contentType : contentType,
            success : function(data, textStatus, jqXHR) {
                
                if (data.success) {
                    toastr.success(data.success);
                }
                $this.trigger('af.success', data);
                $this.closest('.modal').modal('hide');
            },
            error : function(jqXHR, textStatus, errorThrown) {
                $this.trigger('af.error', jqXHR, textStatus, errorThrown);
                if(options.defaultErrorAction === true) {
                    var validator = $this.data("validator");
                    if (validator && jqXHR.status == 422) {
                        
                    } else {
                        toastr.error("Some error occurred, Please reload the page and try again");
                    }
                }
                var $editValidator = $this.validate();
                var responseText = jqXHR.responseText;
                
                if (jqXHR.status == 403) {
                    responseText = $.parseJSON(responseText);
                    $.each(responseText, function (k, v) {           
                      toastr.error(v);
                    });                    
                }
                if (jqXHR.status == 422) {
                  responseText = $.parseJSON(responseText);
                  var error = {};
                  $.each(responseText.errors, function (k, v) {  
                    var arr = k.split('.');
                    k = arr[0];
                    if(arr[1] && arr[1] != ''){
                        k = k+'['+arr[1]+']';
                    }
                    error[k] = v[0];
                  });
                  $editValidator.showErrors(error);
                  var element = $editValidator.errorList[0].element;
                  if($(element).attr('name') == 'dob') {
                    if($editValidator.errorList[1]) {
                        $editValidator.errorList[1].element.focus();
                    } 
                    $('html, body').animate({
                        scrollTop: ($(element).offset().top - 250)
                    },500);
                  } else {                      
                    $editValidator.errorList[0].element.focus();
                  }
                } 
            },
            complete : function(jqXHR, textStatus) {
                if(options.defaultErrorAction === true) {
                    var validator = $this.data("validator");
                }
                $this.trigger('af.complete', jqXHR, textStatus);
            }
        });
    });
});