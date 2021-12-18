<script>
import SidebarLink from "./SidebarLink";
import { collapsed, toggleSidebar, sidebarWidth } from "./state";

export default {
  props: {},
  components: { SidebarLink },
  computed: {
    isLoggedIn() {
      return this.$store.getters.isLoggedIn;
    },
    user() {
      return this.$store.state.user;
    },
  },
  methods: {
    logout() {
      this.$store
        .dispatch("logout")
        .then(() => {
          this.$toast.success("User has logged out of the application.");
          this.$router.push({ name: "Home" });
        })
        .catch(() => {
          this.$toast.error(
            "There was a problem logging out of the application!"
          );
        });
    },
  },
  setup() {
    return { collapsed, toggleSidebar, sidebarWidth };
  },
};
</script>

<template>
  <div class="sidebar" :style="{ width: sidebarWidth }">
    <h1>
      <span v-if="collapsed">
        <div>VC</div>
      </span>
      <router-link
        class="navbar-brand col-md-3 col-lg-2 me-0 px-3"
        to="/"
        style="text-decoration: none; color: red"
        v-else
        ><i class="fab fa-vuejs"></i> VCard</router-link
      >
    </h1>

    <SidebarLink v-show="!user" to="/createvcard"
      ><i class="fas fa-arrow-circle-right"></i> Create VCard</SidebarLink
    >
    <SidebarLink v-show="!user" to="/login"
      ><i class="fas fa-arrow-circle-right"></i> Login</SidebarLink
    >

    <SidebarLink v-if="isLoggedIn" to="/createcategory"
      ><i class="fas fa-list"></i> Create Category</SidebarLink
    >
    <SidebarLink v-if="isLoggedIn" to="/mycategories">
      <i class="far fa-list-alt"></i> My Categories</SidebarLink
    >
    <SidebarLink v-if="isLoggedIn" to="/transactions"
      ><i class="fas fa-dollar-sign"></i> New Transactions</SidebarLink
    >
    <SidebarLink v-if="isLoggedIn" to="/savings"
      ><i class="fas fa-piggy-bank"></i> Savings</SidebarLink
    >
    <SidebarLink v-if="isLoggedIn" to="/mytransactions">
      <i class="fas fa-search-dollar"></i> My Transactions</SidebarLink
    >
    <SidebarLink v-if="isLoggedIn" to="/statistics">
      <i class="fas fa-chart-bar"></i> Statistics</SidebarLink
    >
    <SidebarLink
      v-if="isLoggedIn && this.$store.state.user.type == 'A'"
      to="/categories"
      ><i class="fas fa-user"></i>Default Categories</SidebarLink
    >

    <SidebarLink
      v-if="isLoggedIn && user.type == 'V'"
      :to="{
        name: 'VCardProfile',
        params: { phone_number: this.$store.state.user.id },
      }"
      ><i class="fas fa-user"></i> Profile</SidebarLink
    >
    <SidebarLink
      v-if="isLoggedIn && user.type == 'V'"
      :to="{
        name: 'VCard',
        params: { phone_number: this.$store.state.user.id },
      }"
      ><i class="far fa-address-card"></i> Manage your vCard</SidebarLink
    >

    <SidebarLink
      v-show="user"
      @click.prevent="logout"
      style="position: absolute; bottom: 40px; left: 20px"
      to="/"
      ><i class="fas fa-arrow-circle-left"></i> Logout</SidebarLink
    >

    <span
      class="collapse-icon"
      :class="{ 'rotate-180': collapsed }"
      @click="toggleSidebar"
    >
    </span>
  </div>
</template>

<style>
:root {
  --sidebar-bg-color: #7f7f7f;
  --sidebar-item-hover: #7f7faa;
  --sidebar-item-active: #7f7fd5;
}
</style>

<style scoped>
.sidebar {
  color: white;
  background-color: var(--sidebar-bg-color);
  float: left;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  bottom: 0;
  padding: 0.5em;
  transition: 0.3s ease;
  display: flex;
  flex-direction: column;
}
.sidebar h1 {
  height: 2.5em;
}
.collapse-icon {
  position: absolute;
  bottom: 0;
  padding: 0.75em;
  color: rgba(255, 255, 255, 0.7);
  transition: 0.2s linear;
}
.rotate-180 {
  transform: rotate(180deg);
  transition: 0.2s linear;
}
</style>