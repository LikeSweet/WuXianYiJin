# 五险一金计算器

用php写动态网页实现，功能很简单，下面简述遇到的问题及解决方法。
### 问题一：每次点击按钮后会刷新页面，虽然计算了结果，但是对应的城市也相应地初始化为“北京”了。
解决：在JavaScript中用<code>window.location.href='wuxianyijin.php?area='+c</code>将地区数据传递到本文件。window.lacation.href传递数据的方式默认是GET方法，但是由于整个表单的提交方式是POST，所以改成了POST方法。(这里可以说是很误打误撞了，javascript需要将通过某种方式把数据传给PHP，由于之前没有学ajax，所以就用了这种方法，而且直接就能用_POST数组取数据了)
