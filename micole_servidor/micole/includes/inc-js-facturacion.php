<script type="text/javascript">
    $(document).ready(function(){
        $("select[name='opcion']").change(function(){
            $(".cargaResultados").html("");
            if($(this).val()=='1'){
                $(".cargaFacturas").prop("disabled", true);
                $("#txt-help-block").html("Introduce la fecha inicial y final del periodo y pincha en 'obtener facturas'.");
                $(".cargaVariables").html("<div class='form-group'><label class='col-sm-3 control-label col-lg-3'>Fecha comienzo</label><div class='col-sm-6'><input class='form-control datepicker porFecha' name='inicio' type='text' autocomplete='off' placeholder='Fecha comienzo'></div></div><div class='form-group'><label class='col-sm-3 control-label col-lg-3'>Fecha fin</label><div class='col-sm-6'><input class='form-control datepicker porFecha' name='fin' type='text' autocomplete='off' placeholder='Fecha fin'></div></div>");
                var dateToday = new Date();
                $('.datepicker').datepicker({
                    dateFormat: "dd/mm/yy",
                    dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ],
                    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
                    dayNamesShort: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sáb" ],
                    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
                    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
                    firstDay: 1,
                    changeYear: true,
                    changeMonth: true,
                    minDate: new Date(2016, 8 - 1, 1),
                    maxDate: dateToday
                });
            }else if($(this).val()=='2'){
                $(".cargaFacturas").prop("disabled", true);
                $("#txt-help-block").html("Introduce el identificador de las facturas inicial y final y pincha en 'obtener facturas'.");
                $(".cargaVariables").html("<div class='form-group'>"+
                                                "<label class='col-sm-3 control-label'>Factura inicial</label>"+
                                                "<div class='col-sm-6'>"+
                                                    "<select class='form-control mb-10' name='inicio'>"+
                                                        "<option value='0' selected disabled>Selecciona un valor</option>"+
                                                    "</select>"+
                                                "</div>"+
                                            "</div>"+
                                            "<div class='form-group'>"+
                                                "<label class='col-sm-3 control-label'>Factura final</label>"+
                                                "<div class='col-sm-6'>"+
                                                    "<select class='form-control mb-10' name='fin'>"+
                                                        "<option value='0' selected disabled>Selecciona un valor</option>"+
                                                    "</select>"+
                                                "</div>"+
                                            "</div>");
                //AJAX carga opciones SELECTS
                $.ajax({
                    url: "ajax/carga-facturas.php",
                    type: 'POST',
                    data: {
                        "opciones"  : "carga",
                        "tipo"      : "inicio"
                    },
                    cache: false,
                    success: function(response) {
                        var jsonData = JSON.parse(response);
                        
                        var txt = "<option value='0' selected disabled>Selecciona un valor</option>";
                        for(i=0; i < jsonData.length; i++){
                            txt += "<option value='"+jsonData[i]['id']+"'>"+jsonData[i]['fecha']+"</option>";
                        }
                        $("select[name='inicio']").html(txt);
                    }
                });
            }else if($(this).val()=='3'){
                $("#txt-help-block").html("Pincha en 'obtener facturas'.");
                $(".cargaFacturas").prop("disabled", false);
                $(".cargaVariables").html("");
            }
        });
        $(".cargaFacturas").click(function(){
            var opcion = $("select[name='opcion']").val();
            if(opcion == '1'){
                var inicio = $("input[name='inicio']").val();
                var fin = $("input[name='fin']").val();
            }else if(opcion == '2'){
                var inicio = $("select[name='inicio']").val();
                var fin = $("select[name='fin']").val();
            }else if(opcion == '3'){
                var inicio = 0;
                var fin = 0;
            }
            $(".cargaResultados").html("");
            
            $.ajax({
                url: "ajax/carga-facturas.php",
                type: 'GET',
                data: {
                    "opciones"  : "imprime",
                    "tipo"      : opcion,
                    "inicio"    : inicio,
                    "fin"       : fin
                },
                cache: false,
                success: function(response) {
                    var jsonData = JSON.parse(response);
                    console.log(jsonData);
                    var txt = "<div class='table-responsive'>"+
                                "<table class='table  table-hover general-table'>"+
                                    "<thead>"+
                                        "<tr>"+
                                            "<th>Id.</th>"+
                                            "<th>Pedido</th>"+
                                            "<th>Fecha emisión</th>"+
                                            "<th>Nombre Cliente</th>"+
                                            "<th>Subtotal</th>"+
                                            "<th>I.V.A.</th>"+
                                            "<th>TOTAL</th>"+
                                            "<th>ver</th>"+
                                        "</tr>"+
                                    "</thead>"+
                                    "<tbody>";
                    for(i=0; i<jsonData.length; i++){
                        txt += "<tr>"+
                                    "<td>"+jsonData[i]['id']+"</td>"+
                                    "<td><a href='detalles-pedido.php?p="+jsonData[i]['id']+"' target='_blank'>Ped. Nº"+jsonData[i]['pedido']+"</a></td>"+
                                    "<td>"+jsonData[i]['fecha']+"</td>"+
                                    "<td>"+jsonData[i]['cliente']+"</td>"+
                                    "<td>"+jsonData[i]['subtotal']+"€</td>"+
                                    "<td>"+jsonData[i]['iva']+"€</td>"+
                                    "<td>"+jsonData[i]['total']+"€</td>"+
                                    "<td><a href='genera-factura.php?p="+jsonData[i]['id']+"' target='_blank'><i class='fa fa-download'></i></a></td>"+
                                "</tr>";
                    }
                    txt += "</tbody>"+
                        "</table>"+
                    "</div>";
                    
                    //Meto la posibilidad de adjuntar un .csv
                    txt += "<a href='libs/exporta-factura.php?tipo="+opcion+"&ini="+inicio+"&fin="+fin+"'>"+
                            "<button type='button' class='btn btn-info btn-success'>"+
                                "<i class='fa fa-file-excel-o'></i> Exportar como CSV"+
                            "</button></a>";                            
                    $(".cargaResultados").html(txt);
                }
            });
        });
    });
    $(document).on("change", "select[name='inicio']", function(){
        $(".cargaFacturas").prop("disabled", true);
        var inicio = $(this).val();
        $.ajax({
            url: "ajax/carga-facturas.php",
            type: 'POST',
            data: {
                "opciones"  : "carga",
                "tipo"      : "fin",
                "inicio"    : inicio
            },
            cache: false,
            success: function(response) {
                var jsonData = JSON.parse(response);
                var txt = "<option value='0' selected disabled>Selecciona un valor</option>";
                for(i=0; i < jsonData.length; i++){
                    txt += "<option value='"+jsonData[i]['id']+"'>"+jsonData[i]['fecha']+"</option>";
                }
                $("select[name='fin']").html(txt);
            }
        });
    });
    $(document).on("change", "select[name='fin']", function(){
        $(".cargaFacturas").prop("disabled", false);
    });
    $(document).on("change", ".porFecha", function(){
        var enBlanco = false;
        $(".porFecha").each(function(){
            if($(this).val() ==''){
                enBlanco = true;
            }
        });
        if(!enBlanco){
            $(".cargaFacturas").prop("disabled", false);
        }
    });
</script>