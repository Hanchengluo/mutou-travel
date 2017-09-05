require("./bootstrap");

import Vue from "vue";
import store from "./vuex";
import router from "./routers";
import App from "./App.vue";
import iView from "iview";
import VeeValidate from "vee-validate";
import "iview/dist/styles/iview.css";
import Conf from "./conf.js";

const veeConfig = {
  fieldsBagName: "veefields"
};

Vue.use(iView);
Vue.use(VeeValidate, veeConfig);

router.beforeEach((to, from, next) => {
  iView.LoadingBar.start();
  next();
});

router.afterEach((to, from, next) => {
  iView.LoadingBar.finish();
});

//过滤器
Vue.filter("avatar", function(value, style) {
  if (!style) {
    style = "";
  }
  if (Conf.use_qiniu) {
    if (!value || value == "") {
      return Conf.qiniu_base_url + "avatars/default.jpg" + "-" + style;
    }
    return Conf.qiniu_base_url + value + "-" + style;
  }
  if (!value || value == "") {
    return "/storage/avatars/default.jpg";
  }
  return "/storage/" + "-" + value;
});

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
