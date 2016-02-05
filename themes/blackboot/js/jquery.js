$(document).ready(function(){

        $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        
        $('#back-to-top').tooltip('show');

	//to display toggle sub menu
	$('.sub-menu').parent('li').css('background', '#ECECEC').hide();
$('.main-menu').on('click', function(){
    $('.sub-menu').parent('li').toggle();
});	

	//for enabling and disabling input field for allowance
	$('.allowance-checkbox').on('change', function(){
		var next = $(this).parent('td').next().find('input');
		if(next.attr('disabled') == 'disabled'){
			next.removeAttr('disabled');
		}else{
			next.attr('disabled',  'disabled');
		}
	});

	//add new allowance and percentage for staff
	
$('#add-allowance').on('click', function(){
    var allowance = $('select[name="allowance"]').val(),
        percentage = $('input[name="percentage"]').val(),
        id = $('input[name="id"]').val();
        if(allowance != '' && percentage != ''){
        $.ajax({
        	url: '../addAllowance',
        	data: {allowance: allowance, percentage: percentage, id:id},
        	type: 'GET',
        	success: function(response){
        		if(response == 'true'){
        			$.fn.yiiGridView.update('allowance-grid', {
			    });	
        		}
        	}
        });
    }
});

    $('.main').on('click', '.updatee', function(e){
        e.preventDefault();
        var id = $(this).attr('href').split('/');
       
        var count = id.length;
        var id = $.trim(id[count-1]);
        $('input[name="aid"]').val(id);
    });

        $('#update-allowance').on('click', function(){
              var rate = $('input[name="uallowance"]').val();
              var id = $('input[name="aid"]').val();
        if(rate != '')
        {
            $.ajax({
                    url: '../updateStaffAllowance',
                    type: 'GET',
                    data: {id : id, rate:rate},
                    success: function(response){
                            if(response == "true"){
                                $('input[name="uallowance"]').val('');
                                $.fn.yiiGridView.update('allowance-grid', {
                                    });                                 
                            }
                    }
                });
        }

    
    });
});