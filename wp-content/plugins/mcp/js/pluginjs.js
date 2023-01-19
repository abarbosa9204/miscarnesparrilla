function responsive_jqgrid(jqgrid) {
    jqgrid.find(".ui-jqgrid").addClass("clear-margin span12").css("width", "");
    jqgrid.find(".ui-jqgrid-view").addClass("clear-margin span12").css("width", "");
    jqgrid.find(".ui-jqgrid-view > div").eq(1).addClass("clear-margin span12").css("width", "").css("min-height", "0");
    jqgrid.find(".ui-jqgrid-view > div").eq(2).addClass("clear-margin span12").css("width", "").css("min-height", "0");
    jqgrid.find(".ui-jqgrid-sdiv").addClass("clear-margin span12").css("width", "");
    jqgrid.find(".ui-jqgrid-pager").addClass("clear-margin span12").css("width", "");
}

function setTextAreaForm(form, id){
    
    $tr = form.find("#"+id), 
    $label = $tr.children("td.CaptionTD"),
    $data = $tr.children("td.DataTD");
    $data.attr("colspan", "3");
    $data.children("textarea").css("width", "100%");
    var textAreaId = $data.children("textarea").attr('id')
    tinymce.editors = new Array();
    jQuery('#'+textAreaId).tinymce({
        mode : "none",
        theme : "modern",
        plugins: "table code",
        tools: "inserttable"
    });
}

function noHTMLTags(string){return string.replace(/(<([^>]+)>)/ig,'');}

function imageExist(url) 
{
   var img = new Image();
   img.src = url;
   return (img.height != 0)? true : false;
}

function ajaxFileUpload(id, url, elementId, oper, parentRelationShip, gridId) 
{
    if(jQuery('#'+elementId).val() != ""){
        jQuery("#loading")
        .ajaxStart(function () {
            jQuery(this).show();
        })
        .ajaxComplete(function () {
            jQuery(this).hide();
        });

        jQuery.ajaxFileUpload
        (
            {
                url: url,
                secureuri: false,
                fileElementId: elementId,
                dataType: 'json',
                data: {parentId: id, oper: oper, parentRelationShip: parentRelationShip, idFile: elementId},
                success: function (data, status) {

                    if (typeof (data.msg) != 'undefined') {
                        if (data.msg == "success") {
                            return;
                        } else {
                            alert(data.error);
                        }
                    }
                    else {
                        return alert('Failed to upload file!');
                    }
                },
                complete: function(response){
                    jQuery('#'+gridId).jqGrid().trigger('reloadGrid');
                },
                error: function (data, status, e) {
                    return alert('Failed to upload file!');
                }
            }
        ) 
    }
 }  
 
function getFormData(id, params){
    jQuery.ajax({type: "POST"
                    ,url: "admin-ajax.php"
                    ,data: params
                }).done(function(data){
                        var objJson = jQuery.parseJSON(data);
                        if(data == "[]"){
                            jQuery('#'+id).find('#oper').val("add");
                        }
                        else{
                            jQuery('#'+id).find('#oper').val("edit");
                            setformData(id, objJson);
                        }
                    });
}

function reSetformData(id){
    jQuery('#'+id).trigger("reset");
}

function setformData(id, obj){
    for(xx in obj[0]){
        if(jQuery("#"+xx))
            jQuery("#"+xx).val(obj[0][xx]);
    }
}

function disableElements(el) {
    for (var i = 0; i < el.length; i++) {
        el[i].disabled = true;

        disableElements(el[i].children);
    }
}

