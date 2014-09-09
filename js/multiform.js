$(function() {

    function selectStep(thisStep,step)
    {
			//disable first button if this is step 1
            if (("formstep1" == thisStep || step=='formstep1') && ("formstep2" != step))
            {
                $("#prevStepBtn").hide();
            }
            else
            {
				$("#prevStepBtn").show();
            }
            //if we are on last step hide nextstep button
            if ("formstep3" == step)
            {
                $("#nextStepBtn").val('Save Data');
            }
            else
            {
                $("#nextStepBtn").val('Next step');
            }
			//get current form data to be passed later

			var formData = $("#"+thisStep).serialize();
            //put name of step that is going to be edited
			$(".multiform_part").html("Loading...");

			//send data to php, and draw new form
            $.post('processForm.php',{currStep: thisStep, newStep: step , formData: formData},function(data)
            {
				//draw new form
                if(step=="getAllData")
                {
                    $("#form_step_nav_wrap").hide();
                }
				$(".multiform_part").html(data);
            }); 
    }	

	//Events Initialization
	
	// Next Step Button
	$("#nextStepBtn").click(function(e)
    {
		e.preventDefault();
		selectStep($("form").attr('id'),$("span#nextstep").text());
	});

	// Previous Step Button
	$("#prevStepBtn").click(function(e)
    {
		e.preventDefault();
        selectStep($("form").attr('id'),$("span#prevstep").text());
	});

	//default form to show
	selectStep("formstep1","formstep1");
});
