<?php
    include('./includesphp/authentication.php');
    include('./includesphp/header.php');
    include('./includesphp/conexion.php');
    
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
            <div class="col-12 col-lg-8 col-xl-6 mt-4">
                <h1>Laixi Server</h1>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-12 col-lg-8 col-xl-6 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h2>Dispositivos</h2>
                        <select class="form-select" id="devices">
                            <option value="0" selected disabled>Seleccione</option>
                            <?php
                                $query="SELECT name,ip, MAX(created_at) as created_at FROM pcinfo GROUP BY name,ip";
                                $connection = connect();
                                $result = mysqli_query($connection,$query);
                                while($row = mysqli_fetch_array($result)) {
                                    echo "<option value='".$row['name']."-".$row['ip']."'>".$row['name']." - ".$row['ip']."</option>";
                                }
                                mysqli_close($connection);
                            ?>
                        </select>
                        <div class="mt-2" style="display:none;" id="estado_conexion_div">
                            <h5 id="estado_conexion_contenido">Conectado <div class="spinner-grow spinner-grow-sm text-success" role="status">
                                <span class="visually-hidden"></span>
                            </div></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-center" id="props" style="display:none !important;">
            <div class="col-12 col-lg-8 col-xl-6 mt-4">
                <div class="card">
                    <div class="card-header">
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs card-header-tabs" id="propertyTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="properties-tab" data-bs-toggle="tab" href="#properties" role="tab" aria-controls="properties" aria-selected="true">Propiedades</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="advance-tab" data-bs-toggle="tab" href="#advance" role="tab" aria-controls="advance" aria-selected="false">Avanzado</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="propertyTabContent">
                            <!-- Properties Tab Content -->
                            <div class="tab-pane fade show active" id="properties" role="tabpanel" aria-labelledby="properties-tab">
                            <div>
                                <button class="btn btn-secondary" id="mark_phones">
                                    <svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 18.837891 3.2832031 L 6.8183594 15.302734 L 1.1621094 9.6464844 L 0.453125 10.353516 L 6.8183594 16.716797 L 19.546875 3.9902344 L 18.837891 3.2832031 z " style="fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Telefonos
                                </button>
                                <button class="btn btn-secondary" id="unmark_phones"><svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 2.9296875 2.2226562 L 2.2226562 2.9296875 L 9.2929688 10 L 2.2226562 17.070312 L 2.9296875 17.777344 L 10 10.707031 L 17.070312 17.777344 L 17.777344 17.070312 L 10.707031 10 L 17.777344 2.9296875 L 17.070312 2.2226562 L 10 9.2929688 L 2.9296875 2.2226562 z " style="fill:#FFF; fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Telefonos
                                </button>
                                <hr>
                                <button class="btn btn-secondary" id="mark_apps"><svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 18.837891 3.2832031 L 6.8183594 15.302734 L 1.1621094 9.6464844 L 0.453125 10.353516 L 6.8183594 16.716797 L 19.546875 3.9902344 L 18.837891 3.2832031 z " style="fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Todos Ws
                                </button>
                                <button class="btn btn-secondary" id="unmark_apps"><svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 2.9296875 2.2226562 L 2.2226562 2.9296875 L 9.2929688 10 L 2.2226562 17.070312 L 2.9296875 17.777344 L 10 10.707031 L 17.070312 17.777344 L 17.777344 17.070312 L 10.707031 10 L 17.777344 2.9296875 L 17.070312 2.2226562 L 10 9.2929688 L 2.9296875 2.2226562 z " style="fill:#FFF; fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Todos Ws
                                </button>
                                <hr>
                                <button class="btn btn-secondary" id="mark_apps1"><svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 18.837891 3.2832031 L 6.8183594 15.302734 L 1.1621094 9.6464844 L 0.453125 10.353516 L 6.8183594 16.716797 L 19.546875 3.9902344 L 18.837891 3.2832031 z " style="fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Todos Ws 1
                                </button>
                                <button class="btn btn-secondary" id="unmark_apps1"><svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 2.9296875 2.2226562 L 2.2226562 2.9296875 L 9.2929688 10 L 2.2226562 17.070312 L 2.9296875 17.777344 L 10 10.707031 L 17.070312 17.777344 L 17.777344 17.070312 L 10.707031 10 L 17.777344 2.9296875 L 17.070312 2.2226562 L 10 9.2929688 L 2.9296875 2.2226562 z " style="fill:#FFF; fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Todos Ws 1
                                </button>
                                <hr>
                                <button class="btn btn-secondary" id="mark_apps2"><svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 18.837891 3.2832031 L 6.8183594 15.302734 L 1.1621094 9.6464844 L 0.453125 10.353516 L 6.8183594 16.716797 L 19.546875 3.9902344 L 18.837891 3.2832031 z " style="fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Todos Ws 2
                                </button>
                                <button class="btn btn-secondary" id="unmark_apps2"><svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 2.9296875 2.2226562 L 2.2226562 2.9296875 L 9.2929688 10 L 2.2226562 17.070312 L 2.9296875 17.777344 L 10 10.707031 L 17.070312 17.777344 L 17.777344 17.070312 L 10.707031 10 L 17.777344 2.9296875 L 17.070312 2.2226562 L 10 9.2929688 L 2.9296875 2.2226562 z " style="fill:#FFF; fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Todos Ws 2
                                </button>
                                <hr>
                                <button class="btn btn-secondary" id="mark_apps3"><svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 18.837891 3.2832031 L 6.8183594 15.302734 L 1.1621094 9.6464844 L 0.453125 10.353516 L 6.8183594 16.716797 L 19.546875 3.9902344 L 18.837891 3.2832031 z " style="fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Todos Ws 3
                                </button>
                                <button class="btn btn-secondary" id="unmark_apps3"><svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 2.9296875 2.2226562 L 2.2226562 2.9296875 L 9.2929688 10 L 2.2226562 17.070312 L 2.9296875 17.777344 L 10 10.707031 L 17.070312 17.777344 L 17.777344 17.070312 L 10.707031 10 L 17.777344 2.9296875 L 17.070312 2.2226562 L 10 9.2929688 L 2.9296875 2.2226562 z " style="fill:#FFF; fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Todos Ws 3
                                </button>
                                <hr>
                                <button class="btn btn-secondary" id="mark_apps4"><svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 18.837891 3.2832031 L 6.8183594 15.302734 L 1.1621094 9.6464844 L 0.453125 10.353516 L 6.8183594 16.716797 L 19.546875 3.9902344 L 18.837891 3.2832031 z " style="fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Todos Ws 4
                                </button>
                                <button class="btn btn-secondary" id="unmark_apps4"><svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 2.9296875 2.2226562 L 2.2226562 2.9296875 L 9.2929688 10 L 2.2226562 17.070312 L 2.9296875 17.777344 L 10 10.707031 L 17.070312 17.777344 L 17.777344 17.070312 L 10.707031 10 L 17.777344 2.9296875 L 17.070312 2.2226562 L 10 9.2929688 L 2.9296875 2.2226562 z " style="fill:#FFF; fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Todos Ws 4
                                </button>
                                <hr>
                                <button class="btn btn-secondary" id="mark_apps5"><svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 18.837891 3.2832031 L 6.8183594 15.302734 L 1.1621094 9.6464844 L 0.453125 10.353516 L 6.8183594 16.716797 L 19.546875 3.9902344 L 18.837891 3.2832031 z " style="fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Todos Ws 5
                                </button>
                                <button class="btn btn-secondary" id="unmark_apps5"><svg width="25px" height="25px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><g  stroke-width="0"></g><g  stroke-linecap="round" stroke-linejoin="round"></g><g > <g > <path d="M 2.9296875 2.2226562 L 2.2226562 2.9296875 L 9.2929688 10 L 2.2226562 17.070312 L 2.9296875 17.777344 L 10 10.707031 L 17.070312 17.777344 L 17.777344 17.070312 L 10.707031 10 L 17.777344 2.9296875 L 17.070312 2.2226562 L 10 9.2929688 L 2.9296875 2.2226562 z " style="fill:#FFF; fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
                                    Todos Ws 5
                                </button>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Incluir</th>
                                            <th>Apps</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // Example data for 60 phones
                                    // Loop through each phone to create a row
                                    for ($i=0; $i < 60; $i++) { 
                                        echo "<tr>";

                                        echo "<td>Tel ".($i+1)."</td>";

                                        echo "<td><input type='checkbox' checked=true name='include_phone[]' value='{$i}' class='form-check-input tel-check'></td>";


                                        // Apps checkboxes
                                        echo "<td>";
                                        for ($j=0; $j < 5; $j++) {
                                            echo "<div class='form-check form-check-inline'>";
                                            echo "<input type='checkbox' name='apps_{$i}[]' checked=true value='{$j}' class='form-check-input ws-check ws-check".($j+1)."'>";
                                            echo "<label class='form-check-label'>Ws ".($j+1)."</label>";
                                            echo "</div>";
                                        }
                                        echo "</td>";

                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            </div>

                            <!-- Advance Tab Content -->
                            <div class="tab-pane fade" id="advance" role="tabpanel" aria-labelledby="advance-tab">
                                <h5 class="card-title">Avanzado</h5>
                                <p class="card-text">Propiedades avanzadas etc etc</p>
                                <!-- Add advanced options here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
  </div>
</main>
<script src="./src/js/script2.js" ></script>
<?php
    include('./includesphp/footer.php');
?>