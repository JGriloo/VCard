<template>
  <div class="jumbotron">
    <div v-if="isLoading">
      <img src="../../../public/loading.gif" />
      <h1>Loading the page</h1>
    </div>
    <div v-if="!isLoading">
      <h2>Edit category: {{ defaultCategory.name }}</h2>
      <form @submit.prevent="updateDefaultCategory">
        <div class="form-group">
          <label for="inputName">Name</label>
          <input
            type="text"
            class="form-control"
            v-model="defaultCategory.name"
            name="name"
            id="inputName"
            placeholder="Name"
            required
          />
        </div>
        <div class="form-group">
          <label for="inputType">Category Type</label>
          <label>Category Type:</label>
          <input
            type="radio"
            name="category type"
            value="C"
            v-model="defaultCategory.type"
          />Credit
          <br />
          <input
            type="radio"
            name="category type"
            value="D"
            v-model="defaultCategory.type"
          />Debit
          <br />
        </div>
        <!-- <div class="form-group">
      <a class="btn btn-primary" @click.prevent="updateProduct()"
        >Update</a
      >
    </div> -->
        <p>
          <input type="submit" value="Update" />
        </p>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    id: {
      type: Number,
      default: null,
    },
  },
  data() {
    return {
      defaultCategory: {
        type: "",
        name: "",
      },
      isLoading: true,
    };
  },
  watch: {
    // beforeRouteUpdate was not fired correctly
    // Used this watcher instead to update the ID
    id: {
      immediate: true,
      handler(newValue) {
        this.loadDefaultCategory(newValue);
      },
    },
  },
  methods: {
    loadDefaultCategory(id) {
      this.$axios
        .get("defaultcategories/" + id)
        .then((response) => {
          this.isLoading = false;
          this.defaultCategory = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateDefaultCategory() {
      this.$axios
        .put(
          `defaultcategories/` + this.defaultCategory.id,
          this.defaultCategory
        )
        .then(() => {
          console.log("Default Category has been updated");
          this.$router.push("/");
        })
        .catch((error) => {
          console.log("ERRRR:: ", error.response.data);
        });
    },
  },
};
</script>