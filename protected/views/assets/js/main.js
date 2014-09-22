mod = {
    init: {
        initModelGeneration: function() {
            $('#XUploadForm-form').bind('fileuploadprogressall', function (e, data) {
                if (data.loaded == data.total){
                    $('#processing-generate').show();
                    $( "#processing-dialog" ).dialog();

                    //Ajax request to execute shell script
                    $.post('site/generateModel', function() {
                        //Check if model is ready after 5 minutes
                        setTimeout(mod.modelGeneration.requestRepeater,  5 * 60 * 1000);
                    });
                }
            });
        }
    },
    modelGeneration: {
        requestRepeaterInterval: null,
        //Gets called 5 minutes after model generation is started
        requestRepeater:function () {
            mod.modelGeneration.requestRepeaterInterval =
                //Check every 30 seconds if model is ready
                setInterval(mod.modelGeneration.getModelLinkIfReady, 30 * 1000);
        },
        //Gets called every 30 seconds to check if model is ready
        getModelLinkIfReady: function () {
            $.post('site/isModelReady', function(response) {
                if(response.ready) {
                    //Model is ready, download the model
                    clearInterval( mod.modelGeneration.requestRepeaterInterval);
                    $('body').append('<iframe src="/site/downloadModel" style="display: none;" ></iframe>');
                }
            });
        }
    }
}