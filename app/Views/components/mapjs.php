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
    let calKontribusi=(attr)=>{(100*Math.abs(attrgwr[attr])/totalKontribusi).toFixed(2)},
    calNilaiBatas=(batas,data,attr,kontribusi)=>{return (Math.log(batas)-data["beta_Intercept"])*(100*Math.abs(data[attr])/kontribusi)*(data[attr]/Math.abs(data[attr]))}
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
            attrstd=datastd[feature.properties["newID"]],
            attrgwr=datagwr[feature.properties["newID"]],
            totalKontribusi=0
            for (const [key, value] of Object.entries(attrgwr)) {
                if(key.includes("beta_")&& key!="beta_Intercept")totalKontribusi+=Math.abs(value)
            }
            console.log("total kontribusi: "+totalKontribusi)
            $("#scorecardlLabel").html("Nilai Lingkungan Binaan Sel No. "+feature['properties']['newID'])
            $("#y-value").html(feature['properties']['sumSakit'])
            $("#yhat-value").html(attrgwr['gwr_yhat'].toFixed(0))
            $("#yresidu-value").html(attrgwr['gwr_residual'].toFixed(0))
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
            console.log(Math.log(37))
            $("#scorecard").modal('show')
            // set variabel x 
            $("#rb-input").val(Math.abs(parseFloat(((attrstd["X.RB"]*xstats["X.RB"]["sd"])+xstats["X.RB"]["mean"])).toFixed(2)))
            $("#rb-betha").html(attrgwr["beta_X.RB"].toFixed(3))
            $("#rb-kontribusi").html((100*Math.abs(attrgwr["beta_X.RB"])/totalKontribusi).toFixed(2)+" %")
            $('#rb-sangat-sehat').html(Math.min((Math.abs(calNilaiBatas(37,attrgwr,"beta_X.RB",totalKontribusi)*xstats["X.RB"]["sd"]+xstats["X.RB"]["mean"])).toFixed(2),1))
            $('#rb-sehat').html(Math.min((Math.abs(calNilaiBatas(69,attrgwr,"beta_X.RB",totalKontribusi)*xstats["X.RB"]["sd"]+xstats["X.RB"]["mean"])).toFixed(2),1))
            $('#rb-kurang-sehat').html(Math.min((Math.abs(calNilaiBatas(112,attrgwr,"beta_X.RB",totalKontribusi)*xstats["X.RB"]["sd"]+xstats["X.RB"]["mean"])).toFixed(2),1))
            // $('#rb-tidak-sehat').html((Math.log(37))*$('#rb-kontribusi').val()*(attrgwr["beta_X.RB"]/Math.abs(attrgwr["beta_X.RB"])))
            $("#layair-input").val(Math.abs(parseFloat(100*((attrstd["X.Lay.Air"]*xstats["X.Lay.Air"]["sd"])+xstats["X.Lay.Air"]["mean"])).toFixed(2)))
            $("#layair-betha").html(attrgwr["beta_X.Lay.Air"].toFixed(3))
            $("#layair-kontribusi").html((100*Math.abs(attrgwr["beta_X.Lay.Air"])/totalKontribusi).toFixed(2)+" %")
            $('#layair-sangat-sehat').html(100*(Math.log(37))*$('#layair-kontribusi').val()*(attrgwr["beta_X.Lay.Air"]/Math.abs(attrgwr["beta_X.Lay.Air"])).toFixed(2))
            $('#layair-sehat').html(100*(Math.log(69))*$('#layair-kontribusi').val()*(attrgwr["beta_X.Lay.Air"]/Math.abs(attrgwr["beta_X.Lay.Air"])).toFixed(2))
            $('#layair-kurang-sehat').html(100*(Math.log(112))*$('#layair-kontribusi').val()*(attrgwr["beta_X.Lay.Air"]/Math.abs(attrgwr["beta_X.Lay.Air"])).toFixed(2))
            $("#id-input").val(Math.abs(156*parseFloat((attrstd["X.ID"]*xstats["X.ID"]["sd"])+xstats["X.ID"]["mean"])).toFixed(0))
            $("#id-betha").html(attrgwr["beta_X.ID"].toFixed(3))
            $("#id-kontribusi").html((100*Math.abs(attrgwr["beta_X.ID"])/totalKontribusi).toFixed(2)+" %")
            $('#id-sangat-sehat').html((Math.log(37))*$('#id-kontribusi').val()*(attrgwr["beta_X.ID"]/Math.abs(attrgwr["beta_X.ID"])).toFixed(2))
            $('#id-sehat').html((Math.log(69))*$('#id-kontribusi').val()*(attrgwr["beta_X.ID"]/Math.abs(attrgwr["beta_X.ID"])).toFixed(2))
            $('#id-kurang-sehat').html((Math.log(112))*$('#id-kontribusi').val()*(attrgwr["beta_X.ID"]/Math.abs(attrgwr["beta_X.ID"])).toFixed(2))
            $("#ent-input").val(Math.abs(parseFloat(((attrstd["X.Ent"]*xstats["X.Ent"]["sd"])+xstats["X.Ent"]["mean"])).toFixed(2)))
            $("#ent-betha").html(attrgwr["beta_X.Ent"].toFixed(3))
            $("#ent-kontribusi").html((100*Math.abs(attrgwr["beta_X.Ent"])/totalKontribusi).toFixed(2)+" %")
            $('#ent-sangat-sehat').html((Math.log(37))*$('#ent-kontribusi').val()*(attrgwr["beta_X.Ent"]/Math.abs(attrgwr["beta_X.Ent"])).toFixed(2))
            $('#ent-sehat').html((Math.log(69))*$('#ent-kontribusi').val()*(attrgwr["beta_X.Ent"]/Math.abs(attrgwr["beta_X.Ent"])).toFixed(2))
            $('#ent-kurang-sehat').html((Math.log(112))*$('#ent-kontribusi').val()*(attrgwr["beta_X.Ent"]/Math.abs(attrgwr["beta_X.Ent"])).toFixed(2))
            $("#hcdist-input").val(Math.abs(parseFloat(((attrstd["X.HC.Dist"]*xstats["X.HC.Dist"]["sd"])+xstats["X.HC.Dist"]["mean"])).toFixed(2)))
            $("#hcdist-betha").html(attrgwr["beta_X.HC.Dist"].toFixed(3))
            $("#hcdist-kontribusi").html((100*Math.abs(attrgwr["beta_X.HC.Dist"])/totalKontribusi).toFixed(2)+" %")
            $('#hcdist-sangat-sehat').html((Math.log(37))*$('#hcdist-kontribusi').val()*(attrgwr["beta_X.HC.Dist"]/Math.abs(attrgwr["beta_X.HC.Dist"])).toFixed(2))
            $('#hcdist-sehat').html((Math.log(69))*$('#hcdist-kontribusi').val()*(attrgwr["beta_X.HC.Dist"]/Math.abs(attrgwr["beta_X.HC.Dist"])).toFixed(2))
            $('#hcdist-kurang-sehat').html((Math.log(112))*$('#hcdist-kontribusi').val()*(attrgwr["beta_X.HC.Dist"]/Math.abs(attrgwr["beta_X.HC.Dist"])).toFixed(2))
            $("#kummean-input").val(Math.abs(parseFloat(((attrstd["X.Kum.Mean"]*xstats["X.Kum.Mean"]["sd"])+xstats["X.Kum.Mean"]["mean"])).toFixed(2)))
            $("#kummean-betha").html(attrgwr["beta_X.Kum.Mean"].toFixed(3))
            $("#kummean-kontribusi").html((100*Math.abs(attrgwr["beta_X.Kum.Mean"])/totalKontribusi).toFixed(2)+" %")
            $('#kummean-sangat-sehat').html((Math.log(37))*$('#kummean-kontribusi').val()*(attrgwr["beta_X.Kum.Mean"]/Math.abs(attrgwr["beta_X.Kum.Mean"])).toFixed(2))
            $('#kummean-sehat').html((Math.log(69))*$('#kummean-kontribusi').val()*(attrgwr["beta_X.Kum.Mean"]/Math.abs(attrgwr["beta_X.Kum.Mean"])).toFixed(2))
            $('#kummean-kurang-sehat').html((Math.log(112))*$('#kummean-kontribusi').val()*(attrgwr["beta_X.Kum.Mean"]/Math.abs(attrgwr["beta_X.Kum.Mean"])).toFixed(2))
            $("#pklcount-input").val(Math.abs(parseFloat(((attrstd["X.PKL.Count"]*xstats["X.PKL.Count"]["sd"])+xstats["X.PKL.Count"]["mean"])).toFixed(0)))
            $("#pklcount-betha").html(attrgwr["beta_X.PKL.Count"].toFixed(3))
            $("#pklcount-kontribusi").html((100*Math.abs(attrgwr["beta_X.PKL.Count"])/totalKontribusi).toFixed(2)+" %")
            $('#pklcount-sangat-sehat').html((Math.log(37))*$('#pklcount-kontribusi').val()*(attrgwr["beta_X.PKL.Count"]/Math.abs(attrgwr["beta_X.PKL.Count"])).toFixed(2))
            $('#pklcount-sehat').html((Math.log(69))*$('#pklcount-kontribusi').val()*(attrgwr["beta_X.PKL.Count"]/Math.abs(attrgwr["beta_X.PKL.Count"])).toFixed(2))
            $('#pklcount-kurang-sehat').html((Math.log(112))*$('#pklcount-kontribusi').val()*(attrgwr["beta_X.PKL.Count"]/Math.abs(attrgwr["beta_X.PKL.Count"])).toFixed(2))
            $("#pendcount-input").val(Math.abs(parseFloat(((attrstd["X.Pend.Count"]*xstats["X.Pend.Count"]["sd"])+xstats["X.Pend.Count"]["mean"])).toFixed(0)))
            $("#pendcount-betha").html(attrgwr["beta_X.Pend.Count"].toFixed(3))
            $("#pendcount-kontribusi").html((100*Math.abs(attrgwr["beta_X.Pend.Count"])/totalKontribusi).toFixed(2)+" %")
            $('#pendcount-sangat-sehat').html((Math.log(37))*$('#pendcount-kontribusi').val()*(attrgwr["beta_X.Pend.Count"]/Math.abs(attrgwr["beta_X.Pend.Count"])).toFixed(2))
            $('#pendcount-sehat').html((Math.log(69))*$('#pendcount-kontribusi').val()*(attrgwr["beta_X.Pend.Count"]/Math.abs(attrgwr["beta_X.Pend.Count"])).toFixed(2))
            $('#pendcount-kurang-sehat').html((Math.log(112))*$('#pendcount-kontribusi').val()*(attrgwr["beta_X.Pend.Count"]/Math.abs(attrgwr["beta_X.Pend.Count"])).toFixed(2))  
            $("#soscount-input").val(Math.abs(parseFloat(((attrstd["X.Sos.Count"]*xstats["X.Sos.Count"]["sd"])+xstats["X.Sos.Count"]["mean"])).toFixed(0)))
            $("#soscount-betha").html(attrgwr["beta_X.Sos.Count"].toFixed(3))
            $("#soscount-kontribusi").html((100*Math.abs(attrgwr["beta_X.Sos.Count"])/totalKontribusi).toFixed(2)+" %")
            $('#soscount-sangat-sehat').html((Math.log(37))*$('#soscount-kontribusi').val()*(attrgwr["beta_X.Sos.Count"]/Math.abs(attrgwr["beta_X.Sos.Count"])).toFixed(2))
            $('#soscount-sehat').html((Math.log(69))*$('#soscount-kontribusi').val()*(attrgwr["beta_X.Sos.Count"]/Math.abs(attrgwr["beta_X.Sos.Count"])).toFixed(2))
            $('#soscount-kurang-sehat').html((Math.log(112))*$('#soscount-kontribusi').val()*(attrgwr["beta_X.Sos.Count"]/Math.abs(attrgwr["beta_X.Sos.Count"])).toFixed(2))
            $("#rekrcount-input").val(Math.abs(parseFloat(((attrstd["X.Rekr.Count"]*xstats["X.Rekr.Count"]["sd"])+xstats["X.Rekr.Count"]["mean"])).toFixed(0)))
            $("#rekrcount-betha").html(attrgwr["beta_X.Rekr.Count"].toFixed(3))
            $("#rekrcount-kontribusi").html((100*Math.abs(attrgwr["beta_X.Rekr.Count"])/totalKontribusi).toFixed(2)+" %")
            $('#rekrcount-sangat-sehat').html((Math.log(37))*$('#rekrcount-kontribusi').val()*(attrgwr["beta_X.Rekr.Count"]/Math.abs(attrgwr["beta_X.Rekr.Count"])).toFixed(2))
            $('#rekrcount-sehat').html((Math.log(69))*$('#rekrcount-kontribusi').val()*(attrgwr["beta_X.Rekr.Count"]/Math.abs(attrgwr["beta_X.Rekr.Count"])).toFixed(2))
            $('#rekrcount-kurang-sehat').html((Math.log(112))*$('#rekrcount-kontribusi').val()*(attrgwr["beta_X.Rekr.Count"]/Math.abs(attrgwr["beta_X.Rekr.Count"])).toFixed(2))      
            $("#workcount-input").val(Math.abs(parseFloat(((attrstd["X.Work.Count"]*xstats["X.Work.Count"]["sd"])+xstats["X.Work.Count"]["mean"])).toFixed(0)))
            $("#workcount-betha").html(attrgwr["beta_X.Work.Count"].toFixed(3))
            $("#workcount-kontribusi").html((100*Math.abs(attrgwr["beta_X.Work.Count"])/totalKontribusi).toFixed(2)+" %")
            $('#workcount-sangat-sehat').html((Math.log(37))*$('#workcount-kontribusi').val()*(attrgwr["beta_X.Work.Count"]/Math.abs(attrgwr["beta_X.Work.Count"])).toFixed(2))
            $('#workcount-sehat').html((Math.log(69))*$('#workcount-kontribusi').val()*(attrgwr["beta_X.Work.Count"]/Math.abs(attrgwr["beta_X.Work.Count"])).toFixed(2))
            $('#workcount-kurang-sehat').html((Math.log(112))*$('#workcount-kontribusi').val()*(attrgwr["beta_X.Work.Count"]/Math.abs(attrgwr["beta_X.Work.Count"])).toFixed(2))                
            $("#perbcount-input").val(Math.abs(parseFloat(((attrstd["X.Perb.Count"]*xstats["X.Perb.Count"]["sd"])+xstats["X.Perb.Count"]["mean"])).toFixed(0)))
            $("#perbcount-betha").html(attrgwr["beta_X.Perb.Count"].toFixed(3))
            $("#perbcount-kontribusi").html((100*Math.abs(attrgwr["beta_X.Perb.Count"])/totalKontribusi).toFixed(2)+" %")
            $('#perbcount-sangat-sehat').html((Math.log(37))*$('#perbcount-kontribusi').val()*(attrgwr["beta_X.Perb.Count"]/Math.abs(attrgwr["beta_X.Perb.Count"])).toFixed(2))
            $('#perbcount-sehat').html((Math.log(69))*$('#perbcount-kontribusi').val()*(attrgwr["beta_X.Perb.Count"]/Math.abs(attrgwr["beta_X.Perb.Count"])).toFixed(2))
            $('#perbcount-kurang-sehat').html((Math.log(112))*$('#perbcount-kontribusi').val()*(attrgwr["beta_X.Perb.Count"]/Math.abs(attrgwr["beta_X.Perb.Count"])).toFixed(2))                
            $("#penduduk-input").html(Math.abs(parseFloat(((attrstd["CX.Pop.Count"]*xstats["CX.Pop.Count"]["sd"])+xstats["CX.Pop.Count"]["mean"])).toFixed(0)))
            $("#penduduk-betha").html(attrgwr["beta_CX.Pop.Count"].toFixed(3))
            $("#penduduk-kontribusi").html((100*Math.abs(attrgwr["beta_X.Lay.Air"])/totalKontribusi).toFixed(2)+" %")


            let rumus="ln(y"+checkMinus($('#yresidu-value').html())+")="+attrgwr["beta_Intercept"].toFixed(3)+checkMinus($("#rb-betha").html())+
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
            $("#rumus-model").html(rumus)
            
        })
        map.on('mousemove', (e)=>{
            let features = map.queryRenderedFeatures(e.point, { layers: ['lyr-heksagon'] });
            map.getCanvas().style.cursor = (features.length) ? 'pointer' : '';
        })
    })
</script>