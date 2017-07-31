(function(h){function s(a,b,e){return"rgba("+[Math.round(a[0]+(b[0]-a[0])*e),Math.round(a[1]+(b[1]-a[1])*e),Math.round(a[2]+(b[2]-a[2])*e),a[3]+(b[3]-a[3])*e].join(",")+")"}var t=function(){},m=h.getOptions(),i=h.each,o=h.extend,w=h.format,p=h.wrap,j=h.Chart,l=h.seriesTypes,u=l.pie,k=l.column,v=HighchartsAdapter.fireEvent,x=HighchartsAdapter.inArray;o(m.lang,{drillUpText:"◁ Back to {series.name}"});m.drilldown={activeAxisLabelStyle:{cursor:"pointer",color:"#0d233a",fontWeight:"bold",textDecoration:"underline"},
activeDataLabelStyle:{cursor:"pointer",color:"#0d233a",fontWeight:"bold",textDecoration:"underline"},animation:{duration:500},drillUpButton:{position:{align:"right",x:-10,y:10}}};h.SVGRenderer.prototype.Element.prototype.fadeIn=function(a){this.attr({opacity:0.1,visibility:"inherit"}).animate({opacity:1},a||{duration:250})};j.prototype.addSeriesAsDrilldown=function(a,b){this.addSingleSeriesAsDrilldown(a,b);this.applyDrilldown()};j.prototype.addSingleSeriesAsDrilldown=function(a,b){var e=a.series,
d=e.xAxis,c=e.yAxis,f;f=a.color||e.color;var g,h=[],n=[],q;q=e.levelNumber||0;b=o({color:f},b);g=x(a,e.points);i(e.chart.series,function(a){if(a.xAxis===d&&a.yAxis===c)h.push(a),n.push(a.userOptions),a.levelNumber=a.levelNumber||0});f={levelNumber:q,seriesOptions:e.userOptions,levelSeriesOptions:n,levelSeries:h,shapeArgs:a.shapeArgs,bBox:a.graphic.getBBox(),color:f,lowerSeriesOptions:b,pointOptions:e.options.data[g],pointIndex:g,oldExtremes:{xMin:d&&d.userMin,xMax:d&&d.userMax,yMin:c&&c.userMin,yMax:c&&
c.userMax}};if(!this.drilldownLevels)this.drilldownLevels=[];this.drilldownLevels.push(f);f=f.lowerSeries=this.addSeries(b,!1);f.levelNumber=q+1;if(d)d.oldPos=d.pos,d.userMin=d.userMax=null,c.userMin=c.userMax=null;if(e.type===f.type)f.animate=f.animateDrilldown||t,f.options.animation=!0};j.prototype.applyDrilldown=function(){var a=this.drilldownLevels,b=a[a.length-1].levelNumber;i(this.drilldownLevels,function(a){a.levelNumber===b&&i(a.levelSeries,function(a){a.levelNumber===b&&a.remove(!1)})});
this.redraw();this.showDrillUpButton()};j.prototype.getDrilldownBackText=function(){var a=this.drilldownLevels[this.drilldownLevels.length-1];a.series=a.seriesOptions;return w(this.options.lang.drillUpText,a)};j.prototype.showDrillUpButton=function(){var a=this,b=this.getDrilldownBackText(),e=a.options.drilldown.drillUpButton,d,c;this.drillUpButton?this.drillUpButton.attr({text:b}).align():(c=(d=e.theme)&&d.states,this.drillUpButton=this.renderer.button(b,null,null,function(){a.drillUp()},d,c&&c.hover,
c&&c.select).attr({align:e.position.align,zIndex:9}).add().align(e.position,!1,e.relativeTo||"plotBox"))};j.prototype.drillUp=function(){for(var a=this,b=a.drilldownLevels,e=b[b.length-1].levelNumber,d=b.length,c,f,g,h,n=function(b){var d;i(a.series,function(a){a.userOptions===b&&(d=a)});d=d||a.addSeries(b,!1);if(d.type===f.type&&d.animateDrillupTo)d.animate=d.animateDrillupTo;b===c.seriesOptions&&(g=d)};d--;)if(c=b[d],c.levelNumber===e){b.pop();f=c.lowerSeries;i(c.levelSeriesOptions,n);v(a,"drillup",
{seriesOptions:c.seriesOptions});if(g.type===f.type)g.drilldownLevel=c,g.options.animation=!0,f.animateDrillupFrom&&f.animateDrillupFrom(c);f.remove(!1);if(g.xAxis)h=c.oldExtremes,g.xAxis.setExtremes(h.xMin,h.xMax,!1),g.yAxis.setExtremes(h.yMin,h.yMax,!1)}this.redraw();this.drilldownLevels.length===0?this.drillUpButton=this.drillUpButton.destroy():this.drillUpButton.attr({text:this.getDrilldownBackText()}).align()};k.prototype.supportsDrilldown=!0;k.prototype.animateDrillupTo=function(a){if(!a){var b=
this,e=b.drilldownLevel;i(this.points,function(a){a.graphic.hide();a.dataLabel&&a.dataLabel.hide();a.connector&&a.connector.hide()});setTimeout(function(){i(b.points,function(a,b){var f=b===(e&&e.pointIndex)?"show":"fadeIn",g=f==="show"?!0:void 0;a.graphic[f](g);if(a.dataLabel)a.dataLabel[f](g);if(a.connector)a.connector[f](g)})},Math.max(this.chart.options.drilldown.animation.duration-50,0));this.animate=t}};k.prototype.animateDrilldown=function(a){var b=this,e=this.chart.drilldownLevels,d=this.chart.drilldownLevels[this.chart.drilldownLevels.length-
1].shapeArgs,c=this.chart.options.drilldown.animation;if(!a)i(e,function(a){if(b.userOptions===a.lowerSeriesOptions)d=a.shapeArgs}),d.x+=this.xAxis.oldPos-this.xAxis.pos,i(this.points,function(a){a.graphic&&a.graphic.attr(d).animate(a.shapeArgs,c);a.dataLabel&&a.dataLabel.fadeIn(c)}),this.animate=null};k.prototype.animateDrillupFrom=function(a){var b=this.chart.options.drilldown.animation,e=this.group;delete this.group;i(this.points,function(d){var c=d.graphic,f=h.Color(d.color).rgba;c&&(delete d.graphic,
c.animate(a.shapeArgs,h.merge(b,{step:function(b,c){c.prop==="start"&&this.attr({fill:s(f,h.Color(a.color).rgba,c.pos)})},complete:function(){c.destroy();e&&(e=e.destroy())}})))})};u&&o(u.prototype,{supportsDrilldown:!0,animateDrillupTo:k.prototype.animateDrillupTo,animateDrillupFrom:k.prototype.animateDrillupFrom,animateDrilldown:function(a){var b=this.chart.drilldownLevels[this.chart.drilldownLevels.length-1],e=this.chart.options.drilldown.animation,d=b.shapeArgs,c=d.start,f=(d.end-c)/this.points.length,
g=h.Color(b.color).rgba;if(!a)i(this.points,function(a,b){var i=h.Color(a.color).rgba;a.graphic.attr(h.merge(d,{start:c+b*f,end:c+(b+1)*f})).animate(a.shapeArgs,h.merge(e,{step:function(a,b){b.prop==="start"&&this.attr({fill:s(g,i,b.pos)})}}))}),this.animate=null}});h.Point.prototype.doDrilldown=function(a){for(var b=this.series.chart,e=b.options.drilldown,d=(e.series||[]).length,c;d--&&!c;)e.series[d].id===this.drilldown&&(c=e.series[d]);v(b,"drilldown",{point:this,seriesOptions:c});c&&(a?b.addSingleSeriesAsDrilldown(this,
c):b.addSeriesAsDrilldown(this,c))};p(h.Point.prototype,"init",function(a,b,e,d){var c=a.call(this,b,e,d),f=b.chart,g=(a=b.xAxis&&b.xAxis.ticks[d])&&a.label;if(c.drilldown){if(h.addEvent(c,"click",function(){c.doDrilldown()}),g){if(!g._basicStyle)g._basicStyle=g.element.getAttribute("style");g.addClass("highcharts-drilldown-axis-label").css(f.options.drilldown.activeAxisLabelStyle).on("click",function(){i(g.ddPoints,function(a){a.doDrilldown&&a.doDrilldown(!0)});f.applyDrilldown()});if(!g.ddPoints)g.ddPoints=
[];g.ddPoints.push(c)}}else g&&g._basicStyle&&g.element.setAttribute("style",g._basicStyle);return c});p(h.Series.prototype,"drawDataLabels",function(a){var b=this.chart.options.drilldown.activeDataLabelStyle;a.call(this);i(this.points,function(a){if(a.drilldown&&a.dataLabel)a.dataLabel.attr({"class":"highcharts-drilldown-data-label"}).css(b).on("click",function(){a.doDrilldown()})})});var r,m=function(a){a.call(this);i(this.points,function(a){a.drilldown&&a.graphic&&a.graphic.attr({"class":"highcharts-drilldown-point"}).css({cursor:"pointer"})})};
for(r in l)l[r].prototype.supportsDrilldown&&p(l[r].prototype,"drawTracker",m)})(Highcharts);
