<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Kota Sehat | Semarang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Upright:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/maplibre-gl/dist/maplibre-gl.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <?php echo view("components/mapstyle");?>
</head>
<body>
<?php echo view("components/navbar");?>
    <!-- Kontrol Modal -->
    <div class="modal fade" id="modal-layer-kontrol" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Kontrol Layer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row container align-middle">
                        <div class="col-12 form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked name="toggle-administrasi" id="toggle-administrasi">
                            <label class="form-check-label" for="toggle-administrasi"><h5>Administrasi</h5></label>
                        </div>
                        <div class="col-4">Legenda</div>
                        <div class="col-8">
                            <table class="table align-middle">
                                <tbody>
                                    <tr>
                                        <td><div class="line-admin"></div></td>
                                        <td>Batas Administrasi</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="col-12 form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked id="toggle-heksagon">
                            <label class="form-check-label" for="flexSwitchCheckDefault"><h5>Sel Populasi</h5></label>
                        </div>
                        <div class="col-4 ">Transparansi</div>
                        <div class="col-8">
                            <table class="table align-middle">
                                <tbody>
                                    <tr>
                                        <td>0</td>
                                        <td><input type="range" class="form-range pa-0" min="0" max="1" value="0.9" step="0.1" id="opacity-heksagon"></td>
                                        <td>1</td>
                                    </tr>
                                </tbody>
                            </table> 
                        </div>
                        <div class="col-4">Legenda</div>
                        <div class="col-8">
                            <table class="table align-middle">
                                <tbody>
                                    <tr>
                                        <td><div class="heks-legenda" style="background-color:#0BE172"></div></td>
                                        <td>Sangat Sehat</td>
                                    </tr>
                                    <tr>
                                        <td><div class="heks-legenda" style="background-color:#5BB46A"></div></td>
                                        <td>Sehat</td>
                                    </tr>
                                    <tr>
                                        <td><div class="heks-legenda" style="background-color:#AA8762"></div></td>
                                        <td>Kurang Sehat</td>
                                    </tr>
                                    <tr>
                                        <td><div class="heks-legenda" style="background-color:#FA5A5A"></div></td>
                                        <td>Tidak Sehat</td>
                                    </tr>
                                    <tr>
                                        <td><div class="heks-legenda" style="background-color:white"></div></td>
                                        <td>Tidak Terkategori</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    <!-- Scorecard Modal -->
    <?php echo view("components/scorecard");?>
    
    <div id="map"></div>
    <script src="https://unpkg.com/maplibre-gl/dist/maplibre-gl.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <?php echo view("components/data/administrasi");?>
    <?php echo view("components/data/heksagon");?>
    <?php echo view("components/data/datastd");?>
    <?php echo view("components/data/datagwr");?>
    <?php echo view("components/mapjs");?>
</body>
</html>