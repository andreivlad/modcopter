mod = {
    init: {
        initModelGeneration: function() {
            $('#XUploadForm-form').bind('fileuploadprogressall', function (e, data) {
                if (data.loaded == data.total){
                    $('#processing-generate').show();
                    $("#processing-dialog").dialog();

                    //Ajax request to execute shell script
                    $.post('site/generateModel', function() {
                        //Check if model is ready after a few minutes
                        setTimeout(mod.modelGeneration.requestRepeater,  1 * 60 * 1000);
                    });
                }
            });
        }
    },
    modelGeneration: {
        requestRepeaterInterval: null,
        //Gets called a few minutes after model generation is started
        requestRepeater:function () {
            mod.modelGeneration.requestRepeaterInterval =
                //Check every 10 seconds if model is ready
                setInterval(mod.modelGeneration.getModelLinkIfReady, 10 * 1000);
        },
        //Gets called every 10 seconds to check if model is ready
        getModelLinkIfReady: function () {
            $.post('site/isModelReady', function(response) {
                if(response.ready) {
                    //Model is ready, download the model
                    clearInterval( mod.modelGeneration.requestRepeaterInterval);
                    $('body').append('<iframe src="site/downloadModel" style="display: none;" ></iframe>');
                    $('#processing-generate').hide();
                    $("#processing-dialog").dialog('close');
                }
            });
        }
    }
}