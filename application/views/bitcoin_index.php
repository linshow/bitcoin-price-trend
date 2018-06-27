<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to bitcoin</title>
  
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <script src="http://d3js.org/d3.v3.min.js"></script>

	
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,600,200italic,600italic&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
<script src="http://phuonghuynh.github.io/js/bower_components/jquery/dist/jquery.min.js"></script>
<script src="http://phuonghuynh.github.io/js/bower_components/d3/d3.min.js"></script>
<script src="http://phuonghuynh.github.io/js/bower_components/d3-transform/src/d3-transform.js"></script>
<script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/extarray.js"></script>
<script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/misc.js"></script>
<script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/micro-observer.js"></script>
<script src="http://phuonghuynh.github.io/js/bower_components/microplugin/src/microplugin.js"></script>
<script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/bubble-chart.js"></script>
<script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/plugins/central-click/central-click.js"></script>
<script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/plugins/lines/lines.js"></script>

     
   
      
             
    

        <style>
		.example{
			background-color: #f1f1f1;
    		padding: 0.01em 16px;
    		margin: 20px 0;
    		box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
			}	
		
		.axis path,
        .axis line {
            fill: none;
            stroke: #F2E8DE;
            shape-rendering: crispEdges;
            margin-left:100px;
        }
        .line {
            fill: none;
            stroke: #FCAD62;
            stroke-width: 1.5px;
            margin-left:100px;
        }
        text{
            fill:#999;
        }
        .inner_line line {
            fill: none;
            stroke:#E7E7E7;
            shape-rendering: crispEdges;
        }
        .MyCircle {
            fill: #FCAD62;
        }
        .bubbleChart {
            min-width: 100px;
            max-width: 300px;
            height: 300px;
            margin:auto;
            }
        .bubbleChart svg{
             background: #000000;
            }
	</style>

    


           

 
</head>

<body>

<!-- <body style="background: #000000"> -->







<nav class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="">Bitcoin!</a>
        </div>
		<div class="collapse navbar-collapse">
              <ul class="nav navbar-nav navbar-right">
              <li><a href="">買賣預警</a></li>
			  <li><a href="">趨勢圖</a></li>
              <li><a href="">登入帳號</a></li>
              
              </ul>
            </div>
	</div>
</nav>

<div class="container">
<div class="example">
<table class="table table-striped" id="tb1">
        <thead>
          <tr>
            <th><h4>編號</h4></th>
            <th><h4>時間</h4></th>                   
            <th><h4>量</h4></th>
            <th><h4>價格</h4></th>
			<th><h4>總價</h4></th> 
			<th><h4>FillType</h4></th>
			<th><h4>OrderType</h4></th> 
          </tr>
        </thead>
        <tbody>
		<?php if(isset($record)) : foreach($record as $row) : ?>
          <tr>
            <td><?php echo $row->Id ?></td>
            <td id="time"><?php echo $row->TimeStamp ?></td>
            <td><?php echo $row->Quantity ?></td>
			<td id="price"><?php echo $row->Price ?></td>
			<td><?php echo $row->Total ?></td>
			<td><?php echo $row->FillType ?></td>
			<td><?php echo $row->OrderType ?></td>
         </tr>
                <?php endforeach; ?>
              </tbody>
              </table>
			  </div>
			  </div>
        <?php endif ; ?>



        

