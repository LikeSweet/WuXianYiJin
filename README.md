# 五险一金计算器

用php写动态网页实现，功能很简单，下面简述遇到的问题及解决方法。
### 每次点击按钮后会刷新页面，虽然计算了结果，但是对应的城市也相应地初始化为“北京”。
解决：在JavaScript中用<code>window.location.href='wuxianyijin.php?area='+c</code>将地区数据传递到本文件。window.lacation.href传递数据的方式默认是GET方法，但是由于整个表单的提交方式是POST，所以改成了POST方法。(这里可以说是很误打误撞了，javascript需要将通过某种方式把数据传给PHP，由于之前没有学ajax，所以就用了这种方法，而且直接就能用_POST数组取数据了)

### 添加绘制税收所占工资比例的图表
由于之前水平限制，导致代码并不是很友好，所以再另外写个页面实现这个功能、大致用到了Ajax、json、和Highcharts。关键代码如下：
<pre><code>
function a(){
			var xmlhttp = new XMLHttpRequest();
	         xmlhttp.onreadystatechange=function(){
	            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	            var b = xmlhttp.responseText;
	            b = JSON.parse(b);
	            alert(b[0]);
	               var chart = {
				       plotBackgroundColor: null,
				       plotBorderWidth: null,
				       plotShadow: false
				   };
				   var title = {
				      text: '税前工资去向'   
				   };      
				   var tooltip = {
				      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				   };
				   var plotOptions = {
				      pie: {
				         allowPointSelect: true,
				         cursor: 'pointer',
				         dataLabels: {
				            enabled: true,
				            format: '<b>{point.name}%</b>: {point.percentage:.1f} %',
				            style: {
				               color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
				            }
				         }
				      }
				   };
				   var series= [{
				      type: 'pie',
				      name: '所占比例',
				      data: [
					         ['养老保险金',   b[0]],
					         ['医疗保险金',       b[1]],
					         {
					            name: '失业保险金',
					            y: b[2],
					            sliced: true,
					            selected: true
					         },
					         ['基本住房公积金',    b[3]],
					         ['补充住房公积金',     b[4]],
					         ['Others',   100-b[0]-b[1]-b[2]-b[3]-b[4]]
					      ]
				   }];     
				   var json = {};   
				   json.chart = chart; 
				   json.title = title;     
				   json.tooltip = tooltip;  
				   json.series = series;
				   json.plotOptions = plotOptions;
				   $('#container').highcharts(json);  
	            }
	         }
	         xmlhttp.open('POST','./rate.php');
	         xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	         xmlhttp.send("index=1");
		}
</code></pre>
