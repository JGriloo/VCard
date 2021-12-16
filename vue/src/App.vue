<<<<<<< HEAD
<template>
  <div>
    <Sidebar />
    <div :style="{ 'margin-left': sidebarWidth }">
      <router-view />
    </div>
  </div>
</template>



<script>
import Sidebar from "@/components/sidebar/Sidebar";
import { sidebarWidth } from "@/components/sidebar/state";

export default {
  name: "RootComponent",
  components: { Sidebar },
  setup() {
    return { sidebarWidth };
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    userId() {
      return this.$store.state.user ? this.$store.state.user.id : -1;
    },
    userName() {
      return this.$store.state.user ? this.$store.state.user.name : "";
    },
    userPhotoUrl() {
      let urlPhoto = this.$store.state.user
        ? this.$store.state.user.photo_url
        : null;
      return urlPhoto
        ? this.$serverUrl + "/storage/fotos/" + urlPhoto
        : "img/avatar-none.png";
    },
    isLoggedIn() {
      return this.$store.getters["isLoggedIn"];
    },
    vcard() {
      return this.$store.state.vcard;
    },
  },
  methods: {
    refresh() {
      this.$store.dispatch("refresh");
    },
  },
  mounted() {
    this.$store.dispatch("restoreToken").then((token) => {
      if (token) {
        this.$store.dispatch("refresh");
      }
    });
    // this.$axios.get('users/' + this.userId + '/projects/inprogress')
    //   .then((response) => {
    //     this.workInProgressProjects = response.data.data
    //   })
    //   .catch((error) => {
    //     console.log(error)
    //   })
  },
};
</script>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
#nav {
  padding: 30px;
}
#nav a {
  font-weight: bold;
  color: #2c3e50;
}
#nav a.router-link-exact-active {
  color: #42b983;
}
=======
<template>
  <div>
    <Sidebar />
    <div :style="{ 'margin-left': sidebarWidth }">
      <router-view />
    </div>
  </div>
</template>



<script>
import Sidebar from "@/components/sidebar/Sidebar";
import { sidebarWidth } from "@/components/sidebar/state";

export default {
  name: "RootComponent",
  components: { Sidebar },
  setup() {
    return { sidebarWidth };
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    userId() {
      return this.$store.state.user ? this.$store.state.user.id : -1;
    },
    userName() {
      return this.$store.state.user ? this.$store.state.user.name : "";
    },
    userPhotoUrl() {
      let urlPhoto = this.$store.state.user
        ? this.$store.state.user.photo_url
        : null;
      return urlPhoto
        ? this.$serverUrl + "/storage/fotos/" + urlPhoto
        : "img/avatar-none.png";
    },
    isLoggedIn() {
      return this.$store.getters["isLoggedIn"];
    },
    vcard() {
      return this.$store.state.vcard;
    },
  },
  methods: {
    refresh() {
      this.$store.dispatch("refresh");
    },
  },
  mounted() {
    this.$store.dispatch("restoreToken").then((token) => {
      if (token) {
        this.$store.dispatch("refresh");
      }
    });
    // this.$axios.get('users/' + this.userId + '/projects/inprogress')
    //   .then((response) => {
    //     this.workInProgressProjects = response.data.data
    //   })
    //   .catch((error) => {
    //     console.log(error)
    //   })
  },
};
</script>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
#nav {
  padding: 30px;
}
#nav a {
  font-weight: bold;
  color: #2c3e50;
}
#nav a.router-link-exact-active {
  color: #42b983;
}
>>>>>>> 2b051026b75e280f09607fa3e9db532d3067424a
</style>