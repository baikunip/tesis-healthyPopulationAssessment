<script>
    let map = new maplibregl.Map({
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
                    ['==', ['get','sumSakit'], 0],'#fef0d9',
                    ['<=', ['get','sumSakit'], 37],'#fdcc8a',
                    ['<=', ['get','sumSakit'], 69],'#fc8d59',
                    ['>', ['get','sumSakit'], 112],'#e34a33',
                    '#fef0d9'
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
            let feature=features[0]
            $("#scorecardlLabel").html("Nilai Lingkungan Binaan Sel No. "+feature['properties']['newID'])
            $("#y-value").html(feature['properties']['sumSakit'])
            $("#scorecard").modal('show')
        })
        map.on('mousemove', (e)=>{
            let features = map.queryRenderedFeatures(e.point, { layers: ['lyr-heksagon'] });
            map.getCanvas().style.cursor = (features.length) ? 'pointer' : '';
        })
    })
</script>