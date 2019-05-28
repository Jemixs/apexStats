var iconsUrl = '/images/';
L.CRS.MySimple = L.extend({}, L.CRS.Simple, {
	transformation: new L.Transformation(1 / 16, 0, -1 / 16, 256)
});

var myBounds = [[0,0],[4096, 4096]];

var map = L.map('map', {
	maxNativeZoom: 4,
	minZoom: 1,
	maxZoom: 4,
	zoomControl: false,
	fullscreenControl: true,
	fullscreenControlOptions: {
		position: 'topright'
	},
	crs: L.CRS.MySimple

}).setView([2048,2048], 2);

L.tileLayer('./map/{z}/{x}-{y}.jpg', {
	maxNativeZoom: 4,
	minZoom: 1,
	maxZoom: 4,
	tileSize: 256,
	noWrap: true,
	tms: false,
	bounds: myBounds,
	continuousWorld: true
}).addTo(map);

map.setMaxBounds([[-3000, -3000], [7000, 7000]]);

map.on("click", function(e) {
	var latting = e.latlng.lat+','+e.latlng.lng;
	console.log(latting);
});

var transparentMarker = L.icon({
	iconUrl: iconsUrl+'alpha_marker.png',
	iconSize: [1, 1],
	iconAnchor: [0, 0],
	popupAnchor: [0, 0]
});

/*var textMarker = new L.marker([988,1312], { opacity: 0.0, icon: transparentMarker }); //opacity may be set to zero
textMarker.bindTooltip('<span class="citys">ЧЕРЕП</span>', {permanent: true, direction: "top", className: "text-label", offset: [0, 0]});
textMarker.addTo(map); // Adds the text markers to map.*/

var layerGroups = [];

for (var i = 0; i < textMarkers.length; i++) {
	if (layerGroups.textmarkers == undefined) {
		layerGroups.textmarkers = new L.LayerGroup();
	}

	var textMarker = new L.marker(textMarkers[i].coords, { opacity: 0.0, icon: transparentMarker });
	textMarker.bindTooltip(textMarkers[i].name, {permanent: true, direction: "top", className: "text-label", offset: [0, 0]});
	textMarker.addTo(layerGroups.textmarkers);
}

var grLayer = [];
grLayer = new L.LayerGroup();

var respawnIcon = L.icon({
	iconUrl: '/images/respawn-point.png',
	iconSize: [40, 40],
	iconAnchor: [10, 30]
});

var scanerIcon = L.icon({
	iconUrl: '/images/scaner-point.png',
	iconSize: [40, 40],
	iconAnchor: [10, 30]
});

var editableLayers = new L.FeatureGroup();
map.addLayer(editableLayers);

var options = {
	position: 'topright',
	draw: {
		polyline: {
			shapeOptions: {
				color: '#bada55',
				weight: 5
			}
		},
		polygon: {
                allowIntersection: false, // Restricts shapes to simple polygons
                shapeOptions: {
                	color: '#bada55'
                }
            },
            circle: false, // Turns off this drawing tool
            rectangle: {
            	shapeOptions: {
            		clickable: false
            	}
            },
            marker: false,
            circlemarker: false
        },
        edit: {
            featureGroup: editableLayers, //REQUIRED!!
            remove: true
        }
    };
    
/*    var drawControl = new L.Control.Draw(options);
map.addControl(drawControl);*/

/*map.on(L.Draw.Event.CREATED, function (e) {
	var type = e.layerType,
	layer = e.layer;
	editableLayers.addLayer(layer);
});*/

/*map.on('draw:created', function (e) {
  var type = e.layerType;
  var layer = e.layer;

  var shape = layer.toGeoJSON()
  var shape_for_db = JSON.stringify(shape);
  console.log(shape_for_db);
});*/

layerGroups['resp'] = new L.LayerGroup();
layerGroups['scaner'] = new L.LayerGroup();
layerGroups['tierOne'] = new L.LayerGroup();
layerGroups['tierTwo'] = new L.LayerGroup();
layerGroups['tierThree'] = new L.LayerGroup();

for (var i = 0; i < lootSpawn.length; i++) {
	L.geoJSON(lootSpawn[i].data,{
		style: {
			"weight":"4",
			"fillOpacity":"0.4",
			"color":lootSpawn[i].color,
			"opacity":"1"
		}
	}).addTo(layerGroups[lootSpawn[i].tier]);
}

map.addLayer(layerGroups['textmarkers']);
map.addLayer(layerGroups['tierOne']);
map.addLayer(layerGroups['tierTwo']);
map.addLayer(layerGroups['tierThree']);
map.addLayer(layerGroups['resp']);
map.addLayer(layerGroups['scaner']);

for (var i = 0; i < respawnpoint.length; i++) {
	var marU = L.marker(respawnpoint[i].coords,{icon:respawnIcon, markId: i, draggable: false}).addTo(layerGroups['resp']);
}

for (var i = 0; i < scanerPoint.length; i++) {
	var marU = L.marker(scanerPoint[i].coords,{icon:scanerIcon, markId: i, draggable: false}).addTo(layerGroups['scaner']);
}

$('#showAll').click(function(e) {
	e.preventDefault();
	if ($(this).attr('data-target') == 'active') {
		$('.mapSidebar .menu a').each(function() {
			$(this).removeClass();
			$(this).addClass('nocheck');
		});
		
		map.removeLayer(layerGroups['textmarkers']);
		map.removeLayer(layerGroups['tierOne']);
		map.removeLayer(layerGroups['tierTwo']);
		map.removeLayer(layerGroups['tierThree']);
		map.removeLayer(layerGroups['resp']);
		map.removeLayer(layerGroups['scaner']);

		$('#showAll').html('<i class="fas fa-eye"></i> Показать все');
		$(this).attr('data-target','not-active');
	} else {
		$('.mapSidebar .menu a').each(function() {
			$(this).removeClass();
			$(this).addClass('cheked');
		});
		// for (var keys in layerGroups) {
		// 	map.removeLayer(layerGroups[keys]);
		// }
		map.addLayer(layerGroups['textmarkers']);
		map.addLayer(layerGroups['tierOne']);
		map.addLayer(layerGroups['tierTwo']);
		map.addLayer(layerGroups['tierThree']);
		map.addLayer(layerGroups['resp']);
		map.addLayer(layerGroups['scaner']);

		$('#showAll').html('<i class="fas fa-eye"></i> Скрыть все');
		$(this).attr('data-target','active');
	}
})

$('.mapSidebar li a').click(function(e) {
	e.preventDefault();
	var theID = this.id;
	if (this.className == 'cheked') {
		$(this).removeClass('cheked');
		$(this).addClass('nocheck');
		map.removeLayer(layerGroups[theID]);
		var last = $('.mapSidebar .menu').find('.cheked');
		if (last.length == 0) {
			$('#showAll').html('<i class="fas fa-eye"></i> Показать все');
			$('#showAll').attr('data-target','not-active');
		}
	}else{
		$(this).removeClass('nocheck');
		$(this).addClass('cheked');
		map.addLayer(layerGroups[this.id]);
		var last = $('.mapSidebar .menu').find('.cheked');
		if (last.length >5) {
			$('#showAll').html('<i class="fas fa-eye"></i> Скрыть все');
			$('#showAll').attr('data-target','active');
		}
	}
});

function tog(element, layer) {
	if (element == 'nocheck') {
		map.addLayer(layerGroups[layer]);
	} else if(element == 'check'){
		map.removeLayer(layerGroups[layer]);
	}
}