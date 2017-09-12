import Vue from "vue";
import router from "../routers";
import axios from "axios";
import store from "../vuex";
import iView from "iview";
Vue.use(iView);

axios.defaults.baseURL = "/api/dashboard";

axios.interceptors.request.use(
  config => {
    iView.LoadingBar.start();
    if (store.state.token) {
      config.headers.Authorization = `Bearer ${store.state.token}`;
    }
    return config;
  },
  err => {
    iView.LoadingBar.error();
    return Promise.reject(err);
  }
);

axios.interceptors.response.use(
  config => {
    iView.LoadingBar.finish();
    return config;
  },
  err => {
    iView.LoadingBar.finish();
    return Promise.reject(err);
  }
);

export default {
  // 用户登录
  login: ({ commit }, user) => {
    var data = {
      username: user.username,
      password: user.password
    };
    axios
      .post("/login", data)
      .then(res => {
        window.localStorage.setItem("access_token", res.data.access_token);
        window.localStorage.setItem("refresh_token", res.data.refresh_token);
        window.localStorage.setItem(
          "token_expires",
          Number(window.$.now()) + Number(res.data.expires_in) * 1000
        );
        window.localStorage.setItem(
          "refresh_token_expires",
          Number(window.$.now()) + 2592000000
        );

        commit("LOGIN", res.data);
        user.obj.$Message.destroy();
        router.push("/dashboard/home");
      })
      .catch(err => {
        user.obj.$Message.destroy();
        user.obj.$Message.error(err.response.data.message);
      });
  },
  // 用户登出
  logout: ({ commit }) => {
    window.localStorage.removeItem("access_token");
    window.localStorage.removeItem("refresh_token");
    window.localStorage.removeItem("token_expires");
    window.localStorage.removeItem("refresh_token_expires");
    window.localStorage.removeItem("user");
    router.push("/dashboard/login");
  },
  // 锁定屏幕
  locked: ({ commit }) => {
    window.localStorage.removeItem("access_token");
    window.localStorage.removeItem("token_expires");
    router.push("/dashboard/locked");
  },
  // 初始化数据
  init: ({ commit, dispatch }) => {
    var access_token = window.localStorage.getItem("access_token") || "";
    var refresh_token = window.localStorage.getItem("refresh_token") || "";
    var token = {
      access_token: access_token,
      refresh_token: refresh_token
    };
    commit("LOGIN", token);

    axios
      .get("init")
      .then(res => {
        console.log(res);
        window.localStorage.setItem("user", JSON.stringify(res.data.user));
        commit("USER_INFO", res.data.user);
        commit("NAVIGATIONS", res.data.nav);
      })
      .catch(err => {
        dispatch("logout");
      });
  },
  // 解锁 刷新access_token
  unLocked: ({ commit, dispatch }, user) => {
    var refresh_token = window.localStorage.getItem("refresh_token");
    if (!refresh_token || refresh_token == "") {
      dispatch("logout");
    }
    var data = {
      id: user.id,
      password: user.password,
      refresh_token: refresh_token
    };

    axios
      .post("unlock", data)
      .then(res => {
        window.localStorage.setItem("access_token", res.data.access_token);
        window.localStorage.setItem("refresh_token", res.data.refresh_token);
        window.localStorage.setItem(
          "token_expires",
          Number(window.$.now()) + Number(res.data.expires_in) * 1000
        );
        window.localStorage.setItem(
          "refresh_token_expires",
          Number(window.$.now()) + 2592000000
        );
        commit("LOGIN", res.data);
        router.push("/dashboard/home");
      })
      .catch(err => {
        if (err.response.status == 500) {
          dispatch("logout");
        } else {
          user.obj.$Message.error(err.response.data.message);
        }
      });
  },
  // 刷新令牌
  refresh_token: ({ commit, dispatch }) => {
    var refresh_token = window.localStorage.getItem("refresh_token");
    axios
      .post("refresh", {
        refresh_token: refresh_token
      })
      .then(res => {
        window.localStorage.setItem("access_token", res.data.access_token);
        window.localStorage.setItem("refresh_token", res.data.refresh_token);
        window.localStorage.setItem(
          "token_expires",
          Number(window.$.now()) + Number(res.data.expires_in) * 1000
        );
        window.localStorage.setItem(
          "refresh_token_expires",
          Number(window.$.now()) + 2592000000
        );
        commit("LOGIN", res.data);
      })
      .catch(err => {
        dispatch("logout");
      });
  },

  // 侧边导航开合
  collapsed: ({ commit }, val) => {
    commit("COLLAPSED", val);
  },

  // 获取所有导航
  get_all_navigations: ({ commit }) => {
    axios
      .get("/navigations")
      .then(res => {
        commit("ALL_NAVIGATIONS", res.data);
      })
      .catch(res => {
        window.$Message.error("获取导航信息失败！请刷新重试");
      });
  },

  // 添加导航
  add_navigations: ({ commit }, navigations) => {
    axios
      .post("/navigations", { navigations: navigations })
      .then(res => {
        commit("ALL_NAVIGATIONS", res.data);
        window.$Message.success("新增导航成功");
      })
      .catch(err => {
        window.$Message.error("新增导航失败");
      });
  },

  // 编辑导航
  edit_navigations: ({ commit }, navigations) => {
    axios
      .put("/navigations/" + navigations.id, { navigations: navigations })
      .then(res => {
        commit("ALL_NAVIGATIONS", res.data);
        window.$Message.success("编辑导航成功");
      })
      .catch(err => {
        window.$Message.error("编辑导航失败");
      });
  },

  // 删除导航
  delete_navigations: ({ commit }, nav) => {
    axios
      .delete("/navigations/" + nav.id + "/" + nav.is_nav)
      .then(res => {
        commit("ALL_NAVIGATIONS", res.data);
        window.$Message.success("删除导航成功");
        if (nav.is_nav != 1) {
          router.push({ name: "navigations" });
        }
      })
      .catch(err => {
        window.$Message.error("删除导航失败");
      });
  },

  // 获取重定向
  get_redirects: ({ commit }, page) => {
    if (page == undefined || page == "" || page == null) {
      page = "redirect";
    }
    axios
      .get(page)
      .then(res => {
        commit("REDIRECTS", res.data);
      })
      .catch(err => {
        window.$Message.error("获取重定向列表失败，请刷新重试");
      });
  },

  // 新增重定向
  store_redirect: ({ commit,dispatch }, redirect) => {
    axios
      .post("redirect", redirect)
      .then(res => {
        dispatch('get_redirects')
        window.$Message.success("新增重定向成功");
      })
      .catch(err => {
        window.$Message.error("新增重定向失败");
      });
  },

  // 更新重定向
  update_redirect: ({ commit,dispatch }, redirect) => {
    axios
      .put("redirect/" + redirect.id, redirect)
      .then(res => {
        dispatch('get_redirects')
        window.$Message.success("修改重定向成功");
      })
      .catch(err => {
        window.$Message.error("修改重定向失败");
      });
  },

  // 删除重定向
  destroy_redirect: ({ commit,dispatch }, id) => {
    axios
      .delete("redirect/" + id)
      .then(res => {
        dispatch('get_redirects','')
        window.$Message.success("删除成功");
      })
      .catch(err => {
        window.$Message.error("删除失败");
      });
  }
};
