# 五险一金计算器

用php写动态网页实现，功能很简单，下面简述遇到的问题及解决方法。
### 问题一：每次点击按钮后会刷新页面，虽然计算了结果，但是对应的城市也相应地初始化为“北京”了。
解决：在JavaScript中用<code>window.location.href='calendar2'</code>
