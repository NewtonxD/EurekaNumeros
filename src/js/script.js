  
var timeout;

var codes=[];

var num_procesados=0;

function subrayar(){
    var input, filter, table, tr, td, i, txtValue, index;
  input = document.getElementById("txtnum");
  filter = input.value.toUpperCase();
  table = document.getElementById("table1");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;

      // first clear any previously marked text
      // this strips out the <mark> tags leaving text (actually all tags)
      td.innerHTML = txtValue;

      index = txtValue.toUpperCase().indexOf(filter);
      if (index > -1) {

        // using substring with index and filter.length 
        // nest the matched string inside a <mark> tag
        td.innerHTML = txtValue.substring(0, index) + "<mark>" + txtValue.substring(index, index + filter.length) + "</mark>" + txtValue.substring(index + filter.length);

      } 
    }
  }
}

function borrarNumero(num){
    if (confirm("Desea borrar este numero?")) {
        borrarNum(num);
    }
}
  
function codeOptions(){

    $.ajax({
        url:'options.php',
        type:"GET",
        async:true,
        success: function(response){
            var res=$.parseJSON(response);
            for(e in res){
                codes[res[e].id]=res[e].limite;
                $('.selcode').append('<option value="' + res[e].id + '">' + res[e].code + '</option>');
            }
        }
    });

}

function buscarNumeros(){
    $('#txtnum').blur();
    $('#spinload').css("visibility","visible");

    $.ajax({
        url:'numbers.php',
        type:"GET",
        async:false,
        data:{num:$("#txtnum").val(),code:$("#selcode").val()},
        success: function(response){
            var res=$.parseJSON(response);
            console.log(res);
            $("#tbody").empty();
            for(e in res){
                $("#tbody").append(
                '<tr>'+
                `    <td>${res[e].id}</td>`+
                `    <td>${res[e].num}</td>`+
                `    <td>${res[e].pais}</td>`+
                `    <td><a class="btn btn-danger fw-bold" onclick="borrarNumero(${res[e].id})"> - </></td>`+
                '</tr>'
                );
            }
            $('#spinload').css("visibility","hidden");
            subrayar();
        },
        error: function(response){
            console.log(response);
        }
    });

    //borrar valor del campo

}

function guardarNumero(){
    $('#txtnum').blur();
    $('#txtnum').attr("disabled","disabled");
    $('#selcode').attr("disabled","disabled");
    $('#spinload').css("visibility","visible");

    $.ajax({
        url:'numbers.php',
        type:"POST",
        async:false,
        data:{num:$("#txtnum").val(),code:$("#selcode").val()},
        success: function(response){
            var res=$.parseJSON(response);
            if(res[0].result==="sucess") num_procesados+=1;

            $("#results").append(
            `<div class="alert alert-${res[0].result} alert-dismissible" role="alert">`+
            `   <div> ${res[0].result=="success"?num_procesados+".":""} ${res[0].text}</div>`+
            '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
            '</div>');
        },
        error: function(response){
            console.log(response);
        }
    });

    //borrar valor del campo
    $('#spinload').css("visibility","hidden");
    $('#txtnum').val("");
    $('#txtnum').focus();
    $('#txtnum').removeAttr("disabled");
    $('#selcode').removeAttr("disabled");
}

function borrarNum(num){
    $('#txtnum').blur();
    $('#txtnum').attr("disabled","disabled");
    $('#selcode').attr("disabled","disabled");
    $('#spinload').css("visibility","visible");

    $.ajax({
        url:'del-numbers.php',
        type:"POST",
        async:false,
        data:{id:num},
        success: function(response){
            var res=$.parseJSON(response);
            if (res[0].result=="success") {

                $('#table1 tr').each(function(){
                    var firstColumnData = $(this).find('td:first').text();
                    if(firstColumnData == num) {
                        $(this).remove();
                    }
                });

            }
            $("#results").append(
            `<div class="alert alert-${res[0].result} alert-dismissible" role="alert">`+
            `   <div> ${res[0].text}</div>`+
            '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
            '</div>');
        },
        error: function(response){
            console.log(response);
        }
    });

    //borrar valor del campo
    $('#spinload').css("visibility","hidden");
    $('#txtnum').val("");
    $('#txtnum').focus();
    $('#txtnum').removeAttr("disabled");
    $('#selcode').removeAttr("disabled");
}

$(document).ready(function(){


    
    codeOptions();


    //fill all data on table

    $('input[type=number][max]:not([max=""])').on('input', function(ev) {
        var $this = $(this);
        var maxlength = $this.attr('max').length;
        var value = $this.val();
        if (value && value.length >= maxlength) {
            $this.val(value.substr(0, maxlength));
        }
    });

    $("#btnadd").on("click",guardarNumero);


    $('#txtnum').keyup(function (e) {
        var $this = $(this);
        var maxlength = $("#maxlen").val();
        var value = $this.val();
        if (value && value.length >= maxlength) {
            $this.val(value.substr(0, maxlength));
        }

        if($("#switcher").is(":checked")) {
            clearTimeout(timeout);
            timeout=setTimeout(function(e){
                
                buscarNumeros();

            },1300);

        }else{

            if($this.val().length == maxlength){
                guardarNumero();
            } 
        }

    });

        
    
    $('#switcher').change(function(e){
        $('#txtnum').val("");
        $('#txtnum').focus();

        if($(this).is(":checked")) {
            $('#txtnum').removeAttr("disabled");
            $("#tbsearch").css("display","block");
            $("#btnadd").css("display","block");

            if ($('#selcode').val()==0) 
                $("#btnadd").attr("disabled","disabled");
            else $("#btnadd").removeAttr("disabled");

        }else{
            if ($('#selcode').val()==0) 
                $('#txtnum').attr("disabled","disabled");
            else $('#txtnum').removeAttr("disabled");

            $("#tbsearch").css("display","none");
            $("#btnadd").css("display","none");
        }
    });

    $('#selcode').change(function(e){
        if($(this).val()>0) {
            $("#maxlen").val(codes[$('#selcode').val()]);

            $('#txtnum').val("");
            $('#txtnum').focus();
            $("#btnadd").removeAttr("disabled");
            $('#txtnum').removeAttr("disabled");
        }else{
            if($("#switcher").is(":checked")) {
                $("#btnadd").attr("disabled","disabled");
            }
            else $("#txtnum").attr("disabled","disabled");
            
        };
    });
});