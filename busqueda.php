<?php
    include('./includesphp/authentication.php');
    include('./includesphp/header.php');
    //include('./includesphp/conexion.php');
    
?>
<!-- Begin page content -->
<main class="flex-shrink-0" style="padding-top:60px !important;" id="home">
  <div class="container text-center">
    <h1 class="mt-2">@EurekaMoney</h1>
    <!-- <p class="lead">Pin a footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS. A fixed navbar has been added with <code class="small">padding-top: 60px;</code> on the <code class="small">main &gt; .container</code>.</p>
    <p>Back to <a href="/docs/5.3/examples/sticky-footer/">the default sticky footer</a> minus the navbar.</p>-->
    <a class="btn btn-primary" href="index.php"><b>Inicio</b></a>
    <hr>
    <div class="container">

        <div class="row d-flex justify-content-center">
            <div class="col-12 col-lg-8 col-xl-6 mt-4 row">
                <div class="col-12">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" id="prefijo" placeholder="Nombre del contacto..." aria-describedby="selcode">
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-lg">
                    
                        <input type="number" class="form-control" id="txtnum" placeholder="Numero telefonico..." aria-describedby="selcode">
                        
                    </div>
                </div>
                <div class="col-12">
                    <div class="mt-3">
                        <button type="button" class="btn btn-success btn-lg fw-bold" id="btndel"><b>Limpiar</b></button>
                    </div>
                </div>   
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-12 col-lg-8 col-xl-6 mt-4" id="tbsearch">
                <div class="card">
                    <div class="card-body">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr class="table-dark">
                                <th scope="col">#</th>
                                <th scope="col">Num.</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Contacto</th>
                                <th scope="col">Accion</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                        </tbody>

                        </table>

                        <blockquote class="blockquote mb-0">
                        <p>El mundo se hizo para los grandes!.</p>
                        <footer class="blockquote-footer">Someone famous in <cite title="Source Title">RD</cite></footer>
                        </blockquote>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</main>
<script src="./src/js/script1.js" ></script>
<?php
    include('./includesphp/footer.php');
?>