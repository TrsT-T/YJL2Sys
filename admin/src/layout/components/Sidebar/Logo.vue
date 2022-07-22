<template>
  <div class="sidebar-logo-container" :class="{ collapse: collapse }">
    <transition name="sidebarLogoFade">
      <router-link
        v-if="collapse"
        key="collapse"
        class="sidebar-logo-link"
        to="/"
      >
        <img src="@/assets/images/yjlogo.png" class="sidebar-logo-min" />
      </router-link>
      <router-link v-else key="expand" class="sidebar-logo-link" to="/">
        <img src="@/assets/images/yjlogo.jpg" class="sidebar-logo" />
      </router-link>
    </transition>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "SidebarLogo",
  props: {
    collapse: {
      type: Boolean,
      required: true,
    },
  },
  computed: {
    // ...mapGetters([
    //   'mainInfo'
    // ])
  },
  data() {
    return {
      // title: '管理后台',
      // logo: 'favicon.ico'
    };
  },
};
</script>

<style lang="scss" scoped>
.sidebarLogoFade-enter-active {
  transition: opacity 1.5s;
}

.sidebarLogoFade-enter,
.sidebarLogoFade-leave-to {
  opacity: 0;
}

.sidebar-logo-container {
  position: relative;
  width: 100%;
  height: 50px;
  line-height: 50px;
  background: #ffffff;
  text-align: center;
  overflow: hidden;
  border: 1px solid #409eff;

  & .sidebar-logo-link {
    height: 100%;
    width: 100%;
    & .sidebar-logo-min {
      width: 40px;
      height: 40px;
      vertical-align: middle;
      margin-left: 6px;
    }

    & .sidebar-logo {
      width: 160px;
      height: 40px;
      vertical-align: middle;
      margin-right: 12px;
    }
  }

  &.collapse {
    .sidebar-logo {
      margin-right: 0px;
    }
  }
}
</style>
