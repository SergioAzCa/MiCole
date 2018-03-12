/* Copyright © 2016 Sergio Aznar Cabotá & Rodrigo Diaz & Cristina Sesé Martínez
   EMPRESA : GEOMODEL (info@geomodel.es) */
(function() {
		if (!String.prototype.trim) {
			(function() {
				var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
				String.prototype.trim = function() {
					return this.replace(rtrim, '');
				};
			})();
		}

		[].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
			if( inputEl.value.trim() !== '' ) {
				classie.add( inputEl.parentNode, 'input--filled' );
			}
			inputEl.addEventListener( 'focus', onInputFocus );
			inputEl.addEventListener( 'blur', onInputBlur );
		} );

		function onInputFocus( ev ) {
			classie.add( ev.target.parentNode, 'input--filled' );
		}

		function onInputBlur( ev ) {
			if( ev.target.value.trim() === '' ) {
				classie.remove( ev.target.parentNode, 'input--filled' );
			}
		}
	})();

	var buttons7Click = Array.prototype.slice.call( document.querySelectorAll( '#btn-click button' ) ),
				buttons9Click = Array.prototype.slice.call( document.querySelectorAll( 'button.btn-8g' ) ),
				totalButtons7Click = buttons7Click.length,
				totalButtons9Click = buttons9Click.length;

	buttons7Click.forEach( function( el, i ) { el.addEventListener( 'click', activate, false ); } );
	buttons9Click.forEach( function( el, i ) { el.addEventListener( 'click', activate, false ); } );

	function activate() {
		var self = this, activatedClass = 'btn-activated';

		if( classie.has( this, 'btn-7h' ) ) {
			// if it is the first of the two btn-7h then activatedClass = 'btn-error';
			// if it is the second then activatedClass = 'btn-success'
			activatedClass = buttons7Click.indexOf( this ) === totalButtons7Click-2 ? 'btn-error' : 'btn-success';
		}

		if( !classie.has( this, activatedClass ) ) {
			classie.add( this, activatedClass );
			setTimeout( function() { classie.remove( self, activatedClass ) }, 1000 );
		}
	}

	function dibujaLeyenda(){
        $(".leyenda").html('');
        $(".leyenda").css('display','none');
        var cont=0;
        txtCont = '';
        
        $(".listaCapasPers li.capaActiva span").each(function(){
            /*vamos acumulando el contenido de las capas activas-> imagen leyenda+texto leyenda en una variable*/
            cont=cont+1;
            /*Capa urbana*/
            if ($(this).html()== 'Parcelas Rústicas'){
                txtCont = txtCont + '<div class="elemLeyenda"><div class="imgLeyenda"><img src="http://localhost:8080/geoserver/ows?service=WMS&request=GetLegendGraphic&format=image%2Fpng&width=20&height=20&layer=pucol%3ARustica"></div><div class="txtElemLeyenda">Parcelas Rústicas</div></div>';
            }else if($(this).html()== 'Parcelas Urbanas'){
            	txtCont = txtCont + '<div class="elemLeyenda"><div class="imgLeyenda"><img src="http://localhost:8080/geoserver/ows?service=WMS&request=GetLegendGraphic&format=image%2Fpng&width=20&height=20&layer=pucol%3AUrbana"></div><div class="txtElemLeyenda">Parcelas Urbanas</div></div>';
            }
        });
        if(cont>0){
       		$(".leyenda").html('<div class="titLeyenda">Leyenda</div>'+txtCont);
            $(".leyenda").css('display','block');
        }
    }
	$(document).ready(function(){
		var altura = $( window ).height();
		var alturaBanner = $(".contBanner").height();
		var alturaSinBanner = altura - alturaBanner;
		$(".contenidoDer, .contBarra, .map").css("height", alturaSinBanner);
		if($(window).width()<767){
			$(".contenidoDer, .contBarra").css("min-height", "600px");
		}
		dibujaLeyenda();
		$("input[name='campo']").val('');
		$(".capaActiva .abreTransp").css("display", "block");
		if(!$("li.capa").hasClass("capaActiva")){
			$(this).find("div.abreTransp").css("display", "none");
		}
		$(".abreTransp").click(function(e){
			var id = $(this).attr('id');
			if ($(this).hasClass("cierraTransp")){
				$(this).removeClass("cierraTransp");
				$(this).parent().siblings("#layer"+id).slideUp();
			}else{
				$(this).addClass("cierraTransp");
				$(this).parent().siblings("#layer"+id).slideDown();
			}
			e.stopPropagation();
		});
		
		$("li.capa").click(function(){
        	var idLi = $(this).attr('id');
            $("input."+idLi).trigger( "click" );
        	if($(this).hasClass("capaActiva")){
                $(this).removeClass("capaActiva");
                $(this).children(".abreTransp").css("display","none");
                $(this).children(".abreTransp").removeClass("cierraTransp");
                $(this).next(".barraTransparencia").slideUp();
				$(this).find("div.abreTransp").css("display", "none");
            }else{
                $(this).addClass("capaActiva");
                $(this).children(".abreTransp").css("display","block");
            }
            if(!$(".btnImprimir").hasClass("btnImprimirActivo")){
            	dibujaLeyenda();	
            }
            
        });

		var abierto = true;
		$(".contenidoDesplegaHerr").rotate({ 
		   bind: 
		     { 
		        click: function(){
		            $(this).rotate({ angle:0,animateTo:360,easing: $.easing.easeInOutExpo })
		        }
		     } 
		});
		$(".contDesplegaHerr").click(function(){
			if(abierto){
				$(".contDesplegableHerr").slideUp();
				$(".contenidoDesplegaHerr").removeClass("contDesplegaHerrActivo");
				abierto=false;
			}else{
				$(".contDesplegableHerr").slideDown();
				$(".contenidoDesplegaHerr").addClass("contDesplegaHerrActivo");
				abierto=true;
			}
		});

		$(".subLista").css("display","none");
  			$("div.act_2").css("display", "none");
  			$("div.act_3").css("display", "none");
            $(".listaDespl").css("display","block");
            
  			$('.listaPpal > li').click(function(){
				if($(this).next().hasClass('listaDespl')){
					$('ul.listaDespl').slideUp('fast');
					$('ul.listaDespl').removeClass('listaDespl');
				}
				else{
					$('ul.listaDespl').slideUp('fast');
					$('ul.listaDespl').removeClass('listaDespl');
					$(this).next().slideDown('fast').addClass('listaDespl');
				}
  			});
  			$("div.pestanya").click(function(){
  				if(!$(this).hasClass("pestanyaActiva")){
  					$("div.pestanyaActiva").removeClass("pestanyaActiva");
  					$(this).addClass("pestanyaActiva");
  				}
  				var idActivo = $(this).attr("id");
  				if(idActivo=='act_1'){
  					$("div.act_1").css("display", "block");
  					$("div.act_2").css("display", "none");
  					$("div.act_3").css("display", "none");
  				}else if(idActivo=='act_2'){
  					$("div.act_1").css("display", "none");
  					$("div.act_2").css("display", "block");
  					$("div.act_3").css("display", "none");
  				}else if(idActivo=='act_3'){
  					$("div.act_1").css("display", "none");
  					$("div.act_2").css("display", "none");
  					$("div.act_3").css("display", "block");
  				}
  			});
  		$(".btnInfoImprimir").mouseenter(function(){
  			$(".informacionImprimir").css("display","block");
  			$(".contenidoImpresion").css("display", "none");
  		});
  		$(".btnInfoImprimir").mouseleave(function(){
  			$(".informacionImprimir").css("display","none");
  			$(".contenidoImpresion").css("display", "block");
  		});
  		var btnImprimir = false;
  		$(".btnImprimir").click(function(){
  			if (btnImprimir){
  				$(this).removeClass("btnImprimirActivo");
  				$(".imprimir").slideUp('fast', function(){
  					$(".leyenda").slideDown('fast');
  					dibujaLeyenda();	
  				});
  				btnImprimir = false;
  			}else{
  				// activar pestaña capas
  				$("div.pestanyaActiva").removeClass("pestanyaActiva");
  				$("div.pestanya#act_1").addClass("pestanyaActiva");
  				//activar contenido de pestaña
  				$("div.act_1").css("display", "block");
				$("div.act_2").css("display", "none");
				$("div.act_3").css("display", "none");


  				$(this).addClass("btnImprimirActivo");
  				$(".leyenda").slideUp('fast', function(){
  					$(".imprimir").slideDown('fast');
  				});
  				btnImprimir = true;
  			}
		});
		$(".btnVolver").click(function(){
			$(".btnImprimir").removeClass("btnImprimirActivo");
			$(".imprimir").slideUp('fast', function(){
				$(".leyenda").slideDown('fast');
				dibujaLeyenda();	
			});
			btnImprimir = false;
		});
		$("#popup-impri").click(function(){
			alert("kk");
			/*if(!btnImprimir){
				// activar pestaña capas
  				$("div.pestanyaActiva").removeClass("pestanyaActiva");
  				$("div.pestanya#act_1").addClass("pestanyaActiva");
  				//activar contenido de pestaña
  				$("div.act_1").css("display", "block");
				$("div.act_2").css("display", "none");
				$("div.act_3").css("display", "none");
  				$(".btnImprimir").addClass("btnImprimirActivo");
  				$(".leyenda").slideUp('fast', function(){
  					$(".imprimir").slideDown('fast');
  				});
  				btnImprimir = true;
			}
			else{
				// activar pestaña capas
  				$("div.pestanyaActiva").removeClass("pestanyaActiva");
  				$("div.pestanya#act_1").addClass("pestanyaActiva");
  				//activar contenido de pestaña
  				$("div.act_1").css("display", "block");
				$("div.act_2").css("display", "none");
				$("div.act_3").css("display", "none");
			}*/
		});

		function close_accordion_section() {
		    $('.accordion .accordion-section-title').removeClass('active');
		    $('.accordion .accordion-section-content').slideUp().removeClass('open');
		}

		$("#accordion-1").slideDown();
		$('.accordion-section-title').click(function(e) {
		    e.preventDefault();
		    // Grab current anchor value
		    var currentAttrValue = $(this).attr('href');

		    if($(e.target).is('.active')) {
		        close_accordion_section();
		    }else {
		        close_accordion_section();
		        $(this).addClass('active');
		        $('.accordion ' + currentAttrValue).slideDown().addClass('open'); 
		    }
		});
		
		$(".btnImprime").click(function(){
			im_mapa();
			$("form.manda-imprimir").submit();
		});
		
		$("select[name='select_capas']").change(function(){
			var valor = $(this).val();
			$.ajax({
				data:  {'valorCapa':valor},
				url:   'ajax/rellenaColumnasBuscador.php',
				type:  'post',
				success:  function (response) {
					$("select[name='select_columnas']").html(response);
				}
			});
		});
		var posicion = $(".contenidoDer").offset();
		var posicionTop = posicion.top;
		$(window).resize(function() {
			var posicion = $(".contenidoDer").offset();
			var posicionTop = posicion.top;
			
		});
		$(window).scroll(function() {
			var altura=$(window).scrollTop();
			if ($(window).width()<767){
				/*if(altura > (posicionTop - 2)){*/
				if(altura > 300){
					$("#to-top a i.fa-angle-down").removeClass("fa-angle-down").addClass("fa-angle-up");
				}else{
					$("#to-top a i.fa-angle-up").removeClass("fa-angle-up").addClass("fa-angle-down");
				}
			}
			if(altura > 300){
				$("#to-top").css("bottom", "50px");
			}else{
				$("#to-top").css("bottom", "13px");
			}
		});
		$('#to-top a').click(function() {
			if($('#to-top a i').hasClass("fa-angle-up")){
				$('html, body').animate({scrollTop: '0'}, 1000);
			}else if($('#to-top a i').hasClass("fa-angle-down")){
				$('html, body').animate({
					scrollTop: $(".contenidoDer").offset().top
				}, 1000);
			}
		});
		
	});