<?php
    include('./includesphp/authentication.php');
    include('./includesphp/header.php');
    //include('./includesphp/conexion.php');
    
?>

    

<!-- Begin page content -->
<main class="flex-shrink-0" style="padding-top:60px !important;" id="home">
  <div class="container text-center">
    <h1 class="mt-2">@EurekaMoney</h1>
    <a class="btn btn-primary" href="busqueda.php"><b>Busqueda</b></a>
    <!-- <p class="lead">Pin a footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS. A fixed navbar has been added with <code class="small">padding-top: 60px;</code> on the <code class="small">main &gt; .container</code>.</p>
    <p>Back to <a href="/docs/5.3/examples/sticky-footer/">the default sticky footer</a> minus the navbar.</p>-->
    <hr>

    <div class="row g-3 d-flex justify-content-center mb-4 mt-2">
        <div class="col-auto">
            <input type="hidden" value="99" id="maxlen"/>
            <div class="form-check form-switch">
                <!--<input class="form-check-input" type="checkbox" style="width:60px;height:24px" role="switch" id="switcher" max="9999999999">
                    <label class="form-check-label ms-4 mt-1" for="switcher">Busqueda de datos</label>-->
                <input class="form-check-input" type="checkbox" style="width:60px;height:24px" role="switch" id="switch-archivos" max="9999999999">
                <label class="form-check-label ms-4 mt-1  fw-bold" for="switch-archivos">Procesar Archivos</label>
            </div>
        </div>
    </div>
    <div class="row g-3 d-flex justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6 row" id="numeros">
            <div class="col-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-text"> + </span>
                    <!--<select id="selcode" class="input-group-text selcode">
                        <option value="0" selected> +# </option>
                    </select>-->
                    <input type="number" class="form-control" id="selcode" placeholder="" aria-describedby="selcode">
                    
                </div>
            </div>
            <div class="col-8">
                <div class="input-group input-group-lg">
                
                    <input type="number" class="form-control" id="txtnum" placeholder="" aria-describedby="selcode">
                    <button type="button" id="btnadd" class="fw-bold btn btn-primary" disabled>+</button>
                </div>
            </div>
            <div class="col-12">
                <div class="mt-3">
                    <button type="button" class="btn btn-success btn-lg fw-bold" id="btndel"><b>Limpiar</b></button>
                </div>
            </div>   
            <img height="35px"src="src/img/loading-7528_256.gif" class="mt-2 mb-2" id="spinload" style="visibility:hidden" />
        </div>
        <div class="col-12 col-lg-8 row d-flex justify-content-center" style="position:absolute; visibility:hidden;" id="files">
            
            
            <div class="col-12 col-md-6 mb-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-text">Prefijo</span>
                    <input type="text" class="form-control" id="pre" name="prefix" placeholder="">
                    
                </div>
            </div>
            <div class="col-12 col-md-6 mb-4">

                <div class="input-group input-group-lg">
                    <span class="input-group-text">Añadir Repetidos</span>
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" type="checkbox" id="repetido" name="repetido" value="" aria-label="Checkbox for following text input">
                    </div>
                </div>
                    
            </div>

            <div class="col-12 col-md-12 mb-4">
                <div class="input-group input-group-lg">
                    <input type="file" class="form-control" name="filenumber" id="filenumber" aria-describedby="btnfile" multiple accept=".csv"/>
                    <button type="button" class="btn btn-secondary fw-bold "  id="btnfile"><b>Procesar</b></button>
                </div>
            </div>
            <div class="col-12 col-lg-10 text-center mt-4">
                <h4>Ultimos archivos exportados:</h4>
                <div id="fileList" class="list-group fileList"></div>
            </div>
        </div>
        <div class="col-12 col-lg-10">
            <div id="results"></div>
        </div>
    </div>
  </div>
</main>
<script src="./src/js/script.js" ></script>
<?php
    include('./includesphp/footer.php');
?>