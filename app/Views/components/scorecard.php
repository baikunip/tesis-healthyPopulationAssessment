<div class="modal fade modal-xl" id="scorecard" data-bs-backdrop="static" tabindex="-1" aria-labelledby="scorecardLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="scorecardlLabel">Penialain Sel No.</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Model Lokal</h4>
                    <table class="table">
                        <tbody>
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
                            <tr>
                                <th>Rumus Model Lokal</th>
                                <td id="rumus-model"></td>
                            </tr>
                        </tbody>
                    </table>
                    <hr class="mb-4">
                    <h4>Indikator Lingkungan Binaan</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Variabel</th>
                            <th scope="col">Proporsi Kontribusi (%)</th>
                            <th scope="col">Sangat Sehat</th>
                            <th scope="col">Sehat</th>
                            <th scope="col">Kurang Sehat</th>
                            <th scope="col">Tidak Sehat</th>
                            <th scope="col">Nilai</th>
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
                                <td id="rb-sangat-sehat">
                                    11.56
                                </td>
                                <td id="rb-sehat">
                                    11.56
                                </td>
                                <td id="rb-kurang-sehat">
                                    11.56
                                </td>
                                <td id="rb-tidak-sehat">
                                    11.56
                                </td>
                                <td>
                                    <input type="range" class="form-range pa-0" min="0" max="1" step="0.01" id="rb-input">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    2. Distribusi Layanan Air Bersih
                                </th>
                                <td id="layair-betha">
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
                                <td id="layair-tidak-sehat">
                                    11.56
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Jumlah Penduduk Terlayani" aria-label="Jumlah Penduduk Terlayani"  name="layair-input" aria-describedby="layair-label">
                                        <span class="input-group-text" id="layair-label">30</span>
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
                                <td id="id-sangat-sehat">
                                    11.56
                                </td>
                                <td id="id-sehat">
                                    11.56
                                </td>
                                <td id="id-kurang-sehat">
                                    11.56
                                </td>
                                <td id="id-tidak-sehat">
                                    11.56
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Jumlah Simpangan" aria-label="Jumlah Simpangan" aria-describedby="id-label">
                                        <span class="input-group-text" id="id-label">30</span>
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
                                <td id="ent-sangat-sehat">
                                    11.56
                                </td>
                                <td id="ent-sehat">
                                    11.56
                                </td>
                                <td id="ent-kurang-sehat">
                                    11.56
                                </td>
                                <td id="ent-tidak-sehat">
                                    11.56
                                </td>
                                <td>
                                    <input type="range" class="form-range pa-0" min="0" max="1" step="0.01" id="ent-input" list="ent-list">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    5. Jarak dengan Fasilitas Kesehatan
                                </th>
                                <td id="hcdist-betha">
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
                                <td id="hcdist-tidak-sehat">
                                    11.56
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Jarak Terdekat (Km)" aria-label="Jarak Terdekat (Km)"  name="hcdist-input" aria-describedby="hcdist-label">
                                        <span class="input-group-text" id="hcdist-label">30 KM</span>
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
                                <td id="kummean-sangat-sehat">
                                    11.56
                                </td>
                                <td id="kummean-sehat">
                                    11.56
                                </td>
                                <td id="kummean-kurang-sehat">
                                    11.56
                                </td>
                                <td id="kummean-tidak-sehat">
                                    11.56
                                </td>
                                <td>
                                <input type="range" class="form-range pa-0" min="0" max="100" step="0.01" id="kummean-input">
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
                                <td id="pklcount-sangat-sehat">
                                    11.56
                                </td>
                                <td id="pklcount-sehat">
                                    11.56
                                </td>
                                <td id="pklcount-kurang-sehat">
                                    11.56
                                </td>
                                <td id="pklcount-tidak-sehat">
                                    11.56
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Jumlah PKL" aria-label="Jumlah PKL"  name="pklcount-input" aria-describedby="pklcount-label">
                                        <span class="input-group-text" id="pendcount-label">30</span>
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
                                <td id="pendcount-sangat-sehat">
                                    11.56
                                </td>
                                <td id="pendcount-sehat">
                                    11.56
                                </td>
                                <td id="pendcount-kurang-sehat">
                                    11.56
                                </td>
                                <td id="pendcount-tidak-sehat">
                                    11.56
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Jumlah Aktivitas Pendidikan" aria-label="Jumlah Aktivitas Pendidikan"  name="pendcount-input" aria-describedby="pendcount-label">
                                        <span class="input-group-text" id="pendcount-label">30</span>
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
                                <td id="perbcount-sangat-sehat">
                                    11.56
                                </td>
                                <td id="perbcount-sehat">
                                    11.56
                                </td>
                                <td id="perbcount-kurang-sehat">
                                    11.56
                                </td>
                                <td id="perbcount-tidak-sehat">
                                    11.56
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Jumlah Aktivitas Perbelanjaan" aria-label="Jumlah Aktivitas Perbelanjaan"  name="perbcount-input" aria-describedby="perbcount-label">
                                        <span class="input-group-text" id="perbcount-label">30</span>
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
                                <td id="rekrcount-sangat-sehat">
                                    11.56
                                </td>
                                <td id="rekrcount-sehat">
                                    11.56
                                </td>
                                <td id="rekrcount-kurang-sehat">
                                    11.56
                                </td>
                                <td id="rekrcount-tidak-sehat">
                                    11.56
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Jumlah Aktivitas Rekreasi" aria-label="Jumlah Aktivitas Rekreasi"  name="rekrcount-input" aria-describedby="rekrcount-label">
                                        <span class="input-group-text" id="rekrcount-label">30</span>
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
                                <td id="soscount-sangat-sehat">
                                    11.56
                                </td>
                                <td id="soscount-sehat">
                                    11.56
                                </td>
                                <td id="soscount-kurang-sehat">
                                    11.56
                                </td>
                                <td id="soscount-tidak-sehat">
                                    11.56
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Jumlah Aktivitas Sosial" aria-label="Jumlah Aktivitas Sosial"  name="soscount-input" aria-describedby="soscount-label">
                                        <span class="input-group-text" id="soscount-label">30</span>
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
                                <td id="workcount-sangat-sehat">
                                    11.56
                                </td>
                                <td id="workcount-sehat">
                                    11.56
                                </td>
                                <td id="workcount-kurang-sehat">
                                    11.56
                                </td>
                                <td id="workcount-tidak-sehat">
                                    11.56
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Jumlah Aktivitas Bekerja" aria-label="Jumlah Aktivitas Bekerja"  name="workcount-input" aria-describedby="workcount-label">
                                        <span class="input-group-text" id="workcount-label">30</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>