function enableElements(el) {
    for (var i = 0; i < el.length; i++) {
        el[i].disabled = false;

        enableElements(el[i].children);
    }
}
function miIndicador($){
    jQuery.ajax({type: "POST"
                    ,url: "admin-ajax.php"
                    ,data: {action: "action", id: "integrantes", method:"getIndicador"}
                }).done(function(data){
                        var objJson = jQuery.parseJSON(data);
                        var dataValue = parseInt(objJson.rows[0].cell[0]);
                        if(dataValue){
                            var gaugeOptions = {

                                        chart: {
                                            type: 'solidgauge'
                                        },

                                        title: null,

                                        pane: {
                                            center: ['50%', '85%'],
                                            size: '100%',
                                            startAngle: -90,
                                            endAngle: 90,
                                            background: {
                                                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                                                innerRadius: '60%',
                                                outerRadius: '100%',
                                                shape: 'arc'
                                            }
                                        },

                                        tooltip: {
                                            enabled: false
                                        },

                                        // the value axis
                                        yAxis: {
                                            stops: [
                                                [0.25, '#DF5353'], // red  
                                                [0.30, '#DDDF0D'], // yellow
                                                [0.45, '#55BF3B'] // green
                                            ],
                                            lineWidth: 0,
                                            minorTickInterval: null,
                                            tickPixelInterval: 400,
                                            tickWidth: 0,
                                            title: {
                                                y: -70
                                            },
                                            labels: {
                                                y: 16
                                            }
                                        },

                                        plotOptions: {
                                            solidgauge: {
                                                dataLabels: {
                                                    y: 5,
                                                    borderWidth: 0,
                                                    useHTML: true
                                                }
                                            }
                                        }
                                    };

                                    $('#indicador-gauge').highcharts(Highcharts.merge(gaugeOptions, {
                                        yAxis: {
                                            min: 0,
                                            max: 100,
                                            title: {
                                                text: 'Indicador de Desempeño'
                                            }
                                        },

                                        credits: {
                                            enabled: false
                                        },

                                        series: [{
                                            name: 'Indicador',
                                            data: [dataValue],
                                            dataLabels: {
                                                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                                                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                                                       '<span style="font-size:11px;color:silver">% Indicador</span></div>'
                                            },
                                            tooltip: {
                                                valueSuffix: ' % Indicador'
                                            }
                                        }]

                                    }));
                               
                        }
                    });
    
}


function miVidometro($){
    jQuery.ajax({type: "POST"
                    ,url: "admin-ajax.php"
                    ,data: {action: "action", id: "integrantes", method:"getVidometro"}
                }).done(function(data){
                        var objJson = jQuery.parseJSON(data);
                        var dataValue = parseInt(objJson.rows[0].cell[0]);
                        if(dataValue){
                            var gaugeOptions = {

                                        chart: {
                                            type: 'solidgauge'
                                        },

                                        title: null,

                                        pane: {
                                            center: ['50%', '85%'],
                                            size: '100%',
                                            startAngle: -90,
                                            endAngle: 90,
                                            background: {
                                                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                                                innerRadius: '60%',
                                                outerRadius: '100%',
                                                shape: 'arc'
                                            }
                                        },

                                        tooltip: {
                                            enabled: false
                                        },

                                        // the value axis
                                        yAxis: {
                                            stops: [
                                                [0.59, '#DF5353'], // red  
                                                [0.79, '#DDDF0D'], // yellow
                                                [1, '#55BF3B'] // green
                                            ],
                                            lineWidth: 0,
                                            minorTickInterval: null,
                                            tickPixelInterval: 400,
                                            tickWidth: 0,
                                            title: {
                                                y: -70
                                            },
                                            labels: {
                                                y: 16
                                            }
                                        },

                                        plotOptions: {
                                            solidgauge: {
                                                dataLabels: {
                                                    y: 5,
                                                    borderWidth: 0,
                                                    useHTML: true
                                                }
                                            }
                                        }
                                    };

                                    $('#vidometro-gauge').highcharts(Highcharts.merge(gaugeOptions, {
                                        yAxis: {
                                            min: 0,
                                            max: 100,
                                            title: {
                                                text: 'Vidometro'
                                            }
                                        },

                                        credits: {
                                            enabled: false
                                        },

                                        series: [{
                                            name: 'Vida',
                                            data: [dataValue],
                                            dataLabels: {
                                                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                                                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                                                       '<span style="font-size:12px;color:silver">% Vida</span></div>'
                                            },
                                            tooltip: {
                                                valueSuffix: ' % Vida'
                                            }
                                        }]

                                    }));
                               
                        }
                    });
    
}

