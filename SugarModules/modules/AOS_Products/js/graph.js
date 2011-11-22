  $(document).ready(function(){
      $.jqplot.config.enablePlugins = true;

    plot = $.jqplot('chart1', [chart_values_json, chart_values_op_json], {
      legend:{show:true, location: 'ne'},

        axes:{
            xaxis:{
                renderer:$.jqplot.DateAxisRenderer,
                tickInterval: "3 days",
                rendererOptions:{
                    tickRenderer:$.jqplot.CanvasAxisTickRenderer},
                    tickOptions:{formatString:date_format_pref_str, angle:-40},
            },
        yaxis: {
//            renderer: $.jqplot.LogAxisRenderer,
                }
        },

      cursor: {zoom:true},
    
      series:[
        {showLabel:false, color: '#0048ff', lineWidth:4, markerOptions:{style:'circle'}},
        {showLabel:false, color: '#ff0000', lineWidth:2, markerOptions:{style:'filledCircle'}},
         ]

    });

  });

