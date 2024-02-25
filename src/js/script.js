  
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

function verificarNumero(){
    if ($("#txtnum").val()>0){
        var codigo=$("#selcode").val()==""?"NULL":$("#selcode").val();
        $.ajax({
            url:'ver-numbers.php',
            type:"POST",
            async:false,
            data:{num:$("#txtnum").val(),code:codigo},
            success: function(response){
                var res=$.parseJSON(response);
                if(res[0].result=="success") $("#btnadd").removeAttr("disabled");

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
    }  
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
            $("#tbody").empty();
            for(e in res){
                $("#tbody").append(
                '<tr>'+
                `    <td>${res[e].id}</td>`+
                `    <td>${res[e].num}</td>`+
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

    if($("#txtnum").val()!=""){
        $('#txtnum').blur();
        $('#spinload').css("visibility","visible");
        
        $.ajax({
            url:'numbers.php',
            type:"POST",
            async:false,
            data:{num:$("#txtnum").val(),code:$("#selcode").val()},
            success: function(response){
                var res=$.parseJSON(response);
                if(res[0].result==="success") num_procesados+=1;

                $("#results").prepend(
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
        $("#btnadd").attr("disabled","disabled");
        $('#txtnum').focus();
    } 
}

function borrarNum(num){
    $('#txtnum').blur();
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
    $('#spinload').css("visibility","hidden");
    $('#txtnum').val("");
    $('#txtnum').focus();
}

function procesarArchivo(){
    if($("#pre").val()==""){
        $("#pre").focus();
        $("#results").prepend(
        `<div class="alert alert-danger alert-dismissible" role="alert">`+
        `   <div> Debe llenar el prefijo para poder nombrar los contactos Ejm: ABC 01 .</div>`+
        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '</div>');
        return;
    }

    var fileInput = $('#filenumber');
    if (fileInput.prop("files").length === 0) {
        $("#results").prepend(
            `<div class="alert alert-danger alert-dismissible" role="alert">`+
            `   <div> Debe llenar escoger el archivo antes de empezar .</div>`+
            '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
            '</div>');
            return;
    }

    var formData=new FormData();
    formData.append("filenumber",$("#filenumber").prop("files")[0]);
    formData.append("prefix",$("#pre").val());

    $.ajax({
        url:'file-numbers.php',
        type:"POST",
        async:false,
        data:formData,
        processData: false,
        contentType: false,
        success: function(response){
            //var res=$.parseJSON(response);
            console.log(response);
            /*if(res[0].result==="success") num_procesados+=1;

            $("#results").prepend(
            `<div class="alert alert-${res[0].result} alert-dismissible" role="alert">`+
            `   <div> ${res[0].result=="success"?num_procesados+".":""} ${res[0].text}</div>`+
            '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
            '</div>');*/

            var blob = new Blob([response], { type: 'text/x-vcard' });
            var url = window.URL.createObjectURL(blob);

            // Create a link element and trigger download
            var a = document.createElement('a');
            a.href = url;
            a.download = 'dummy_contact.vcf';
            document.body.appendChild(a);
            a.click();

            // Cleanup
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        },
        error: function(response){
            console.log(response);
        }
    });  
}

function listFiles(){
    $.ajax({
        url: 'get_files.php', // PHP script to retrieve file list
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Sort files by creation date in descending order
            response.sort(function(a, b) {
                return new Date(b.creation_date) - new Date(a.creation_date);
            });

            // Iterate over file list and append to HTML
            $.each(response, function(index, file) {
                $('#fileList').append('<a  class="list-group-item list-group-item-action" href="download.php?filename=' + file.filename + '">' + file.filename + '</a>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching file list:', error);
            // Handle errors
        }
    });
}

$(document).ready(function(){


    
    //codeOptions();


    //fill all data on table

    /*$('input[type=number][max]:not([max=""])').on('input', function(ev) {
        var $this = $(this);
        var maxlength = $this.attr('max').length;
        var value = $this.val();
        if (value && value.length >= maxlength) {
            $this.val(value.substr(0, maxlength));
        }
    });*/

    listFiles();

    $("#btnadd").on("click",guardarNumero);

    $("#btnfile").on("click",procesarArchivo);


    $('#txtnum').keyup(function (e) {
        /*var $this = $(this);
        var maxlength = $("#maxlen").val();
        var value = $this.val();
        if (value && value.length >= maxlength) {
            $this.val(value.substr(0, maxlength));
        }*/


        $("#btnadd").attr("disabled","disabled");

        if($("#switcher").is(":checked")) {
            clearTimeout(timeout);
            timeout=setTimeout(function(e){
                
                buscarNumeros();

            },1600);

        }else{

            clearTimeout(timeout);
            timeout=setTimeout(function(e){
                
                verificarNumero();

            },1600);
            /*if($this.val().length == maxlength){
                guardarNumero();
            } */
        }

    });

    $("#btndel").on("click",function(){ 
        $("#txtnum").val(""); 
        $("#btnadd").attr("disabled","disabled");
        $("#txtnum").focus(); 
    });    
    
    $('#switcher').change(function(e){
        $('#txtnum').val("");
        $('#txtnum').focus();

        if($(this).is(":checked")) {
            $("#tbsearch").css("display","block");

        }else{

            $("#tbsearch").css("display","none");
        }
    });

    $('#switch-archivos').change(function(e){
        $('#txtnum').val("");

        if($('#switch-archivos').is(":checked")) {

            $("#numeros").css("visibility","hidden");
            $("#numeros").css("position","absolute");

            $("#files").css("visibility","visible");
            $("#files").css("position","relative");



        }else{

            $("#files").css("visibility","hidden");
            $("#files").css("position","absolute");

            $('#txtnum').focus();

            $("#numeros").css("visibility","visible");
            $("#numeros").css("position","relative");
        }
    });

    $('#selcode').keypress(function(e) {
        // Check if the pressed key is Enter (key code 13)
        if (e.which == 13) {
          // Prevent default action of Enter key (form submission)
          e.preventDefault();
          
          
            $('#txtnum').focus();
          
        }
      });

        // AJAX request to retrieve file list from server
    
    /*$('#selcode').change(function(e){
        if($(this).val()>0) {
            $("#maxlen").val(codes[$('#selcode').val()]);

            //$('#txtnum').val("");
            //$('#txtnum').focus();
        }
    });*/
});