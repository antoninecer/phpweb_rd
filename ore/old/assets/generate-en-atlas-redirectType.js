
    $(document).ready(function() {
        var BASE_URL = '\x2Fore';

        $('.form').on('change', '#obj_type, #ap_type', function() {
            $('#update_overlay').show();
            $('#is_update').val(1);
            $('#Apartment-form').submit(); return false;
        });
        
        if(1){
            setInterval(function() { 
                $('#is_auto_save').val(1);
                
                $.ajax({
                    type: 'post',
                    url: $('#Apartment-form').attr('action'),
                    data: $('#Apartment-form').serialize(),
                    success: function () {
                        message('Autosave\x20is\x20done');
                    },
                    complete: function () {
                        $('#is_auto_save').val(0);
                    },
                }); 
            }, 15000);
        }        

    });
	