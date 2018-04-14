 <!DOCTYPE HTML> 
<html>
<head>
   <meta charset="utf-8">
   <title>五险一金计算器</title>
   <style type="text/css">
      body{
         text-align: center;;
      }
      form{
         width: 250px;
         height: 95px;
         padding: 5% 40%;
         padding-top: 1px;
         text-align: center;
      }
      li{
         padding-top: 20px;
         list-style-type: none;
      }
      input{
         text-align: center;
      }
      .div{
      	width: 500px;
      	height: 350px;
      	padding-left: 30%;
      }
      table{
      	width: 500px;
      	height: 350px;
      	text-align: center; 
      }
   </style>

   <script type="text/javascript">
      function test(){
         var a = document.getElementById('area');
         var b = a.selectedIndex;
         var c = a.options[b].value;
         if (c == '') {
         	c = 1;
         }
         window.location.href='calendar2.php?area='+c;
         console.log(c);
         }
   </script>
</head>
<body> 
<?php
   // 定义变量并默认设置为空值
   $ratio = array(array(8,2,0.2,12,0),array(8,2,0.5,7,0),array(8,2,0.2,5,0));
   $before = $after = '';
   $area = 1;
   if ($_SERVER["REQUEST_METHOD"] == "POST")
   {
      $before = test_input($_POST["before"]);
      $area = $_POST['area'];
}

   function test_input($data)
   {
      $data = trim($data);
      return $data*1;
}
   //计算扣除五险一金后的工资，a表示地区，b表示工资
   function calculate1($a,$b){
   if($a<1){
      return;
   }
   global $ratio;
   $ratio_sum = array_sum($ratio[$a-1]);
   $sum = $b-($b*$ratio_sum)/100;
   $sum = round($sum,2);
   return $sum;
}

   //计算扣除个人所得税后的工资，b表示工资，c表示税收
   function calculate2($b){
      $b -= 3500;
      $c = 0;
      if ($b>0 && $b<=1500) {
         $c = $b*0.03;
      }else if ($b>1500 && $b<=4500) {
         $c = $b*0.1 - 105;
      }else if ($b>4500 && $b<=9000) {
         $c = $b*0.2 - 555;
      }else if ($b>9000 && $b<=35000) {
         $c = $b*0.25 - 1005;
      }else if ($b>35000 && $b<=55000) {
         $c = $b*0.3 - 2755;
      }else if ($b>55000 && $b<=80000) {
         $c = $b*0.35 - 5505;
      }else if($b>800000){
         $c = $b*0.45 - 13505;
      }else{
         $c = 0;
      }
      return round(($b-$c),2);
}
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="form1"> 
   <h3>五险一金及税后工资计算器</h3>
         <li>请选择地区：
               <select name="area" id="area">
                  <option value="1" <?php if ($area == "1") {
                  	echo 'selected = "selected"';
                  }?>>北京</option>
                  <option value="2" <?php if ($area == "2") {
                  	echo 'selected = "selected"';
                  }?>>上海</option>
                  <option value="3" <?php if ($area == "3") {
                  	echo 'selected = "selected"';
                  }?>>广州</option>
               </select>
         </li>
         <li>
            税前：<input type="text" name="before" id="before" required="required" value="<?php echo $before; ?>">
            <input type="submit" name="submit" value="计算" onclick="test()">
         </li>
</form>
<?php
   $after1 = calculate1($area,$before);
   $after = calculate2($after1)+3500;
   if(!empty($before)){
   		echo "税后：$after ";
   		echo "<br>"."<br>";
    }
?>
<div class="div">
<table>
	<caption><h3>五险一金汇缴明细</h3></caption>
	<tr>
		<th scope="row">养老保险金：</th>
		<td><?php echo round(($before*$ratio[$area-1][0])/100,2); ?>（<?php echo  $ratio[$area-1][0]; ?>%）</td>
	</tr>
	<tr>
		<th scope="row">医疗保险金：</th>
		<td><?php echo round(($before*$ratio[$area-1][1])/100,2); ?>（<?php echo  $ratio[$area-1][1]; ?>%）</td>
	</tr>
	<tr>
		<th scope="row">失业保险金：</th>
		<td><?php echo round(($before*$ratio[$area-1][2])/100,2); ?>（<?php echo  $ratio[$area-1][2]; ?>%）</td>
	</tr>
	<tr>
		<th scope="row">基本住房公积金：</th>
		<td><?php echo round(($before*$ratio[$area-1][3])/100,2); ?>（<?php echo  $ratio[$area-1][3]; ?>%）</td>
	</tr>
	<tr>
		<th scope="row">补充住房公积金：</th>
		<td><?php echo round(($before*$ratio[$area-1][4])/100,2); ?>（<?php echo  $ratio[$area-1][4]; ?>%）</td>
	</tr>
	<tr>
		<th scope="row">工商保险金：</th>
	</tr>
	<tr>
		<th scope="row">生育保险金：</th>
	</tr>
	<tr>
		<th scope="row">共计支出：</th>
		<td><?php echo round(($before*array_sum($ratio[$area-1]))/100,2); ?></td>
	</tr>
	<tr>
		<th scope="row">扣除四金后月薪：</th>
		<td><?php echo $before-round(($before*array_sum($ratio[$area-1]))/100,2); ?></td>
	</tr>
	<tr>
		<th>个人所得税：</th>
		<td><?php echo ($after1 - calculate2($after1)-3500); ?></td>
	</tr>
	<tr>
		<th>税后月薪：</th>
		<td><?php echo $after; ?></td>
	</tr>
</table>
</div>
</body>