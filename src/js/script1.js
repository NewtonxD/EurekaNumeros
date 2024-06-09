
var timeout;

var codes=[];

var verificado=false;

var num_procesados=0;

function subrayar(){
    var input, filter, table, tr, td, i, txtValue, index;
  input = document.getElementById("txtnum");
  filter = input.value.toUpperCase();
  table = document.getElementById("table1");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;

      td.innerHTML = txtValue;

      index = txtValue.toUpperCase().indexOf(filter);
      if (index > -1) {

        td.innerHTML = txtValue.substring(0, index) + "<mark>" + txtValue.substring(index, index + filter.length) + "</mark>" + txtValue.substring(index + filter.length);

      } 
    }
  }
}

function buscarNumeros(){
    $('#txtnum').blur();

    $.ajax({
        url:'numbers.php',
        type:"GET",
        async:false,
        data:{num:$("#txtnum").val(),code:$("#selcode").val()},
        success: function(response){
            var res=$.parseJSON(response);
            $("#tbody").empty();
            for(e in res){
                $("#tbody").append(
                '<tr>'+
                `    <td>${res[e].id}</td>`+
                `    <td>${res[e].num}</td>`+
                `    <td>${res[e].fecha}</td>`+
                `    <td><a class="btn btn-danger fw-bold" onclick="borrarNumero(${res[e].id})"> - </></td>`+
                '</tr>'
                );
            }
            subrayar();
        },
        error: function(response){
            console.log(response);
        }
    });

    //borrar valor del campo

}

function borrarNum(num){
    $('#txtnum').blur();

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
            $("#results").prepend(
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
    $('#txtnum').val("");
    $('#txtnum').focus();
}

$(document).ready(function(){


    $('#txtnum').keyup(function (e) {
        clearTimeout(timeout);
        timeout=setTimeout(function(e){
            
            buscarNumeros();

        },1600);
    });
});

