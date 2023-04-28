$(document).ready(function(){
    $('[data-confirm]').on('click',function(e){
        e.preventDefault();

        var href= $(this).attr('href');
        var message= $(this).data('confirm');

        swal({
        	title: "Etes vous sur?",
        	text: message,
        	type: "warning",
        	showCancelButton: true,
        	cancelButtonText: "Annuler",
        	confirmButtonText: "Oui",
        	confirmButtonColor: "#DD6B55"
        }, function(isConfirm){
        	if (isConfirm) {
        		window.location.href = href;
        	}
        });
    });

});