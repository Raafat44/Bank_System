/*$(function(){
    $('[placeholder]').focus(function(){
        $(this).attr("data-text",$(this).attr('placeholder'));
        $(this).attr('placeholder','');
    })
    $('[placeholder]').blur(function(){
        $(this).attr( 'placeholder',$(this).attr('data-text'));
    })
})
*/
function request(urlp,actionp,methodp ,id)
{
    $.ajax({
        url:urlp,
        type:methodp,
        data:{
            action : actionp,
            ID : id
        },
        success:function()
        {
            location.reload(true);
        }
    })
}
$('input.search').on('keyup',function() {
    if(!$(this).val())
    {
        $("table tr").show();
    }else
    {
        var userName = $(this).val().toLowerCase();
        if($("table").find("[data-id^='" + $(this).val() + "']").length >0 || $("table").find("[data-name^='" + userName + "']").length>0)
        {
            $("table").find("[data-id^='" + $(this).val() + "']").siblings().hide();
            $("table").find("[data-name^='" + userName + "']").siblings().hide();
            $("table").find("[data-name^='" + userName + "']").show();
            $("table").find("[data-id^='" + $(this).val() + "']").show();
        }else
        {
            $("table tbody tr ").hide();
        }
    }
});
