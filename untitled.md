# 基本概念与准备

下图为我们要学习研究的七层简化为网络五层模型

![](.gitbook/assets/image%20%2829%29.png)

![](.gitbook/assets/image%20%2822%29.png)

## 项目准备

* Java环境
* IDEA
* Tomcat

## 新建项目\(新建Tomcat的Hello world项目\)

###  1。IDEA新建project

###  2。选择empty project

![](.gitbook/assets/image%20%2812%29.png)

###  3。选择路径，起名network

###  4。新建完成后，在根目录右键出现菜单，点击 “Add FrameWork Support”，选择WebService

##  将项目添加进Tomcat

###  1。选择Edit Configuration

![](.gitbook/assets/image%20%2825%29.png)

###  2。点击左上角加号，添加本地Tomcat服务

![](.gitbook/assets/image%20%2823%29.png)



###  3。进行配置

![&#x914D;&#x7F6E;&#x7AEF;&#x53E3;](.gitbook/assets/image%20%2837%29.png)

![&#x6DFB;&#x52A0;&#x65B0;&#x9879;&#x76EE;&#x8FDB;Tomcat](.gitbook/assets/image%20%2839%29.png)

![&#x8BBE;&#x7F6E;&#x672C;&#x9879;&#x76EE;&#x7684;&#x8BBF;&#x95EE;&#x8DEF;&#x5F84;](.gitbook/assets/image%20%2831%29.png)

> 注意，此处/hello对应的是Java项目中Web项目根目录，所有，要想访问到test.html，只需输入 http://localhost:9999/hello/test.html

![](.gitbook/assets/image%20%2817%29.png)

