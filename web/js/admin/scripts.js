/**
 * Created by Василий on 04.12.2016.
 */

$(document).ready(function () {
    $('#employee-is_in_education').on('change',function () {
        if($(this).val()==0){
            $('.field_cyclic_commission_id').addClass('hidden');
        } else {
            $('.field_cyclic_commission_id').removeClass('hidden');
        }
    })
})