<div class="bubbleChart"></div>
<div><svg class="svg"></svg> </div> 
<script >

	var data=[<?php if(isset($record)) : foreach($record as $row) : ?> 	
		<?php 

			$dd=strtotime($row->TimeStamp);
			echo "{time: \"".date("Y-m-d H:i:s", $dd).'",';
			echo "price: ".$row->Price."}";
			if (!($row === end($record)))
				echo ","?> <?php endforeach; ?> <?php endif ; ?>];
			
			
    var margin = {top: 20, right: 20, bottom: 30, left: 50},
        padding = {top: 60, right: 60, bottom: 60, left: 60},
        width = 590 - margin.left - margin.right,
        height = 300 - margin.top - margin.bottom;

	var svg = d3.select("body").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");		
		

    // var parseDate = d3.time.format.utc("%Y-%m-%d %H:%M:%S");
	 var parseDate = d3.time.format("%Y-%m-%d %H:%M:%S").parse;
    var x = d3.time.scale()
             .range([0, width]);
 
    var y = d3.scale.linear()
             .range([height, 0]);
 
     var xAxis = d3.svg.axis()
             .scale(x)
             .orient("bottom")
             .ticks(10)
             .tickFormat(d3.time.format("%m-%d"));
  
     var yAxis = d3.svg.axis()
             .scale(y)
             .orient("left");
             

	var line = d3.svg.line()
                .x(function(d) { return x(d.time); })
                .y(function(d) { return y(d.price); });


    data.forEach(function(d){
        d.time = parseDate(d.time);
        d.price = +d.price; 

    })

    x.domain([data[0].time, data[data.length - 1].time]);
	// x.domain(d3.extent(data, function(d) { return d.time; }));
    y.domain(d3.extent(data, function(d) { return d.price; }));

        svg.append("g")
                .attr("class", "x axis")
                .attr("transform", "translate(0," + height + ")")
                .call(xAxis);
        svg.append("g")
                .attr("class", "y axis")
                .call(yAxis)
                .append("text")
                .attr("transform", "rotate(0)")
                .attr("y", 25)
                .attr("x", 75)
                .attr("dy", ".71em")
                .style("text-anchor", "end")
                // .text("我的數據");

	var yInner = d3.svg.axis()
                .scale(y)
                .tickSize(-width,0,0)
                .tickFormat("")
                .orient("left")
                .ticks(5);

        //加縱軸網格線
    var yInnerBar=svg.append("g")
                .attr("class", "inner_line")
                .attr("transform", "translate(0,-25)")
                .call(yInner);
	svg.append("path")
                .datum(data)
                .attr("class", "line")
                .attr("d", line)
                .attr("opacity", 0)
                .transition()
                .duration(2000)
                .attr("opacity", 1);

    var points = svg.selectAll("MyCircle")
                .data(data)
                .enter()
                .append("circle")
                .attr("class","MyCircle")
                .attr("transform","translate(0,0)")
                .attr("r", 3)
                .attr("opacity", 0)
                .transition()
                .duration(2000)
                .attr("cx", function(d){ return x(d.time); })
                .attr("opacity", 1)
                .attr("cy", function(d){ return y(d.price); });

              
</script>


        <?php
        if(isset($result)){
           
            echo $result;

          }else{
            echo ('error');
        }
        if(isset($fill)){
           
            echo $fill;
            
          }else{
            echo ('error');
        }
        ?>

           <?php
            echo $fill;
        ?>

        
       <!-- bubble chart -->
           <script>
                $(document).ready(function () {
                    
                var bubbleChart = new d3.svg.BubbleChart({
                    supportResponsive: true,
                    //container: => use @default
                    size: 300,
                    //viewBoxSize: => use @default
                    innerRadius: 200 / 3.5,
                    //outerRadius: => use @default
                    radiusMin: 50,
                    //radiusMax: use @default
                    //intersectDelta: use @default
                    //intersectInc: use @default
                    //circleColor: use @default

                    data: {
                    items: [
                        {text: "FILL", count: "<?php echo $fill ?>"},
                        {text: "PARTIAL", count: "<?php echo $result ?>"},
                        
                    ],
                    eval: function (item) {return item.count;},
                    classed: function (item) {return item.text.split(" ").join("");}
                    },
                    plugins: [
                    {
                        name: "central-click",
                        options: {
                        text: "(See more detail)",
                        style: {
                            "font-size": "12px",
                            "font-style": "italic",
                            "font-family": "Source Sans Pro, sans-serif",
                            //"font-weight": "700",
                            "text-anchor": "middle",
                            "fill": "white"
                        },
                        attr: {dy: "65px"},
                        centralClick: function() {
                            alert("Here is more details!!");
                        }
                        }
                    },
                    {
                        name: "lines",
                        options: {
                        format: [
                            {// Line #0
                            textField: "count",
                            classed: {count: true},
                            style: {
                                "font-size": "28px",
                                "font-family": "Source Sans Pro, sans-serif",
                                "text-anchor": "middle",
                                fill: "white"
                            },
                            attr: {
                                dy: "0px",
                                x: function (d) {return d.cx;},
                                y: function (d) {return d.cy;}
                            }
                            },
                            {// Line #1
                            textField: "text",
                            classed: {text: true},
                            style: {
                                "font-size": "14px",
                                "font-family": "Source Sans Pro, sans-serif",
                                "text-anchor": "middle",
                                fill: "white"
                            },
                            attr: {
                                dy: "20px",
                                x: function (d) {return d.cx;},
                                y: function (d) {return d.cy;}
                            }
                            }
                        ],
                        centralFormat: [
                            {// Line #0
                            style: {"font-size": "50px"},
                            attr: {}
                            },
                            {// Line #1
                            style: {"font-size": "30px"},
                            attr: {dy: "40px"}
                            }
                        ]
                        }
                    }]
                });
                });
           </script>
  
  
		
</body>
</html>