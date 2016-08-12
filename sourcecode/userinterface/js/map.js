var map;

function map_initialize(){
	
	map = L.map('map',{
				minZoom: 18
			}
		);
		
	//Geolokalisation
	if(navigator.geolocation) {
		
		//Firefox keine Fehlermeldung bei unterbundener Geolokalisation
		if (isFirefox){
			map.setView([49.4400657, 7.7491265],18);
		}
			
		navigator.geolocation.getCurrentPosition(function(position) {
			map.setView([position.coords.latitude, position.coords.longitude],16);					
		},
		function(error) {
			map.setView([49.4400657, 7.7491265],18);
		}, {
			enableHighAccuracy: false, 
			maximumAge: 1800000,
			timeout: 10000    
		});
	}
	else
	{
		//Koordinaten KL
		map.setView([49.4400657, 7.7491265],18);
	}

	L.tileLayer( 'http://b.tile.osm.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
		subdomains: ['a','c']
	}).addTo(map);
			
	//Ersters Laden - Timeout für Chrome			
//	setTimeout(function(){
//		loadMarker(map.getBounds())	
//	},150);
//	
	
	//Nachladen bei Move
	//map.on('moveend', function(){	
//		loadMarker(map.getBounds(), map);
//	});

};
