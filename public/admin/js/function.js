// show staff 
function submitForm(elem) {
    if (elem.value) {
        elem.form.submit();
    }
}
// filter department 
function submitFormDepartment(elem) {
    if (elem.value) {
        elem.form.submit();
    }
}
//delete Confirm
function deleteConfirm(msg){
    if(window.confirm(msg)){
        return true;
    }
    return false;
}



$(document).ready(function() {

    //hide message
    $('#message').delay(3000).slideUp("slow");

    $('#dataTables-example').DataTable({
        ponsive: true,
    });



    // choose multi staff
    $('#staff').SumoSelect();

    // enter tooltip
    $('.tooltip-staff').tooltip({html: true})
    
   

    //Processbar 

    var $pb = $('.progress .progress-bar');
    $.each([ 0,1,2,3,4,5,6,7,8,9,10 ], function( index, value ) {
		$("#point-"+value).click(function() {
            $pb.attr('data-transitiongoal', value*10).progressbar({display_text: 'center'});
        });
	});

    


});


