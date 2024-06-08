<script>
    let map = new maplibregl.Map({
        container: 'map', // container id
        // style: 'https://demotiles.maplibre.org/style.json', // style URL
        center: [110.42925583629346,-7.000128974410487], // starting position [lng, lat]
        zoom: 12,// starting zoom
        style: {
            'id': 'raster',
            'version': 8,
            'name': 'Raster tiles',
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
</script>