<template>
  <div>
    <div v-if="isLoading">
      <img src="../../../public/loading.gif" />
      <h1>Loading the page</h1>
    </div>
    <div v-if="!isLoading">
      <div>
        By Type:
        <div class="types">
          <input type="checkbox" id="C" value="C" v-model="checkedType" />
          <label for="H">Credit</label>
          <input type="checkbox" id="D" value="D" v-model="checkedType" />
          <label for="H">Debit</label>
        </div>
      </div>
      <table class="table">
        <td>Total Categories: {{ totalCategories }}</td>
        <thead>
          <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in filteredCategories" :key="category.id">
            <td>{{ category.name }}</td>
            <td>{{ category.type }}</td>
            <td>
              <button
                class="btn btn-danger btn-sm"
                @click="deleteCategory(category)"
              >
                Delete
              </button>
              <button
                class="btn btn-danger btn-sm"
                @click="editCategory(category)"
              >
                Edit
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
/* eslint-disable vue/no-unused-components */
import ConfirmationDialog from "../global/ConfirmationDialog.vue";

export default {
  name: "UserCategories",
  components: {
    ConfirmationDialog,
  },
  data() {
    return {
      categories: [],
      checkedType: [],
      isLoading: true,
      categoryToDelete: null,
    };
  },
  methods: {
    loadCategories() {
      this.$axios
        .get("mycategories/" + this.$store.state.user.id)
        .then((response) => {
          this.isLoading = false;
          this.categories = response.data.data;
        })
        .catch((error) => {
          console.log("ERRRR:: ", error.response.data);
        });
    },
    deleteCategory(category) {
      this.$axios.delete(`categories/${category.id}`).then(() => {
        this.$toast.warning("Category removed", {
          duration: 1000,
        });
        this.$store.dispatch("loadCategories");
        //this.$socket.emit('user_deleted', user.id)
      });
    },
    editCategory(categories) {
      this.$router.push({
        name: "EditCategory",
        params: { id: categories.id },
      });
    },
  },
  computed: {
    filteredCategories: function () {
      return this.categories.filter((category) => {
        if (this.checkedType.length == 0) {
          return this.categories;
        }
        if (this.checkedType.includes(category.type)) {
          return category.type;
        }
      });
    },
    totalCategories() {
      return this.filteredCategories.length;
    },
  },
  mounted() {
    this.loadCategories();
  },
};
</script>

<style scoped lang="scss">
.jumbotron {
  color: white;
  background-color: brown;
}
table {
  margin-left: 50px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

td,
th {
  border: solid 0.2em lightgrey;
}

.types {
  /* Other styling... */
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}

input {
  width: 10%;
}

.edit-category {
  text-decoration: none;
  color: white;
}
</style>