// here all pendejadas of laixi
$(document).ready(function () {
    $("#mark_phones").click(function(){
        $(".tel-check").prop("checked","true");
    });

    $("#unmark_phones").click(function(){
        $(".tel-check").prop("checked","");
    });

    $("#mark_apps").click(function(){
        $(".ws-check").prop("checked","true");
    });

    $("#unmark_apps").click(function(){
        $(".ws-check").prop("checked","");
    });

    $("#mark_apps1").click(function(){
        $(".ws-check1").prop("checked","true");
    });

    $("#unmark_apps1").click(function(){
        $(".ws-check1").prop("checked","");
    });

    $("#mark_apps2").click(function(){
        $(".ws-check2").prop("checked","true");
    });

    $("#unmark_apps2").click(function(){
        $(".ws-check2").prop("checked","");
    });

    $("#mark_apps3").click(function(){
        $(".ws-check3").prop("checked","true");
    });

    $("#unmark_apps3").click(function(){
        $(".ws-check3").prop("checked","");
    });

    $("#mark_apps4").click(function(){
        $(".ws-check4").prop("checked","true");
    });

    $("#unmark_apps4").click(function(){
        $(".ws-check4").prop("checked","");
    });

    $("#mark_apps5").click(function(){
        $(".ws-check5").prop("checked","true");
    });

    $("#unmark_apps5").click(function(){
        $(".ws-check5").prop("checked","");
    });

    $("#devices").change(function (e) { 
        // e.preventDefault();
        $("#props").css("display","none");
        console.log($(this).val()); 

        const ip = $(this).val().split("-")[1];
        const pc = $(this).val().split("-")[0];


        // verificar estado conexion
        // mostrar estado conexion
        // si tiene conexion continuamos
        // de lo contrario mostramos alerta de desconectado


        
        $.get(`/props.php?pc=${pc}`, {},
            function (data, textStatus, jqXHR) {
                console.log(JSON.parse(data));
                d=JSON.parse(data);
                d.forEach(el => {

                });
                // es necesario graficar en pantalla todas las props
                $("#props").css("display","block");
            }            
        );
        
    });
});