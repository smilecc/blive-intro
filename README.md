# Bilibili Live 简介卡生成器

### 开源说明
Bilibili Live 简介卡生成器是一个一键生成B站直播简介卡的工具。

前端使用了`Vue.js 2 + webpack 2`，模版合成使用了`PHP`。

官网：[bintro.smilec.org](http://bintro.smilec.org)

[Github](https://github.com/smilecc/blive-intro)

### 目录结构
```
src
│  App.vue                  入口模版
│  main.js                  入口JS
│  
├─assets
│      markdown.css         Markdown样式表
│      
├─components
│  │  ColorButton.vue       选项卡按钮
│  │  Demo.vue              Demo
│  │  Footerbar.vue         底部边栏
│  │  Maker.vue             生成器
│  │  Navbar.vue            导航栏
│  │  
│  └─Dialog
│          Code.vue         手动代码封装对话框
│          Tab.vue          选项卡编辑对话框
│          
├─layouts
│      FAQ.vue              FAQ页面
│      Home.vue             主页面
│      OpenSource.vue       开源说明页面
│      
├─markdown
│      faq.md               FAQ的MD文件
│      opensource.md        开源说明的MD文件
│      tutorial.md          使用教程的MD文件
│      
├─router
│      index.js             路由
│      
└─store
        index.js            Vuex的store
```

### Setup
安装依赖
```
npm install
```

打包生成
```
npm run build
```

开发
```
npm run dev
```

### Notice
模版处理部分由PHP编写，总共两个文件，这两个文件在`/dist/process`下。

所以要进行开发的话，需要在本地有一个PHP服务，并将`Document Root`设置到`YOUR_PATH/dist/process`。

### 开源许可
基于 [GPL Lisence](https://zh.wikipedia.org/wiki/GNU%E9%80%9A%E7%94%A8%E5%85%AC%E5%85%B1%E8%AE%B8%E5%8F%AF%E8%AF%81) 开源。

使用代码需要说明来源、持续开源，且需沿用GPL协议。