function miPerfil($){
    jQuery.ajax({type: "POST"
                    ,url: "admin-ajax.php"
                    ,data: {action: "action", id: "integrantes", method:"getFillProfile"}
                }).done(function(data){
                        var objJson = jQuery.parseJSON(data);
                        var dataValue = parseInt(objJson.rows[0].cell[1]);
                        if(dataValue){
                            var gaugeOptions = {

                                        chart: {
                                            type: 'solidgauge'
                                        },

                                        title: null,

                                        pane: {
                                            center: ['50%', '85%'],
                                            size: '100%',
                                            startAngle: -90,
                                            endAngle: 90,
                                            background: {
                                                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                                                innerRadius: '60%',
                                                outerRadius: '100%',
                                                shape: 'arc'
                                            }
                                        },

                                        tooltip: {
                                            enabled: false
                                        },

                                        // the value axis
                                        yAxis: {
                                            stops: [
                                                [0.8, '#DF5353'], // red  
                                                [0.95, '#DDDF0D'], // yellow
                                                [1, '#55BF3B'] // green
                                            ],
                                            lineWidth: 0,
                                            minorTickInterval: null,
                                            tickPixelInterval: 400,
                                            tickWidth: 0,
                                            title: {
                                                y: -70
                                            },
                                            labels: {
                                                y: 16
                                            }
                                        },

                                        plotOptions: {
                                            solidgauge: {
                                                dataLabels: {
                                                    y: 5,
                                                    borderWidth: 0,
                                                    useHTML: true
                                                }
                                            }
                                        }
                                    };

                                    $('#perfil-gauge').highcharts(Highcharts.merge(gaugeOptions, {
                                        yAxis: {
                                            min: 0,
                                            max: 100,
                                            title: {
                                                text: 'Perfil integrante'
                                            }
                                        },

                                        credits: {
                                            enabled: false
                                        },

                                        series: [{
                                            name: 'Integrante',
                                            data: [dataValue],
                                            dataLabels: {
                                                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                                                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                                                       '<span style="font-size:12px;color:silver">% Completo</span></div>'
                                            },
                                            tooltip: {
                                                valueSuffix: ' % Completo'
                                            }
                                        }]

                                    }));
                        }
                    });
    
}
function totalPreguntas(x){
    numeroPreguntas=0;
    jQuery.ajax({type: "POST"
                    ,url: "admin-ajax.php"
                    ,data: {action: "action", id: "valorOrganizacion", method:"totalPreguntasVidometro","x":x}
                }).done(function(data){
                        data=data.replace("{}", "");
                        numeroPreguntas=data;
                        /*var objJson = jQuery.parseJSON(data);
                        if(data == "[]"){
                            jQuery('#'+id).find('#oper').val("add");
                        }
                        else{
                            jQuery('#'+id).find('#oper').val("edit");
                            setformData(id, objJson);
                        }*/
                    });
    return numeroPreguntas;                
    
}
function recargar(x,y){ 
    ejeX=x;
    ejeY=y;
    numeroPreguntas=totalPreguntas(x);       
    jQuery.ajax({type: "POST"
                    ,url: "admin-ajax.php"
        ,data: {action: "action", id: "valorOrganizacion", method:"detalleVidometro","x":ejeX,"y":ejeY}
                }).done(function(data2){
                         data2=data2.replace("{}", "");                         
                         var objJson = jQuery.parseJSON(data2);                                                 
                         var  dps = [];
                         if(objJson.length>=1){                                                                  
                         for(i=0;i<objJson[0].length;i++){                          
                             titulo =""+objJson[0][i]["label"];
                             alcanzey=objJson[0][i]["y"][1]*1;                             
                             dps.push({y:alcanzey,label:titulo});                    
                         }
                         }                         
                         var  dps2 = [];
                         if(objJson.length>=2){                         
                         for(i=0;i<objJson[1].length;i++){                          
                             titulo =""+objJson[1][i]["label"];
                             alcanzey=objJson[1][i]["y"][1]*1;                             
                             dps2.push({y:alcanzey,label:titulo});
                            
                         }
                         }                        
                        
                        
                        if(objJson.length>=1){
                        jQuery("#dialogBox").dialog({
		open: function(event,ui) {
			jQuery(".ui-widget-overlay").bind("click", function(event,ui) {         
				$("#dialogBox").dialog("close");
                                
			});
		},
		closeOnEscape: true,
		draggable: false,

		title: "Detalle",
                 width:1000,
                height:600,
        	modal: true,
		show: 600
	});
    }                       
        var chart = new CanvasJS.Chart("chartContainer3", {
	animationEnabled: true,
	exportEnabled: true,
	title: {
		text: "Resultado Por Valores de la Organización"
	},
	axisX: {
		title: "Preguntas"
	},
	axisY: {
		includeZero: true,
		title: "Calificación Vida",
		interval: 10,
		suffix: "%",
		//prefix: "%",
                maximum: 100,
	},     
	data: [{
                type: "bar",
		showInLegend: false,                
		color: "#696969",
                bevelEnabled: true, 		
		yValueFormatString: "0.##",                
                //percentFormatString: "0.##%",
		indexLabel: "{y%}",
		//legendText: "Department wise Min and Max Salary",
		//toolTipContent: "<b>{label}</b>: {y%}",
                
		dataPoints: dps
                       
	}]
});
var chart4 = new CanvasJS.Chart("chartContainer4", {
	animationEnabled: true,
	exportEnabled: true,
	title: {
		text: "Resultados Por Pregunta.",
                fontSize: 32
	},
	axisX: {
		//title: "Preguntas",
                //labelAutoFit: true,
                labelFontSize: 19,
                //prefix: "Pregunta ",
                interval: 1,
                margin: 330,                
                labelFormatter: function(e){
                                
                                x=e.value*(1);
                                x;
                                y=numeroPreguntas-x;
				return  "                                                                 Pregunta "+y;
			},
                
               
	},
	axisY: {
		includeZero: true,
		title: "Calificación Vida",
		interval: 10,
                labelFontSize: 19,
                titleFontSize:23,
		suffix: "%",
                
		//prefix: "%",
                maximum: 100,
	},
        axisX2:{
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
		title: "Resultados Por Pregunta"
	},
	data: [{
		type: "bar",
		showInLegend: false,                
		color: "#696969",
                bevelEnabled: true,                
		yValueFormatString: "0.##",
                //percentFormatString: "0.##%",
		indexLabel: "{y%}",
		//legendText: "Department wise Min and Max Salary",
		//toolTipContent: "<b>{label}</b>: {y%}",
                
		dataPoints: dps2
                       
	}]
});                       
     if(objJson.length>=1){
        chart.render();
    }
    chart.render();
    if(objJson.length>=2){
        chart4.render();
    }                       
}); 
    
}
function miHistoricoVidometro($){
    if($("#chartContainer").length>0){
    jQuery.ajax({type: "POST"
                    ,url: "admin-ajax.php"
                    ,data: {action: "action", id: "vidometros", method:"historicoVidometro"}
                }).done(function(data2){
                        data2=data2.replace("{}", "");
                        var objJson = jQuery.parseJSON(data2);                       
                        
        var chart = new CanvasJS.Chart("chartContainer",
	{
		animationEnabled: true,
		title:{
			text: "Histórico Vidómetro"
		},
                /*toolTip:{
                            enabled: false   //enable here
                        },*/
		data: [
		{       
                        
			type: "column", //change type to bar, line, area, pie, etc
			dataPoints: objJson,
                        click: function(e){
                            $(".canvasjs-chart-tooltip").hide();
                            recargar(e.dataPoint.x,e.dataPoint.y);                    
                        }
		}
		]
	});
                        
chart.render();
    
                        
                    });
    }
    
}
function miHistoricoIndicador($){
    if($("#chartContainer2").length>0){
    jQuery.ajax({type: "POST"
                    ,url: "admin-ajax.php"
                    ,data: {action: "action", id: "indicadorDesempeno", method:"historicoIndicador"}
                }).done(function(data2){
                        data2=data2.replace("{}", "");
                        var objJson = jQuery.parseJSON(data2);                       
                        
        var chart = new CanvasJS.Chart("chartContainer2",
	{
		animationEnabled: true,
		title:{
			text: "Histórico Indicadores de Desempeño"
		},
		data: [
		{      
			type: "column", //change type to bar, line, area, pie, etc
			dataPoints: objJson
		}
		]
	});
                        
chart.render();
    
                        
                    });
    }
    
}

jQuery(document).ready(function($){
    jQuery(".ui-jqgrid-titlebar").hide();    
    miVidometro($);
    miPerfil($);
    miHistoricoVidometro($);
    miIndicador($);
    miHistoricoIndicador($);
});
