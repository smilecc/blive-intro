import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    navActiveName: 'Home',
    tabDialog: false,
    codeDialog: false,
    tabInfo: {
      id: 1,
      nowTab: null
    },
    tabs: []
  },
  mutations: {
    addTab (state, payload) { // 增加选项卡
      payload.id = state.tabInfo.id;
      state.tabs.push(payload);
      state.tabInfo.id++;
    },
    modifyTab (state, payload) { // 修改选项卡
      let tab = state.tabs.find(tab => tab.id === payload.tabid);
      tab.name = payload.tab.name;
      tab.color = payload.tab.color;
      tab.intro = payload.tab.intro;
      tab.colorname = payload.tab.colorname;
    },
    delTab (state, payload) { // 删除选项卡
      let tab = state.tabs.find(tab => tab.id === payload.tabid);
      let index = state.tabs.indexOf(tab);
      state.tabs.splice(index, 1);
    },
    loadTab (state) { // 从localStorage中加载Tab
      state.tabs = JSON.parse(window.localStorage['tabs'])
      state.tabInfo.id = state.tabs[state.tabs.length - 1].id + 1
    },
    tabDialog (state, payload) { // 选项卡对话框操作
      if (typeof(payload) == 'object') {
        state.tabDialog = payload.status;
        state.tabInfo.nowTab = state.tabs.find(tab => tab.id === payload.tabid);
      } else {
        state.tabDialog = payload;
        state.tabInfo.nowTab = null;
      }
    },
    codeDialog (state, payload) {
      state.codeDialog = payload;
    },
    navbarActive (state, payload) {
      state.navActiveName = payload;
    }
  }
})