jQuery(document).ready(function($){
	// Ajax user search
    $('.opalestate-ajax-user-search').on('keyup', function () {
        var user_search = $(this).val();
        var exclude = '';

        if ($(this).data('exclude')) {
            exclude = $(this).data('exclude');
        }

        $('.opalestate-ajax').show();
        data = {
            action: 'opalestate_search_users',
            user_name: user_search,
            exclude: exclude
        };

        document.body.style.cursor = 'wait';

        $.ajax({
            type: "POST",
            data: data,
            dataType: "json",
            url: ajaxurl,
            success: function (search_response) {
                $('.opalestate-ajax').hide();
                $('.opalestate_user_search_results').removeClass('hidden');
                $('.opalestate_user_search_results span').html('');
                $(search_response.results).appendTo('.opalestate_user_search_results span');
                document.body.style.cursor = 'default';
            }
        });
    });

   $('body').on('click.opalestateSelectUser', '.opalestate_user_search_results span a', function (e) {
        e.preventDefault();
        var login = $(this).data('login');
        $('.opalestate-ajax-user-search').val(login);
        $('.opalestate_user_search_results').addClass('hidden');
        $('.opalestate_user_search_results span').html('');
    });

    $('body').on('click.opalestateCancelUserSearch', '.opalestate_user_search_results a.opalestate-ajax-user-cancel', function (e) {
        e.preventDefault();
        $('.opalestate-ajax-user-search').val('');
        $('.opalestate_user_search_results').addClass('hidden');
        $('.opalestate_user_search_results span').html('');
    });



});