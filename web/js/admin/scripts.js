$(document).ready(function () {
    $(document).on('click', '.action-button', function (e) {
        e.preventDefault();
        var data;
        if ($(this).attr('data-key')) {
            data = $(this).closest("form").serialize() + "&save=0&" + $(this).attr('data-action') + "=1" + "&data-key="+$(this).attr('data-key');
        } else {
            data = $(this).closest("form").serialize() + "&save=0&" + $(this).attr('data-action') + "=1";
        }
        var containerID = '#' + $(this).closest('.tab-pane').attr('id');
        $.pjax({
            url: location.href,
            type: "POST",
            container: containerID,
            fragment: containerID,
            scrollTo: false,
            timeout: 3000,
            data: data
        });
    });
    $(document).on('click','.save-btn',function (event) {
        var data = $(this).closest("form").serialize() + "&save=1";
        if (typeof($(this).attr('data-action')) != 'undefined') {
            data += '&stay=1';
        }
        $.pjax.reload({
            type: "POST",
            container: "#pjax-container",
            scrollTo: false,
            timeout: 3000,
            data: data
        });
    });

    /**
     * Save menu position to cookie
     */
    var expandMainMenu = tools.cookie.get('expandMainMenu');

    jQuery('.menu-button').on('click', function () {
        setTimeout(function () {
            tools.cookie.set('expandMainMenu', !jQuery('.sidebar').hasClass('closed'));
        });
    });

    if (expandMainMenu == 'true') {
        jQuery('.sidebar').removeClass('closed');
        jQuery('#page-wrapper').removeClass('maximized');
    }
});

$(document).ready(function () {
    $('#employee-is_in_education').on('change',function () {
        if($(this).val()==0){
            $('.field_cyclic_commission_id').addClass('hidden');
        } else {
            $('.field_cyclic_commission_id').removeClass('hidden');
        }
    })
})
