<script>
    let xstats={
        "X.ID": {"sum":404.35,"mean":0.205671414038657,"sd":0.200227686851539},
        "X.RB": {"sum":257.57,"mean":0.131012207527976,"sd":0.335904904229614},
        "X.Ent": {"sum":471.35,"mean":0.239750762970499,"sd":0.125051394775491},
        "X.Lay.Air": {"sum":221.05,"mean":0.112436419125127,"sd":0.190584783150824},
        "X.HC.Dist": {"sum":1224.77,"mean":0.622975584944048,"sd":0.784762680396789},
        "X.Kum.Mean": {"sum":123.88,"mean":0.0630111902339778,"sd":0.105683703414177},
        "X.PKL.Count": {"sum":8081,"mean":4.11037639877925,"sd":7.21523156771902},
        "X.Pend.Count": {"sum":1950,"mean":0.991861648016277,"sd":1.95832791874536},
        "X.Perb.Count": {"sum":5197,"mean":2.64343845371312,"sd":4.75747973329888},
        "X.Rekr.Count": {"sum":1855,"mean":0.94354018311292,"sd":1.86772956293663},
        "X.Sos.Count": {"sum":3618,"mean":1.84028484231943,"sd":2.73492625096416},
        "X.Work.Count": {"sum":9810,"mean":4.98982706002035,"sd":8.2699307110149},
        "CX.Pop.Count": {"sum":1656564,"mean":842.606307222786,"sd":1062.90312586231}
    }
    ,map = new maplibregl.Map({
        container: 'map', // container id
        // style: 'https://demotiles.maplibre.org/style.json', // style URL
        center: [110.42925583629346,-7.000128974410487], // starting position [lng, lat]
        zoom: 12,// starting zoom,
        style: {
            'id': 'raster',
            'version': 8,
            'name': 'Raster tiles',
             "glyphs": "https://fonts.openmaptiles.org/{fontstack}/{range}.pbf",
            'sources': {
                'raster-tiles': {
                    'type': 'raster',
                    'tiles': ['https://tile.openstreetmap.org/{z}/{x}/{y}.png'],
                    'tileSize': 256,
                    'minzoom': 0,
                    'maxzoom': 19
                }
            },
            'layers': [
                {
                    'id': 'background',
                    'type': 'background',
                    'paint': {
                        'background-color': '#e0dfdf'
                    }
                },
                {
                    'id': 'simple-tiles',
                    'type': 'raster',
                    'source': 'raster-tiles'
                }
            ]
        },
    })
    // popup functions
    // 1. Hitung Persentase Kontribusi
    let calNilaiBatas=(batas,data,attr,kontribusi)=>{return (Math.log(batas)-data["beta_Intercept"])*(100*Math.abs(data[attr])/kontribusi)*(data[attr]/Math.abs(data[attr]))}
    $("#kontrol-layer-btn").on("click",()=>{
        $("#modal-layer-kontrol").modal({
            show: 'true'
        })
    })
    $("#toggle-administrasi").on("change",()=>{
        let nullSrc={
            "type": "FeatureCollection",
            "features": []}
        map.getSource('admin')._data.features.length>0? map.getSource('admin').setData(nullSrc):map.getSource('admin').setData(admin)       
    })
    $("#toggle-heksagon").on("change",()=>{
        let nullSrc={
            "type": "FeatureCollection",
            "features": []}
        if(map.getSource('heksagon')._data.features.length>0){
            map.getSource('heksagon').setData(nullSrc)
            $("#opacity-heksagon").prop("disabled", true)
        }else{
            map.getSource('heksagon').setData(heksagon)
            $("#opacity-heksagon").prop("disabled", false)
        }
    })
    $("#opacity-heksagon").on("change",()=>{
        map.setPaintProperty(
            'lyr-heksagon',
            'fill-opacity',
            parseFloat($("#opacity-heksagon").val())
            // parseInt(e.target.value, 10) / 100
        )
    })
    map.on("load",()=>{
        map.addSource('admin', {
                'type': 'geojson',
                'data': admin
            })
        map.addSource('heksagon', {
                'type': 'geojson',
                'data': heksagon
            })
        map.addLayer({
            'id':'lyr-heksagon',
            'type':'fill',
            'source':'heksagon',
            'layout': {},
            'paint': {
                'fill-color': [
                    'case',
                    ['==', ['get','kategori'], "Sangat Sehat"],'#0BE172',
                    ['==', ['get','kategori'], "Sehat"],'#5BB46A',
                    ['==', ['get','kategori'], "Kurang Sehat"],'#AA8762',
                    ['==', ['get','kategori'], "Tidak Sehat"],'#FA5A5A',
                    'white'
                ],
                'fill-opacity': 0.9
            }
        })
        map.addLayer({
            'id':'lyr-admin',
            'type':'line',
            'source':'admin',
            'layout': {},
            'paint': {
                "line-width":2
            }
        })
        map.addLayer({
            'id': 'lyr-admin-label',
            'type': 'symbol',
            'source': 'admin',
            'layout': {
                // 'text-field': ['get', 'kec'],
                'text-field': [
                    'format',
                    ['upcase', ['get', 'kec']],
                    {'font-scale': 0.8},
                ],
                'text-font': ['Open Sans Bold'],
                'text-variable-anchor': ['top', 'bottom', 'left', 'right'],
                'text-radial-offset': 0.5,
                'text-justify': 'auto',
                'icon-image': ['get', 'icon']
            }
        })
        map.on("click",(e)=>{
            let features = map.queryRenderedFeatures(e.point, { layers: ['lyr-heksagon'] });
            if (!features.length) {
                return;
            }
            let feature=features[0],
            dataurl="<?=base_url("data-gwr/")?>"+feature.properties["newID"]
            $.get({
                url: dataurl,
                success: (result)=>{
                    let res=JSON.parse(result)


                    $("#yhat-value").html(parseFloat(res.B["yhat"]).toFixed(0))
                    $("#yresidu-value").html(parseFloat(res.B["residual"]).toFixed(0))

                    $("#rb-input").val(parseFloat(res.F["X.RB"]).toFixed(2))
                    $("#rb-betha").html(parseFloat(res.B["b_X.RB"]).toFixed(3))
                    $("#rb-kontribusi").html((parseFloat(res.A["K.X.RB"])*100).toFixed(2)+" %")
                    $('#rb-sangat-sehat').html(parseFloat(res.C["in37.X.RB"]).toFixed(2))
                    $('#rb-sehat').html(parseFloat(res.D["in69.X.RB"]).toFixed(2))
                    $('#rb-kurang-sehat').html(parseFloat(res.E["in112.X.RB"]).toFixed(2))
                    $("#layair-input").val((parseFloat(res.F["X.Lay.Air"])*100).toFixed(2))
                    $("#layair-betha").html(parseFloat(res.B["b_X.Lay.Air"]).toFixed(3))
                    $("#layair-kontribusi").html((parseFloat(res.A["K.X.Lay.Air"])*100).toFixed(2)+" %")
                    $('#layair-sangat-sehat').html((parseFloat(res.C["in37.X.Lay.Air"])*100).toFixed(2))
                    $('#layair-sehat').html((parseFloat(res.D["in69.X.Lay.Air"])*100).toFixed(2))
                    $('#layair-kurang-sehat').html((parseFloat(res.E["in112.X.Lay.Air"])*100).toFixed(2))
                    $("#id-input").val(parseFloat(res.F["X.ID"]).toFixed(0))
                    $("#id-betha").html(parseFloat(res.B["b_X.ID"]).toFixed(3))
                    $("#id-kontribusi").html((parseFloat(res.A["K.X.ID"])*100).toFixed(2)+" %")
                    $('#id-sangat-sehat').html((parseFloat(res.C["in37.X.ID"])*153).toFixed(0))
                    $('#id-sehat').html((parseFloat(res.D["in69.X.ID"])*153).toFixed(0))
                    $('#id-kurang-sehat').html((parseFloat(res.E["in112.X.ID"])*153).toFixed(0))
                    $("#ent-input").val(parseFloat(res.F["X.Ent"]).toFixed(2))
                    $("#ent-betha").html(parseFloat(res.B["b_X.Ent"]).toFixed(3))
                    $("#ent-kontribusi").html((parseFloat(res.A["K.X.Ent"])*100).toFixed(2)+" %")
                    $('#ent-sangat-sehat').html(parseFloat(res.C["in37.X.Ent"]).toFixed(2))
                    $('#ent-sehat').html(parseFloat(res.D["in69.X.Ent"]).toFixed(2))
                    $('#ent-kurang-sehat').html(parseFloat(res.E["in112.X.Ent"]).toFixed(2))
                    $("#hcdist-input").val(parseFloat(res.F["X.HC.Dist"]).toFixed(2))
                    $("#hcdist-betha").html(parseFloat(res.B["b_X.HC.Dist"]).toFixed(3))
                    $("#hcdist-kontribusi").html((parseFloat(res.A["K.X.HC.Dist"])*100).toFixed(2)+" %")
                    $('#hcdist-sangat-sehat').html(parseFloat(res.C["in37.X.HC.Dist"]).toFixed(2))
                    $('#hcdist-sehat').html(parseFloat(res.D["in69.X.HC.Dist"]).toFixed(2))
                    $('#hcdist-kurang-sehat').html(parseFloat(res.E["in112.X.HC.Dist"]).toFixed(2))
                    $("#kummean-input").val(parseFloat(res.F["X.Kum.Mean"]).toFixed(2))
                    $("#kummean-betha").html(parseFloat(res.B["b_X.Kum.Mean"]).toFixed(3))
                    $("#kummean-kontribusi").html((parseFloat(res.A["K.X.Kum.Mean"])*100).toFixed(2)+" %")
                    $('#kummean-sangat-sehat').html(parseFloat(res.C["in37.X.Kum.Mean"]).toFixed(2))
                    $('#kummean-sehat').html(parseFloat(res.D["in69.X.Kum.Mean"]).toFixed(2))
                    $('#kummean-kurang-sehat').html(parseFloat(res.E["in112.X.Kum.Mean"]).toFixed(2))
                    $("#pklcount-input").val(parseFloat(res.F["X.PKL.Count"]).toFixed(0))
                    $("#pklcount-betha").html(parseFloat(res.B["b_X.PKL.Count"]).toFixed(3))
                    $("#pklcount-kontribusi").html((parseFloat(res.A["K.X.PKL.Count"])*100).toFixed(2)+" %")
                    $('#pklcount-sangat-sehat').html(parseFloat(res.C["in37.X.PKL.Count"]).toFixed(0))
                    $('#pklcount-sehat').html(parseFloat(res.D["in69.X.PKL.Count"]).toFixed(0))
                    $('#pklcount-kurang-sehat').html(parseFloat(res.E["in112.X.PKL.Count"]).toFixed(0))
                    $("#pendcount-input").val(parseFloat(res.F["X.Pend.Count"]).toFixed(0))
                    $("#pendcount-betha").html(parseFloat(res.B["b_X.Pend.Count"]).toFixed(3))
                    $("#pendcount-kontribusi").html((parseFloat(res.A["K.X.Pend.Count"])*100).toFixed(2)+" %")
                    $('#pendcount-sangat-sehat').html(parseFloat(res.C["in37.X.Pend.Count"]).toFixed(0))
                    $('#pendcount-sehat').html(parseFloat(res.D["in69.X.Pend.Count"]).toFixed(0))
                    $('#pendcount-kurang-sehat').html(parseFloat(res.E["in112.X.Pend.Count"]).toFixed(0))
                    $("#soscount-input").val(parseFloat(res.F["X.Sos.Count"]).toFixed(0))
                    $("#soscount-betha").html(parseFloat(res.B["b_X.Sos.Count"]).toFixed(3))
                    $("#soscount-kontribusi").html((parseFloat(res.A["K.X.Sos.Count"])*100).toFixed(2)+" %")
                    $('#soscount-sangat-sehat').html(parseFloat(res.C["in37.X.Sos.Count"]).toFixed(0))
                    $('#soscount-sehat').html(parseFloat(res.D["in69.X.Sos.Count"]).toFixed(0))
                    $('#soscount-kurang-sehat').html(parseFloat(res.E["in112.X.Sos.Count"]).toFixed(0))
                    $("#rekrcount-input").val(parseFloat(res.F["X.Rekr.Count"]).toFixed(0))
                    $("#rekrcount-betha").html(parseFloat(res.B["b_X.Rekr.Count"]).toFixed(3))
                    $("#rekrcount-kontribusi").html((parseFloat(res.A["K.X.Rekr.Count"])*100).toFixed(2)+" %")
                    $('#rekrcount-sangat-sehat').html(parseFloat(res.C["in37.X.Rekr.Count"]).toFixed(0))
                    $('#rekrcount-sehat').html(parseFloat(res.D["in69.X.Rekr.Count"]).toFixed(0))
                    $('#rekrcount-kurang-sehat').html(parseFloat(res.E["in112.X.Rekr.Count"]).toFixed(0))
                    $("#workcount-input").val(parseFloat(res.F["X.Work.Count"]).toFixed(0))
                    $("#workcount-betha").html(parseFloat(res.B["b_X.Work.Count"]).toFixed(3))
                    $("#workcount-kontribusi").html((parseFloat(res.A["K.X.Work.Count"])*100).toFixed(2)+" %")
                    $('#workcount-sangat-sehat').html(parseFloat(res.C["in37.X.Work.Count"]).toFixed(0))
                    $('#workcount-sehat').html(parseFloat(res.D["in69.X.Work.Count"]).toFixed(0))
                    $('#workcount-kurang-sehat').html(parseFloat(res.E["in112.X.Work.Count"]).toFixed(0))
                    $("#perbcount-input").val(parseFloat(res.F["X.Perb.Count"]).toFixed(0))
                    $("#perbcount-betha").html(parseFloat(res.B["b_X.Perb.Count"]).toFixed(3))
                    $("#perbcount-kontribusi").html((parseFloat(res.A["K.X.Perb.Count"])*100).toFixed(2)+" %")
                    $('#perbcount-sangat-sehat').html(parseFloat(res.C["in37.X.Perb.Count"]).toFixed(0))
                    $('#perbcount-sehat').html(parseFloat(res.D["in69.X.Perb.Count"]).toFixed(0))
                    $('#perbcount-kurang-sehat').html(parseFloat(res.E["in112.X.Perb.Count"]).toFixed(0))

                    $("#penduduk-input").html(parseFloat(res.F["CX.Pop.Count"]).toFixed(0))
                    $("#penduduk-betha").html(parseFloat(res.B["b_CX.Pop.Count"]).toFixed(3))

                    let rumus="ln(y"+checkMinus($('#yresidu-value').html())+")= "+parseFloat(res.B["b_intercept"]).toFixed(3)+checkMinus($("#rb-betha").html())+
                        " X<sub>RB</sub>"+checkMinus($("#layair-betha").html())+" X<sub>Lay.Air</sub>"+
                        checkMinus($("#id-betha").html())+" X<sub>ID</sub>"+
                        checkMinus($("#ent-betha").html())+" X<sub>Ent</sub>"+
                        checkMinus($("#hcdist-betha").html())+" X<sub>HC.Dist</sub>"+
                        checkMinus($("#kummean-betha").html())+" X<sub>HC.Kum.Mean</sub>"+
                        checkMinus($("#pklcount-betha").html())+" X<sub>HC.PKL.Count</sub>"+
                        checkMinus($("#pendcount-betha").html())+" X<sub>HC.Pend.Count</sub>"+
                        checkMinus($("#soscount-betha").html())+" X<sub>HC.Sos.Count</sub>"+
                        checkMinus($("#rekcount-betha").html())+" X<sub>HC.Rek.Count</sub>"+
                        checkMinus($("#workcount-betha").html())+" X<sub>HC.Work.Count</sub>"+
                        checkMinus($("#perbcount-betha").html())+" X<sub>HC.Perb.Count</sub>"+
                        checkMinus($("#penduduk-betha").html())+" CX<sub>Pop.Count</sub>"
                        $("#rumus-gwr").html(rumus)
                        // masukkan diagram pie
                        let xalam=(parseFloat(res.A["K.X.RB"])*100).toFixed(2)+(parseFloat(res.A["K.X.Lay.Air"])*100).toFixed(2),
                        xterbangun=(parseFloat(res.A["K.X.Kum.Mean"])*100).toFixed(2)+(parseFloat(res.A["K.X.Ent"])*100).toFixed(2)+(parseFloat(res.A["K.X.ID"])*100).toFixed(2)+(parseFloat(res.A["K.X.HC.Dist"])*100).toFixed(2),
                        xaktivitas=(parseFloat(res.A["K.X.PKL.Count"])*100).toFixed(2)+(parseFloat(res.A["K.X.Pend.Count"])*100).toFixed(2)+(parseFloat(res.A["K.X.Perb.Count"])*100).toFixed(2)+(parseFloat(res.A["K.X.Sos.Count"])*100).toFixed(2)+(parseFloat(res.A["K.X.Work.Count"])*100).toFixed(2)+(parseFloat(res.A["K.X.Rekr.Count"])*100).toFixed(2)
                        var options = {
                            chart: {
                                type: 'pie'
                            },
                            series: [parseFloat(xalam),parseFloat(xterbangun),parseFloat(xaktivitas)],
                            labels: ['Ling. Alam', 'Ling. Terbangun', 'Aktivitas'],
                            dataLabels: {
                                enabled: true,
                                formatter: function (val) {
                                    return val.toFixed(2) + "%"
                                }
                            },
                            tooltip:{enabled:false}
                            // legend:{position:"bottom"}
                        },
                        chart = new ApexCharts(document.querySelector("#pie-kontribusi"), options);
                        chart.render();
                    
                }
            })
            $("#scorecardlLabel").html("Nilai Lingkungan Binaan Sel No. "+feature['properties']['newID'])
            $("#y-value").html(feature['properties']['sumSakit'])
            $("#kategori-value").html(feature['properties']['kategori'].toUpperCase())
            let checkMinus=(val)=>{
                if(val<0) return val
                else return "+ "+val
            }
            let colors={bg:"",cl:""}
            switch(feature['properties']['kategori'].toUpperCase()) {
                case 'SANGAT SEHAT':
                    colors={bg:"#0BE172",cl:"white"}
                    break;
                case 'SEHAT':
                    colors={bg:"#5BB46A",cl:"white"}
                    break;
                case 'KURANG SEHAT':
                    colors={bg:"#AA8762",cl:"white"}
                    break;
                case 'TIDAK SEHAT':
                    colors={bg:"#FA5A5A",cl:"white"}
                    break;
                default:
                    colors={bg:"white",cl:"grey"}
                    break;
            }
            $("#kategori-value").css("background-color",colors.bg)
            $("#kategori-value").css("color",colors.cl)
            $("#scorecard").modal('show')
            // // set variabel x 
            
        })
        map.on('mousemove', (e)=>{
            let features = map.queryRenderedFeatures(e.point, { layers: ['lyr-heksagon'] });
            map.getCanvas().style.cursor = (features.length) ? 'pointer' : '';
        })
    })
</script>