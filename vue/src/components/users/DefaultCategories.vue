<template>
  <div class="jumbotron">
    <div v-if="isLoading">
      <img src="../../../public/loading.gif" />
      <h1>Loading the page</h1>
    </div>
    <div v-if="!isLoading">
      <h2 style="color: blue;">Edit default categories</h2>
      <h3>D = Debit | C = Credit</h3>
      <button
        type="button"
        class="btn btn-primary px-5"
        style="background-color: blue; border-radius: 5px; width: 150px;"
        @click="addCategory"
      ><i class="fas fa-plus"></i> Add Category</button>
      <form>
        <div class="form-group">
            <li style="list-style-type: none;" v-for="category in categories" :key="category.id">
                <input :id="category.id" :value="category" name="category" type="checkbox" style="position: relative; right: -170px;">
                <button
              class="btn btn-xs btn-light"
              @click="updateDefaultCategories(category)"
              style="background-color: red; position: relative; left: 450px; top: -43px; border-radius: 5px;"
            ><i class="fas fa-trash-alt"></i>
            </button>
                <label :for="category.id" style="position: relative; top: -42px; color: black; font-size: 1em;"><i class="fas fa-long-arrow-alt-right"></i> {{ category.name }} | {{ category.type }}</label>
                
            </li>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  name: "DefaultCategories",
  data() {
    return {
      categories: [],
      defaultCategories: [],
      isLoading: true,
    };
  },
  methods: {
    loadCategories() {
      this.$axios
        .get("/categories/default")
        .then((response) => {
          this.isLoading = false;
          this.categories = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateDefaultCategories(category) {
      this.$axios
        .delete(`/categories/default/${category.id}`)
        .then(() => {
          this.$toast.success("Default Categories removed", {
            duration: 1000,
          });
          console.log("Default Categories have been updated");
          
          this.loadCategories()
        })
        .catch((error) => {
            this.$toast.error("An error occurred.")
            console.log(this.defaultCategories);
          console.log("ERRRR:: ", error.response.data);
        });
    },
    addCategory() {
        this.$router.push({name: 'AddCategory'})
    }
  },
  mounted () {
      this.loadCategories()
  }
};
</script>