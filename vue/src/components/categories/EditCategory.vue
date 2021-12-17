<template>
  <div class="jumbotron">
    <div v-if="isLoading">
      <img src="../../../public/loading.gif" />
      <h1>Loading the page</h1>
    </div>
    <div v-if="!isLoading">
      <h2>Edit category: {{ category.name }}</h2>
      <form @submit.prevent="updateCategory">
        <div class="form-group">
          <label for="inputName">Name</label>
          <input
            type="text"
            class="form-control"
            v-model="category.name"
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
            v-model="category.type"
          />Credit
          <br />
          <input
            type="radio"
            name="category type"
            value="D"
            v-model="category.type"
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
      category: {
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
        this.loadCategory(newValue);
      },
    },
  },
  methods: {
    loadCategory(id) {
      this.$axios
        .get("categories/" + id)
        .then((response) => {
          this.isLoading = false;
          this.category = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateCategory() {
      this.$axios
        .put(`categories/` + this.category.id, this.category)
        .then(() => {
          this.$toast.warning("Category updated", {
            duration: 1000,
          });
          console.log("Category has been updated");
          this.$socket.emit("updateCategory", this.category);
          this.$router.push("/");
        })
        .catch((error) => {
          console.log("ERRRR:: ", error.response.data);
        });
    },
  },
};
</script>