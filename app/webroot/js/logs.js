$(document).ready(function () {
    $(".film").click(function () {
        //e.preventDefault();
        //var film_name = $(this).text();
        var user_id = $('#user_id').val();
        var film_id = $(this).attr("href").match(/\d+/)[0];
        //console.log(film_id);
        $.ajax({
            method: 'POST',
            url: '/film_hunter/logs/write',
            data: {user_id: user_id, film_id: film_id},
            //dataType: 'json',
        }).done(function(data){
            console.log(data);
        });
        //alert(user_id);
    });
});