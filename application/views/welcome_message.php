<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<script src="https://d3js.org/d3.v4.min.js"></script>
	<script>
  var data = [
  {x: 0,y: 1.89}, 
  {x: 1,y: 2.77}, 
  {x: 2,y: 0.86}, 
  {x: 3,y: 3.45}, 
  {x: 4,y: 4.13}, 
  {x: 5,y: 3.59}, 
  {x: 6,y: 2.33}, 
  {x: 7,y: 3.79}, 
  {x: 8,y: 2.61}, 
  {x: 9,y: 2.15}
  ];

  var width = 240,
    height = 120;

  var s = d3.select('#s');

  s.attr({
    'width': '300',
    'height': '180'
  }).style({
    'border': '1px dotted #aaa'
  });

  var scaleX = d3.scale.linear()
    .range([0, width])
    .domain([0, 9]);

  var scaleY = d3.scale.linear()
    .range([height, 0])
    .domain([0, 5]); 

  var line = d3.svg.line()
    .x(function(d) {
      return scaleX(d.x);
    }).y(function(d) {
      return scaleY(d.y);
    });

  var axisX = d3.svg.axis()
    .scale(scaleX)
    .ticks(10);

  var axisY = d3.svg.axis()
    .scale(scaleY)
    .ticks(10);

  s.append('path')
    .attr({
      'd': line(data),
      'stroke': '#09c',
      'fill': 'none'
    });

  s.append('g')
   .call(axisX);    //call axisX

  s.append('g')
   .call(axisY);    //call axisY
  </script>
</head>
<body>
<svg id="s"></svg>



</body>
</html>