<div class="modal fade modal-xl" id="scorecard" data-bs-backdrop="static" tabindex="-1" aria-labelledby="scorecardLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="scorecardlLabel">Penialain Sel No.</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Kesehatan Area</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Kategori</th>
                                        <th><h2><span id="kategori-value" class="badge">Secondary</span></h2></th>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Penyakit Menular</th>
                                        <td id="y-value">100</td>
                                    </tr>
                                    <tr>
                                        <th>Estimasi Jumlah Penyakit Menular</th>
                                        <td id="yhat-value">100</td>
                                    </tr>
                                    <tr>
                                        <th>Residu Jumlah Penyakit Menular</th>
                                        <td id="yresidu-value">100</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div id="pie-kontribusi" style="width:80%;"></div>
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="col-12">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Rumus Model Lokal</th>
                                        <td id="rumus-gwr" class="cormorant-upright-medium pa-2">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <h4>Indikator Lingkungan Binaan</h4>
                    <div id="x-table">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col" rowspan=2>Variabel</th>
                                <th scope="col" rowspan=2>Estimator</th>
                                <th scope="col" rowspan=2>Proporsi Kontribusi</th>
                                <th scope="col" colspan=3 class="text-center">Interval Kasus Penyakit Menular</th>
                                <th scope="col" rowspan=2>Nilai</th>
                            </tr>
                            <tr>
                                <th scope="col">37</th>
                                <th scope="col">69</th>
                                <th scope="col">112</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr><th colspan="7">
                                    <h5>A. Lingkungan Alam</h5>
                                </th></tr>
                                <tr>
                                    <th>
                                        1. Risiko Banjir
                                    </th>
                                    <td id="rb-betha">
                                        20
                                    </td>
                                    <td id="rb-kontribusi">
                                        20
                                    </td>
                                    <td id="rb-sangat-sehat">
                                        11.56
                                    </td>
                                    <td id="rb-sehat">
                                        11.56
                                    </td>
                                    <td id="rb-kurang-sehat">
                                        11.56
                                    </td>
                                    <td>
                                        <!-- <input type="range" class="form-range pa-0" min="0" max="1" step="0.01" id="rb-input"> -->
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" step=".01" min=0 max=1 id="rb-input" aria-describedby="rb-label">
                                            <span class="input-group-text" id="rb-label">Indeks Risiko Banjir</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        2. Distribusi Layanan Air Bersih
                                    </th>
                                    <td id="layair-betha">
                                        20
                                    </td>
                                    <td id="layair-kontribusi">
                                        20
                                    </td>
                                    <td id="layair-sangat-sehat">
                                        11.56
                                    </td>
                                    <td id="layair-sehat">
                                        11.56
                                    </td>
                                    <td id="layair-kurang-sehat">
                                        11.56
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" placeholder="Jumlah Penduduk Terlayani" min="0" step=".01" aria-label="Jumlah Penduduk Terlayani" id="layair-input" name="layair-input" aria-describedby="layair-label">
                                            <span class="input-group-text" id="layair-label">%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr><th colspan="7">
                                    <h5>B. Lingkungan Terbangun</h5>
                                </th></tr>
                                <tr>
                                    <th>
                                        3. Intensitas Simpangan Jalan
                                    </th>
                                    <td id="id-betha">
                                        20
                                    </td>
                                    <td id="id-kontribusi">
                                        20
                                    </td>
                                    <td id="id-sangat-sehat">
                                        11.56
                                    </td>
                                    <td id="id-sehat">
                                        11.56
                                    </td>
                                    <td id="id-kurang-sehat">
                                        11.56
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" placeholder="Jumlah Simpangan" step=".01" min=0 aria-label="Jumlah Simpangan" id="id-input" aria-describedby="id-label">
                                            <span class="input-group-text" id="id-label">Simpangan</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        4. Indeks Entropy
                                    </th>
                                    <td id="ent-betha">
                                        11.56
                                    </td>
                                    <td id="ent-kontribusi">
                                        11.56
                                    </td>
                                    <td id="ent-sangat-sehat">
                                        11.56
                                    </td>
                                    <td id="ent-sehat">
                                        11.56
                                    </td>
                                    <td id="ent-kurang-sehat">
                                        11.56
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" step=".01" min=0 max=1 id="ent-input" aria-describedby="ent-label">
                                            <span class="input-group-text" id="ent-label">Entropy</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        5. Jarak dengan Fasilitas Kesehatan
                                    </th>
                                    <td id="hcdist-betha">
                                        20
                                    </td>
                                    <td id="hcdist-kontribusi">
                                        20
                                    </td>
                                    <td id="hcdist-sangat-sehat">
                                        11.56
                                    </td>
                                    <td id="hcdist-sehat">
                                        11.56
                                    </td>
                                    <td id="hcdist-kurang-sehat">
                                        11.56
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" placeholder="Jarak Terdekat (Km)" aria-label="Jarak Terdekat (Km)" step=.01 min=0  id="hcdist-input" aria-describedby="hcdist-label">
                                            <span class="input-group-text" id="hcdist-label">KM</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        6. Rata-rata Skor Kumuh
                                    </th>
                                    <td id="kummean-betha">
                                        20
                                    </td>
                                    <td id="kummean-kontribusi">
                                        20
                                    </td>
                                    <td id="kummean-sangat-sehat">
                                        11.56
                                    </td>
                                    <td id="kummean-sehat">
                                        11.56
                                    </td>
                                    <td id="kummean-kurang-sehat">
                                        11.56
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" step=.01 min=0  id="kummean-input" aria-describedby="kummean-label">
                                            <span class="input-group-text" id="kummean-label">Skor/100</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr><th colspan="7">
                                    <h5>C. Aktivitas</h5>
                                </th></tr>
                                <tr>
                                    <th>
                                        7. Jumlah Aktivitas PKL
                                    </th>
                                    <td id="pklcount-betha">
                                        20
                                    </td>
                                    <td id="pklcount-kontribusi">
                                        20
                                    </td>
                                    <td id="pklcount-sangat-sehat">
                                        11.56
                                    </td>
                                    <td id="pklcount-sehat">
                                        11.56
                                    </td>
                                    <td id="pklcount-kurang-sehat">
                                        11.56
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" min=0  id="pklcount-input" aria-describedby="pklcount-label">
                                            <span class="input-group-text" id="pklcount-label">Titik</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        8. Jumlah Aktivitas Pendidikan
                                    </th>
                                    <td id="pendcount-betha">
                                        20
                                    </td>
                                    <td id="pendcount-kontribusi">
                                        20
                                    </td>
                                    <td id="pendcount-sangat-sehat">
                                        11.56
                                    </td>
                                    <td id="pendcount-sehat">
                                        11.56
                                    </td>
                                    <td id="pendcount-kurang-sehat">
                                        11.56
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" min=0  id="pendcount-input" aria-describedby="pendcount-label">
                                            <span class="input-group-text" id="pendcount-label">Titik</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        9. Jumlah Aktivitas Perbelanjaan
                                    </th>
                                    <td id="perbcount-betha">
                                        20
                                    </td>
                                    <td id="perbcount-kontribusi">
                                        20
                                    </td>
                                    <td id="perbcount-sangat-sehat">
                                        11.56
                                    </td>
                                    <td id="perbcount-sehat">
                                        11.56
                                    </td>
                                    <td id="perbcount-kurang-sehat">
                                        11.56
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" min=0  id="perbcount-input" aria-describedby="perbcount-label">
                                            <span class="input-group-text" id="perbcount-label">Titik</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        10. Jumlah Aktivitas Rekreasi
                                    </th>
                                    <td id="rekrcount-betha">
                                        20
                                    </td>
                                    <td id="rekrcount-kontribusi">
                                        20
                                    </td>
                                    <td id="rekrcount-sangat-sehat">
                                        11.56
                                    </td>
                                    <td id="rekrcount-sehat">
                                        11.56
                                    </td>
                                    <td id="rekrcount-kurang-sehat">
                                        11.56
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" min=0  id="rekrcount-input" aria-describedby="rekrcount-label">
                                            <span class="input-group-text" id="rekrcount-label">Titik</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        11. Jumlah Aktivitas Sosial
                                    </th>
                                    <td id="soscount-betha">
                                        20
                                    </td>
                                    <td id="soscount-kontribusi">
                                        20
                                    </td>
                                    <td id="soscount-sangat-sehat">
                                        11.56
                                    </td>
                                    <td id="soscount-sehat">
                                        11.56
                                    </td>
                                    <td id="soscount-kurang-sehat">
                                        11.56
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" min=0  id="soscount-input" aria-describedby="soscount-label">
                                            <span class="input-group-text" id="soscount-label">Titik</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        12. Jumlah Aktivitas Bekerja
                                    </th>
                                    <td id="workcount-betha">
                                        20
                                    </td>
                                    <td id="workcount-kontribusi">
                                        20
                                    </td>
                                    <td id="workcount-sangat-sehat">
                                        11.56
                                    </td>
                                    <td id="workcount-sehat">
                                        11.56
                                    </td>
                                    <td id="workcount-kurang-sehat">
                                        11.56
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" min=0  id="workcount-input" aria-describedby="workcount-label">
                                            <span class="input-group-text" id="workcount-label">Titik</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> 
                    <hr class="mb-4">
                    <h4>Variabel Kontrol</h4>
                    <table class="table table-borderless">
                        <thead>
                            <th></th>
                            <th>Estimator</th>
                            <th scope="col">Proporsi Kontribusi</th>
                            <th>Jumlah</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Jumlah Penduduk</th>
                                <td id="penduduk-betha"></td>
                                <td id="penduduk-kontribusi"></td>
                                <td id="penduduk-input"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>