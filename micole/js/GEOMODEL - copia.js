/*Copyright © 2016 Sergio Aznar Cabotá & Rodrigo Diaz & Cristina Sesé Martínez
   EMPRESA : GEOMODEL (info@geomodel.es) */
   
	  // Version 10.1 cambiar todos los CrossOrigin de '' a '*'
	
	proj4.defs("EPSG:25830","+proj=utm +zone=30 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
	
	//MAPA
				
		
		
		//CAPA CATASTRO
		 var Catastro = new ol.source.TileWMS({
			  url: 'http://localhost:8080/geoserver/wms?',
			  params: {'LAYERS': 'pam_sagunto:Catastro'},
			  serverType: 'geoserver',
			  crossOrigin: '*',
			});
		 var WMS_Catastro = new ol.layer.Tile({
			  source: Catastro
			});
		WMS_Catastro.setVisible(false);
		WMS_Catastro.set('name', 'Catastro');
		WMS_Catastro.setZIndex(2);
		 //CAPA PNOA
		  var PNOA = new ol.source.TileWMS({
			  url: 'http://localhost:8080/geoserver/wms?',
			  params: {'LAYERS': 'colegios:OI.OrthoimageCoverage'},
			  serverType: 'geoserver',
			  crossOrigin: '*',
			});
		 var WMS_PNOA = new ol.layer.Tile({
			  source: PNOA
			});
		WMS_PNOA.setVisible(false);
		WMS_PNOA.set('name', 'PNOA');
		var constru = new ol.source.TileWMS({
			  url: 'http://localhost:8080/geoserver/wms?',
			  params: {'LAYERS': 'pam_sagunto:construcciones'},
			  serverType: 'geoserver',
			  crossOrigin: '*',
			});
 
			var WMS0 = new ol.layer.Tile({
			  source: constru
			});
			
			WMS0.setZIndex(1)
		 
		 // CAPAS WMS
			var capa_base = new ol.source.TileWMS({
			  url: 'http://localhost:8080/geoserver/wms?',
			  params: {'LAYERS': 'colegios:capa_base'},
			  serverType: 'geoserver',
			  crossOrigin: '*',
			});
 
			var WMS1 = new ol.layer.Tile({
			  source: capa_base
			});
			WMS1.setOpacity(0.3);
			WMS1.set('name', 'WMS1');
			
			var centros = new ol.source.TileWMS({
			  url: 'http://localhost:8080/geoserver/wms?',
			  params: {'LAYERS': 'colegios:centros'},
			  serverType: 'geoserver',
			  crossOrigin: '*',
			});
 
			var WMS2 = new ol.layer.Tile({
			  source: centros
			});
			WMS2.setOpacity(0.7);
			WMS2.set('name', 'centros');
			WMS2.setVisible(false);
			WMS2.setZIndex(2);
			
			var centros_infantil_source = new ol.source.TileWMS({
			  url: 'http://localhost:8080/geoserver/wms?',
			  params: {'LAYERS': 'colegios:centros_infantil'},
			  serverType: 'geoserver',
			  crossOrigin: '*',
			});
 
			var centros_infantil = new ol.layer.Tile({
			  source: centros_infantil_source
			});
			
			centros_infantil.setVisible(false);
			centros_infantil.set('name', 'centros_infantil');
			centros_infantil.setZIndex(2);
			
			var centros_primaria_source = new ol.source.TileWMS({
			  url: 'http://localhost:8080/geoserver/wms?',
			  params: {'LAYERS': 'colegios:centros_primaria'},
			  serverType: 'geoserver',
			  crossOrigin: '*',
			});
 
			var centros_primaria = new ol.layer.Tile({
			  source: centros_primaria_source
			});
			
			centros_primaria.setVisible(false);
			centros_primaria.set('name', 'centros_primaria');
			centros_primaria.setZIndex(2);
			
			
			var centros_eso_source = new ol.source.TileWMS({
			  url: 'http://localhost:8080/geoserver/wms?',
			  params: {'LAYERS': 'colegios:centros_eso'},
			  serverType: 'geoserver',
			  crossOrigin: '*',
			});
 
			var centros_eso = new ol.layer.Tile({
			  source: centros_eso_source
			});
			centros_eso.setVisible(false);
			centros_eso.set('name', 'centros_eso');
			centros_eso.setZIndex(2);
			
			
			
			var centros_bachiller_source = new ol.source.TileWMS({
			  url: 'http://localhost:8080/geoserver/wms?',
			  params: {'LAYERS': 'colegios:centros_bachiller'},
			  serverType: 'geoserver',
			  crossOrigin: '*',
			});
 
			var centros_bachiller = new ol.layer.Tile({
			  source: centros_bachiller_source
			});
			centros_bachiller.setVisible(false);
			centros_bachiller.set('name', 'centros_bachiller');
			centros_bachiller.setZIndex(2);
			
			var distritos_prim_source = new ol.source.TileWMS({
			  url: 'http://localhost:8080/geoserver/wms?',
			  params: {'LAYERS': 'colegios:distritos_prim'},
			  serverType: 'geoserver',
			  crossOrigin: '*',
			});
 
			var distritos_prim = new ol.layer.Tile({
			  source: distritos_prim_source
			});
			distritos_prim.setVisible(false);
			distritos_prim.set('name', 'distritos_prim');
			distritos_prim.setZIndex(0);
			
			var areas_bach_source = new ol.source.TileWMS({
			  url: 'http://localhost:8080/geoserver/wms?',
			  params: {'LAYERS': 'colegios:areas_bach'},
			  serverType: 'geoserver',
			  crossOrigin: '*',
			});
 
			var areas_bach = new ol.layer.Tile({
			  source: areas_bach_source
			});
			areas_bach.setVisible(false);
			areas_bach.set('name', 'areas_bach');
			areas_bach.setZIndex(0);
			
			
			
			var bing = new ol.layer.Tile({
					  source: new ol.source.BingMaps({
							imagerySet: 'Aerial',
							key:'AoD-4gLe-rOELtb5sHE6_JaRCBGKoKFzFYZC1kynIMXeJnC8Wvz8XfhnxxPDyZeL'})
					});
				
			
				  var MapQuest = new ol.layer.Tile({
						  style: 'Road',
						  source: new ol.source.MapQuest({layer: 'osm'})
						}) 
				

					
			//CAPA MEDICION
		    var source = new ol.source.Vector();

		    var medir = new ol.layer.Vector({
			  source: source,
			  style: new ol.style.Style({
				fill: new ol.style.Fill({
				  color: 'rgba(255, 255, 255, 0.2)'
				}),
				stroke: new ol.style.Stroke({
				  color: '#ffcc33',
				  width: 2
				}),
				image: new ol.style.Circle({
				  radius: 1,
				  fill: new ol.style.Fill({
					color: 'red'
				  })
				})
			  })
			});
			//FIN DE CAPAS WMS
			 // La vista inicial del mapa
			
			var view = new ol.View({
			  
			  center: ol.proj.transform([-0.370,39.465], 'EPSG:4326','EPSG:3857'),
			  zoom: 13,
			  projection: 'EPSG:3857',
			  maxZoom:21,
			  minZoom: 11,
			  			  
			  
			  extent: [-51165.036,4783018.381,-31941.123,4793796.002]
			  //-38196.1689, 4800000.6795, -17666.5082, 4829931.3004
			  //-41012.64966806532, 4810650.687477103, -13801.06759854258, 4812000.850386201
			  //-51824.3052,4810392.3921,-10395.4358,4834775.8041
			});
			
			var map = new ol.Map({
				preload: 4,
				projection: 'EPSG:3857',
				target: 'map',
				controls: [],
				loadTilesWhileAnimating: true,
				layers: [ 
				new ol.layer.Group({  
					  layers: [MapQuest
					  ]
					}),
				new ol.layer.Group({  
					  layers: [WMS_PNOA,distritos_prim,areas_bach,WMS1
					  ]
					}),
				new ol.layer.Group({  
					  layers: [WMS2,centros_infantil,centros_primaria,centros_eso,centros_bachiller
					  ],
					  name:'capas',
					}),
				new ol.layer.Group({  
					  layers: [medir
					  ]
					}),	
				],
				 interactions: ol.interaction.defaults({shiftDragZoom: false}),
				 target: 'map',
				 view: view
			});
			
			
		 // Herramientas
			var dragZoom = new ol.interaction.DragZoom({condition:ol.events.condition.always});	
			
			
	
			$(window).load(function() {
				map.updateSize();
				wfs();
				source.clear();	
				map.addOverlay(overlay);
				map.addLayer(buf_centro);
				infoAct = true;
				var valor_entrada=document.getElementById("tipoCole").value;
				var portal=document.getElementById("portal2").value;
				var calle = document.getElementById("identificadorCalle").value;
				console.log(calle);
				var usuario=document.getElementById("usuario").value;
				console.log(usuario);
				funcionBuscarEntrada(portal,calle,valor_entrada,usuario);
				var x_pos=$('#x_pos').val();
				var y_pos=$('#y_pos').val();
				
				
				
				function hideLoader() {
					loading_loader = jQuery('#loader');
					loading_loader.css({height: 0});
					loading_loader.css({display: 'none'});
					jQuery('#loader-container').css({display: 'none'});
				}
				if(valor_entrada==1){
					centros_infantil.setVisible(true);
					$("#capa_21").addClass("capaActiva");
					$("#visible21").prop("checked", true);
					//// BUSQUEDA INFLUENCIA INFANTIL
					
					}
				if(valor_entrada==2){
					centros_primaria.setVisible(true);
					$("#capa_22").addClass("capaActiva");
					$("#visible22").prop("checked", true);
					//// BUSQUEDA INFLUENCIA INFANTIL
					
					}
				if(valor_entrada==3){
					centros_eso.setVisible(true);
					$("#capa_23").addClass("capaActiva");
					$("#visible23").prop("checked", true);
					//// BUSQUEDA INFLUENCIA BACHILLER
					
					}
				if(valor_entrada==4){
					centros_bachiller.setVisible(true);
					$("#capa_24").addClass("capaActiva");
					$("#visible24").prop("checked", true);
					//// BUSQUEDA INFLUENCIA BACHILLER
					
					}
				
					
				
				  
				
				
				hideLoader();
			});
			$(document).ready(function(){
				$(".btnZoomIn").mouseover(function(){
					$(this).addClass("btnZoomInActivo");
				});
				$(".btnZoomIn").mouseout(function(){
					$(this).removeClass("btnZoomInActivo");
				});
				$(".btnZoomIn").click(function(){
					var view =map.getView();
					var newResolution= view.constrainResolution(view.getResolution(),1);
					view.setResolution(newResolution);
				});
				$(".btnZoomOut").mouseover(function(){
					$(this).addClass("btnZoomOutActivo");
				});
				$(".btnZoomOut").mouseout(function(){
					$(this).removeClass("btnZoomOutActivo");
				});
				$(".btnZoomOut").click(function(){
					var view =map.getView();
					var newResolution= view.constrainResolution(view.getResolution(),-1);
					view.setResolution(newResolution);
				});
				$(".btnZoomCaja").mouseover(function(){
					$(this).addClass("btnZoomCajaActivo1");
				});
				$(".btnZoomCaja").mouseout(function(){
					$(this).removeClass("btnZoomCajaActivo1");
				});
				$('.btnZoomCaja').on('click',function(){
					$(this).addClass("btnZoomCajaActivo");
					map.addInteraction(dragZoom);
					dragZoom.on('boxend', function() {
						map.removeInteraction(dragZoom);
						$('.btnZoomCaja').removeClass("btnZoomCajaActivo");
					});
				});
				
				$('.btnZoomExtension').on('click',function(){
					map.getView().fit([-51165.036,4783018.381,-31941.123,4793796.002], map.getSize());
				});
				$(".btnZoomExtension").mouseover(function(){
					$(this).addClass("btnZoomExtensionActivo");
				});
				$(".btnZoomExtension").mouseout(function(){
					$(this).removeClass("btnZoomExtensionActivo");
				});
	
						
				
				
				
				var infoAct = false;
				$(".btnInfo").mouseover(function(){
					$(this).addClass("btnInfoActiva1");
				});
				$(".btnInfo").mouseout(function(){
					$(this).removeClass("btnInfoActiva1");
				});
				
				
				
			
			});
			 
			var contador=0;
			var iconFeatures2=[];
			var iconFeatures3=[];
			//CAPA CONSULTA SQL View
			
			
			var vectorSource3 = new ol.source.Vector({
				
				});
			var prueba3 = new ol.layer.Vector({
			  source: vectorSource3,
			 
			});				
			map.addLayer(prueba3);
			prueba3.setZIndex(2);
			var vectorSource2 = new ol.source.Vector({
				
				});
			var prueba2 = new ol.layer.Vector({
			  source: vectorSource2,
			 
			});				
			map.addLayer(prueba2);
			prueba2.setZIndex(2);
		
	function areas_bach_1(x_pos,y_pos){
		
				var params = {
						  'LAYERS': 'colegios:busqueda_areas_bach',
						  FORMAT: 'image/png'
						};
						// The "start" and "destination" features.
						
						
						// A transform function to convert coordinates from EPSG:3857
						// to EPSG:4326.
						var transform = ol.proj.getTransform('EPSG:4326', 'EPSG:3857');

						// Register a map click listener.
						
						   
							// Second click.
							
							// Transform the coordinates from the map projection (EPSG:3857)
							// to the server projection (EPSG:4326).
							
							var viewparams = [
							  'x:' + x_pos,
							  'y:' + y_pos
							 
							];
							
							params.viewparams = viewparams.join(';');
							area_influencia_bach = new ol.layer.Tile({
							  source: new ol.source.TileWMS({
								url: 'http://localhost:8080/geoserver/colegios/wms?',
								params: params,
								serverType: 'geoserver',
								crossOrigin: '*',
							  })
							});
							
							map.addLayer(area_influencia_bach);
		
		
	}
	
	function areas_prim(x_pos,y_pos){
		
			var params = {
				  'LAYERS': 'colegios:busquedas_areas_prim',
				  FORMAT: 'image/png'
				};
				// The "start" and "destination" features.
				
				
				// A transform function to convert coordinates from EPSG:3857
				// to EPSG:4326.
				var transform = ol.proj.getTransform('EPSG:4326', 'EPSG:3857');

				// Register a map click listener.
				
				   
					// Second click.
					
					// Transform the coordinates from the map projection (EPSG:3857)
					// to the server projection (EPSG:4326).
					
					var viewparams = [
					  'x:' + x_pos,
					  'y:' + y_pos
					 
					];
					
					params.viewparams = viewparams.join(';');
					area_influencia_prim = new ol.layer.Tile({
					  source: new ol.source.TileWMS({
						url: 'http://localhost:8080/geoserver/colegios/wms?',
						params: params,
						serverType: 'geoserver',
						crossOrigin: '*',
					  })
					});
					
					map.addLayer(area_influencia_prim);
		
	}
	
	function funcionBuscar(){
				if (contador>0){
					vectorSource3.clear()
					iconFeatures3=[];
				}
				
			    var vial	= document.getElementById("input").value;
			    var portal	= document.getElementById("portal").value;

				//ENLACES PARA BUSCADOR DE RUTAS
				
				$.ajax({
			data:  {'vial':vial,'portal':portal
										},
			url:   'consulta_portal.php',
			type:  'post',
			dataType: 'json',
			success:  function (response) {
				
				var x = response[0];
				var x1=parseFloat(x);
				var y = response[1];
				var y1=parseFloat(y);
				var coor1=[x1,y1];
				var coor1_3857=ol.proj.transform(coor1, 'EPSG:25830', 'EPSG:3857');
				var maxx2=coor1_3857[0];
				
				var maxy2=coor1_3857[1];
				map.getView().setCenter([maxx2,maxy2]);
				map.getView().setZoom(17);
				
				 
				
				var iconFeature3 = new ol.Feature({
				  geometry: new ol.geom.Point(ol.proj.transform(coor1, 'EPSG:25830','EPSG:3857')),
				
				});
				var icono3 = new ol.style.Icon(({
					anchor: [0.1, 1],
					opacity: 1,
					src: 'img/iconos/info_busqueda.png',
					rotation: 0,
					rotateWithView: "true",
				  }));
				  var iconStyle3 = new ol.style.Style({
								image: icono3
								});

				
				iconFeatures3.push(iconFeature3);
				vectorSource3.addFeatures(iconFeatures3);
				iconFeature3.setStyle(iconStyle3);
				
				//var pt1 = turf.point([x1,y1]); //PUNTO TURF

				////LECTURA DEL PUNTO EN FORMATO GEOJSON Y AÑADIDO A UNA CAPA OPENLAYERS
				//turf.inside(datos_centros, polygon);
					
				
				contador=1;
			}
				});
				
			}
var coordenadas_centros=[];
var features = [];
function funcionBuscarEntrada(portal,calle,tipo,usuario){
			
				if (contador>0){
					vectorSource2.clear()
					iconFeatures2=[];
				}
				
			   
				//ENLACES PARA BUSCADOR DE RUTAS
				
			$.ajax({
				  data:{'calle': calle,'portal':portal},
				  method: "POST",
				  url: "sacaCoord.php",
				  dataType: 'json',
				  success:  function (response) {
				
				var x = response[0];
				var x_pos1 = x.split('.');
				var x_pos=parseFloat(x_pos1[0]);
				var x1=parseFloat(x);
				var y = response[1];
				var y_pos1 = y.split('.');
				var y_pos=parseFloat(y_pos1[0]);
				
				var y1=parseFloat(y);
				var coor1=[x1,y1];
				var coor1_3857=ol.proj.transform(coor1, 'EPSG:25830', 'EPSG:3857');
				var maxx2=coor1_3857[0];
				
				var maxy2=coor1_3857[1];
				map.getView().setCenter([maxx2,maxy2]);
				map.getView().setZoom(17);
				
				
				
				
				var iconFeature2 = new ol.Feature({
				  geometry: new ol.geom.Point(ol.proj.transform(coor1, 'EPSG:25830','EPSG:3857')),
				
				});
				var icono = new ol.style.Icon(({
					anchor: [0.1, 1],
					opacity: 1,
					src: 'img/iconos/casa.png',
					rotation: 0,
					rotateWithView: "true",
					
					//src: 'http://openlayers.org/en/v3.6.0/examples/data/icon.png' //32X48 pixels debe ser la imagen
				  }));
				  var iconStyle = new ol.style.Style({
				  image: icono});
				iconFeatures2.push(iconFeature2);
				vectorSource2.addFeatures(iconFeatures2);
				iconFeature2.setStyle(iconStyle);
			
				if(tipo==1){
					areas_prim(x_pos,y_pos);	
				}
				if(tipo==2){
					areas_prim(x_pos,y_pos);
									
				}
				if(tipo==3){
					areas_bach_1(x_pos,y_pos);
				}
				if(tipo==4){
					areas_bach_1(x_pos,y_pos);
				}					
				//var pt1 = turf.point([x1,y1]); //PUNTO TURF

				////LECTURA DEL PUNTO EN FORMATO GEOJSON Y AÑADIDO A UNA CAPA OPENLAYERS
				//turf.inside(datos_centros, polygon);
					
				
				contador=1;
			}
				});
				
		$.ajax({	url: "puntos_centros.php",
						async: false,
						type: "POST",
						data: {'tipo':tipo,'usuario':usuario},
						dataType: 'json',
						success:function(response) {
					
			coordenadas_centros= response;
		
			var coordenadas_centros_contador = coordenadas_centros.length;
			
			
			var puntos_centros_cource = new ol.source.Vector({
			});
			for (var i = 0; i < coordenadas_centros_contador; i++){
				var res = coordenadas_centros[i].split(',');
				var x = res[0];				
				var y = res[1];
				var puntos = res[2];
				var xfin=parseFloat(x);
				var yfin=parseFloat(y);
				features[i] = new ol.Feature(new ol.geom.Point(ol.proj.transform([xfin,yfin], 'EPSG:25830','EPSG:3857')));
				
				var iconFeature = new ol.Feature({
				
				geometry: new ol.geom.Point(ol.proj.transform([xfin,yfin], 'EPSG:25830','EPSG:3857'))});

				var iconStyle = new ol.style.Style({    
							
					
					fill: new ol.style.Fill({
					  color: 'green'
					}),
					stroke: new ol.style.Stroke({
					  color: 'black',
					  width: 1.2
					}),
					 text: new ol.style.Text({
					font: '12px Verdana',
					text: puntos,
					textAlign: 'center',
					textBaseline: 'middle',
					stroke: new ol.style.Stroke({color: 'white', width: 4}),
					offsetY : -15
				})
					 
					
				  })
				iconFeature.setStyle(iconStyle);

				puntos_centros_cource.addFeature(iconFeature);
				};
				
			
			
			
			
			
			
			var styleCache = {};
			
			var PUNTOS1 = new ol.layer.Vector({
				source: puntos_centros_cource,
				 style: new ol.style.Style({ 
					text: new ol.style.Text({
					font: '50px Verdana',
					text: puntos,
					fill: new ol.style.Fill({color: 'black'}),
					stroke: new ol.style.Stroke({color: 'white', width: 10})
							})
					})});
				
						map.addLayer(PUNTOS1);
						PUNTOS1.setZIndex(2);}})
};
					
					
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		/////// BUSQUEDA POR CENTRO
		var contador_centro=0;
		function funcionBuscar_centro(){
				if (contador_centro>0){
					
				}
				
			   
				var x_centro=$("#input2").attr("x");
				var y_centro=$("#input2").attr("y");
				//ENLACES PARA BUSCADOR DE RUTAS
				
				var x1_cen=parseFloat(x_centro);
				var y1_cen=parseFloat(y_centro);
				var coor1=[x1_cen,y1_cen];
				var coor1_3857=ol.proj.transform(coor1, 'EPSG:25830', 'EPSG:3857');
				var maxx2=coor1_3857[0];
				
				var maxy2=coor1_3857[1];
				map.getView().setCenter([maxx2,maxy2]);
				map.getView().setZoom(17);
				
				
				contador_centro=1;
			}
				
			
			//FIN CAPA CONSULTA
			
			
			
				
			
				
						
			//ARBOL DE CAPAS 
			function bindInputs(layerid, layer) {
			  var visibilityInput = $(layerid + ' input.visible');
			  visibilityInput.on('change', function() {
				layer.setVisible(this.checked);
			  });
			  visibilityInput.prop('checked', layer.getVisible());

			  $.each(['opacity'],
				  function(i, v) {
					var input = $(layerid + ' input.' + v);
					input.on('input change', function() {
					  layer.set(v, parseFloat(this.value));
					});
					input.val(String(layer.get(v)));
				  }
			  );
			}
			map.getLayers().forEach(function(layer, i) {
			  bindInputs('#layer' + i, layer);
			  if (layer instanceof ol.layer.Group) {
				layer.getLayers().forEach(function(sublayer, j) {
				  bindInputs('#layer' + i + j, sublayer);
				});
			  }
			});

			$('#layertree li > div.deplegaCaracteristicas').click(function() {
			  $(this).siblings('fieldset').toggle();
			} ).siblings('fieldset').hide();
		
		
			//FIN ARBOL DE CAPAS
	
			//MAPA SITUACION
		 
		
		  //FIN MAPA SITUACION

		
			// Zoom al centro del municipio seleccinado
			
			/*function zoom_centro(){
			  map.getView().fit([-39170.426908, 4807756.171063, -28417.526806, 4813754.218957], map.getSize());
			}*/
			// Zoom al centro del municipio seleccinado
			

			// Zoom al objeto seleccinado
			
			function zoom_objeto(){
			
			
			var maxx1= document.getElementById("maxx").value;
			
			var maxy1= document.getElementById("maxy").value;
			var minx1= document.getElementById("minx").value;
			var miny1= document.getElementById("miny").value;
			

			
			var coor1=[maxx1,maxy1];

			var coor2=[minx1,miny1];
			var coorx1=parseFloat(coor1[0]);
			var coory1=parseFloat(coor1[1]);
			var coorx2=parseFloat(coor2[0]);
			var coory2=parseFloat(coor2[1]);
			var coor1=[coorx1,coory1];
			var coor2=[coorx2,coory2];
			// CONFORME EL SISTEMA DE REFERENCIA QUE SEA CAMBIAR AQUÍ ABAJO
			var coor1_3857=ol.proj.transform(coor1, 'EPSG:25830', 'EPSG:3857');
		
			var coor2_3857=ol.proj.transform(coor2, 'EPSG:25830', 'EPSG:3857');

			var maxx2=coor1_3857[0];
			var maxy2=coor1_3857[1];
			var minx2=coor2_3857[0];
			var miny2=coor2_3857[1];
			
			var maxx=parseFloat(maxx2);
			var maxy=parseFloat(maxy2);
			
			
			var minx =parseFloat(minx2);
			var miny=parseFloat(miny2);

			var zoomob = [minx,miny,maxx,maxy];
		
				
			map.getView().fit(zoomob, map.getSize());
			};
			
			// FIN Zoom al Objeto seleccinado
				
		//GETFEATURE INFO A LAS WMS
	
////UNA SOLUCION SERIA PONER UN DESPLEGABLE DE QUE CAPA QUIERES BUSCAR INFORMACION
	
		//FIN  GETFEATURE INFO A LAS WMS
		
		//FIN  GETFEATURE INFO A LAS WMS
		
		
		//ESCALA
		
		var myScaleLine = new ol.control.ScaleLine()
		map.addControl(myScaleLine);
		
		
		//FIN ESCALA
		
		
		
		
		var controls = map.getControls();
		  var attributionControl;
		  controls.forEach(function (el) {
			
			if (el instanceof ol.control.Attribution) {
			  attributionControl = el;
			}
		  });
		  map.removeControl(attributionControl);
		  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////		
	////IMPRIMIR 

//////BUSQUEDA POPUP
var contador_pop=0;



//////////////////////////////////////////////// POPUP

var container = document.getElementById('popup');
var content = document.getElementById('popup-content');
var closer = document.getElementById('popup-closer');
var zoom_pop= document.getElementById('popup-zoom');
var popup=true;
closer.onclick = function() {
  overlay.setPosition(undefined);
  closer.blur();
  return false;
};




var overlay = new ol.Overlay(({
  element: container,
  autoPan: true,
  autoPanAnimation: {
    duration: 250
  }
}));

map.on('singleclick', function(evt) {

 
  var cordinate = evt.coordinate;
  cargaModal(cordinate);
  function cargaModal(cordinate){
	  $("#popup-content").html("<div class='loader'></div>");
	  var capa= $("#capa").text();
		
	  ///////////////////////// INVIERNO DIA
	
	  
	  if (capa=='buf_centro'){
		  
		  var id2=$("#Getfeatureinfo").val();
		$.ajax({
			data:  {'id':id2},
			url:   'centros.php',
			type:  'post',
			dataType: 'json',
			success:  function (response) {
				
				if (response[5]==null){
			
				content.innerHTML = "<div class='encabPopup'><span class='tituloPopUp'>Centro de enseñanza :</span></div><div class='contPopup'> - Nombre: "+response[0]+"<br/>- Teléfono: "+response[1]+"<br/>- Tipo: "+response[2]+"<br/>- Área:No tiene docencia de Bachiller ni de E.S.O <br/>- Distrito: "+response[6]+"</div>";

				}else if(response[6]==null){
				content.innerHTML = "<div class='encabPopup'><span class='tituloPopUp'>Centro de enseñanza :</span></div><div class='contPopup'> - Nombre: "+response[0]+"<br/>- Teléfono: "+response[1]+"<br/>- Tipo: "+response[2]+"<br/>- Área: "+response[5]+"<br/>- Distrito: No tiene docencia de Primaria ni de Infantil</div>";
	
				}else {
				content.innerHTML = "<div class='encabPopup'><span class='tituloPopUp'>Centro de enseñanza :</span></div><div class='contPopup'> - Nombre: "+response[0]+"<br/>- Teléfono: "+response[1]+"<br/>- Tipo: "+response[2]+"<br/>- Área: "+response[5]+"<br/>- Distrito: "+response[6]+"</div>";
				}
				
			}
		});
	  }
	 
	  if (capa == 'undefined'){
		  overlay.setPosition(undefined);
	  }else {overlay.setPosition(cordinate);}
	  
	 
	  
	}
  
  

	});







//////////////////////////////////////////////////BOTÓN DERECHO
map.on('click', function (evt) {
    $('.contextMenu').hide();
});

map.getViewport().addEventListener('contextmenu', function (e) {
    e.preventDefault();
    openContextMenu(e.x, e.y);
});

function openContextMenu(x, y) {
    $('.contextMenu').hide();
    $('body').append('<div class="contextMenu" style=" top: ' + y + 'px; left:' + x + 'px;">' +
        '<div class="menuItem" onclick="handleContexMenuEvent(\'zoomIn\', \''+ x +'\', \''+ y +'\');"> Zoom + </div>' +
		'<div class="menuItem" onclick="handleContexMenuEvent(\'zoomOut\', \''+ x +'\', \''+ y +'\');"> Zoom - </div>' +
		'<div class="menuItem" onclick="handleContexMenuEvent(\'centerMap\', \''+ x +'\', \''+ y +'\');"> Centrar el mapa </div>' +
		'<div class="menuItem" onclick="geomodel();"> GEOMODEL </div>' +
        '</div>');
}
function geomodel(){
window.open("http://www.geomodel.es");};
function handleContexMenuEvent(option, x, y) {
    $('.contextMenu').hide();
    var location = map.getCoordinateFromPixel([x, y]);

    if (option == 'zoomIn' ) {
        var view = map.getView();
        view.setZoom(view.getZoom() + 1);
    } else if (option == 'zoomOut' ) {
        var view = map.getView();
        view.setZoom(view.getZoom() - 1);
    } else if (option == 'centerMap' ) {
        
        goToCoord(location[0], location[1]);
    } 
}

function goToCoord(x, y) {
    var p = new ol.geom.Point([x,y]).getCoordinates();
    var pan = ol.animation.pan({
        duration: 200,
        source: map.getView().getCenter()
    });

    map.beforeRender(pan);
    map.getView().setCenter(p);
}

/////////////////////////////////////////////////////////////CAPAS WFS


 





///////////////////////////////CONFIGURACION PARA WFS highlight Urbana

/////////////////CENTROS
  var buf_centro_source= new ol.source.Vector({
  format: new ol.format.GeoJSON(),
  url: function(extent, resolution, projection) {
    return 'http://localhost:8080/geoserver/wfs?service=WFS&' +
        'version=1.1.0&request=GetFeature&typename=colegios:buf_centro&' +
        'outputFormat=application/json&srsname=EPSG:3857&' +
        'bbox=' + extent.join(',') + ',EPSG:3857';
  },
    strategy: ol.loadingstrategy.tile(ol.tilegrid.createXYZ({
    maxZoom: 19
  }))
  
});
var buf_centro = new ol.layer.Vector({
  source: buf_centro_source,
   style: new ol.style.Style({
 
    stroke: new ol.style.Stroke({
      color: 'rgba(0, 0, 0, 0)',
      width: 2
    })
  })
});
buf_centro.set('name', 'buf_centro');

var capa="";
var prue=[];

function wfs(){

	
	
var displayFeatureInfo = function(pixel) {
	var feature = map.forEachFeatureAtPixel(pixel, function(feature, layer) { 
			  
		if (layer === undefined){
			var capa="undefined";
			prue[0]=capa;
			return feature;
			
		}
		if (layer == buf_centro){//especificando la capa que es condicionas que la accion solo vaya a esa capa
				var capa= "buf_centro";
				prue[0]=capa;
			  return feature;}
		
		  });
	

 
 document.getElementById("capa").innerHTML=prue[0];
 var capa=document.getElementById('capa');
 
  //document.getElementsByName("capa").innerHTML=prue[0];
  var info = document.getElementById('info');

  
 
  if (feature) {
    //info.innerHTML =feature.get('referencia');
	var id =feature.get('codigo');
	
	document.getElementById("Getfeatureinfo").value = id;
	document.getElementById("info").innerHTML=id;
	capa="";
	prue[0]="undefined";
  } else {
	  
    info.innerHTML = '&nbsp;';
  }





};
map.on('pointermove', function(evt) {
  if (evt.dragging) {
    return;
  }
  var pixel = map.getEventPixel(evt.originalEvent);
  displayFeatureInfo(pixel);
});

map.on('click', function(evt) {
  displayFeatureInfo(evt.pixel);
});
};
////////GEOJSON CENTROS
var centros2 = new ol.layer.Vector({
	   
        source: new ol.source.Vector({
          url: 'centros.geojson',
          format: new ol.format.GeoJSON(),
		   
        }),
		style: [
          new ol.style.Style({
            image: new ol.style.Circle({
              stroke: new ol.style.Stroke({
                color: 'white'
              }),
              fill: new ol.style.Fill({
                color: '#1f6b75'
              }),
              radius: 5
            })
          })
        ]

      }); 


var influencia = new ol.layer.Vector({
	   
        source: new ol.source.Vector({
          url: 'influencia_prueba.geojson',
          format: new ol.format.GeoJSON(),
		   
        }),
		style: [
          new ol.style.Style({
              fill: new ol.style.Fill({
                color: '#1f6b75'
              }),
           
            })
          
        ]

      }); 
	 
/* map.addLayer(influencia);
map.addLayer(centros); */


//console.log(datos_centros)



///////////////////////TURFFFF

/* var pt1 = turf.point([-0.372,39.471]); //PUNTO TURF

////LECTURA DEL PUNTO EN FORMATO GEOJSON Y AÑADIDO A UNA CAPA OPENLAYERS
//turf.inside(datos_centros, polygon);

var format = new ol.format.GeoJSON();

var feature = format.readFeature(pt1, {
        featureProjection: 'EPSG:3857'
      });
 var vectorSource = new ol.source.Vector({
  format: new ol.format.GeoJSON(),
  
});


 vectorSource.addFeature(feature);
 var vectorLayer = new ol.layer.Vector({
        source: vectorSource,
        style: [
          new ol.style.Style({
            image: new ol.style.Circle({
              stroke: new ol.style.Stroke({
                color: 'white'
              }),
              fill: new ol.style.Fill({
                color: '#1f6b75'
              }),
              radius: 5
            })
          })
        ]
      });
map.addLayer(vectorLayer); */