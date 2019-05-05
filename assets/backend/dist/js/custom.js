$(function(){
	$('#openFrmDiv').click(function(){		
		$('.openformCntDiv').slideToggle();
		$(this).toggleClass('openCloseIcn')
	});
	$('#employee-association').on('change',function(){
		if($(this).val()=='1')
			$('#employee-end_date').removeAttr('disabled');
		else
			$('#employee-end_date').attr('disabled','disabled');
	});
	
	$("#country").change(function () {
	    $("#state, #city").find("option:gt(0)").remove();
	    $("#state").find("option:first").text("Loading...");
	    $.getJSON("states", {
	        country_id: $(this).val()
	    }, function (json) {
	        $("#state").find("option:first").text("");
	        for (var i = 0; i < json.length; i++) {
	            $("<option/>").attr("value", json[i].id).text(json[i].name).appendTo($("#state"));
	        }
	    });
	});
	$("#state").change(function () {
	    $("#city").find("option:gt(0)").remove();
	    $("#city").find("option:first").text("Loading...");
	    $.getJSON("cities", {
	        state_id: $(this).val()
	    }, function (json) {
	        $("#city").find("option:first").text("");
	        for (var i = 0; i < json.length; i++) {
	            $("<option/>").attr("value", json[i].id).text(json[i].name).appendTo($("#city"));
	        }
	    });
	});
	
});