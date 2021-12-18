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
      <button
        type="button"
        class="btn btn-primary px-5"
        style="background-color: blue; border-radius: 5px; width: 150px"
        @click="addCategory"
      >
        <i class="fas fa-plus"></i> Add Category
      </button>
      <hr>
      <table class="table">
        <td>Total Default Categories: {{ totalDefaultCategories }}</td>
        <thead>
          <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="defaultCategory in filteredDefaultCategories"
            :key="defaultCategory.id"
          >
            <td>{{ defaultCategory.name }}</td>
            <td>{{ defaultCategory.type }}</td>
            <td>
              <button
                class="btn btn-danger btn-sm"
                @click="deleteDefaultCategory(defaultCategory)"
                style="background-color: red; border-radius: 5px;"
              ><i class="fas fa-trash-alt"></i>
                Delete
              </button>
              <button
                class="btn btn-danger btn-sm"
                @click="editDefaultCategory(defaultCategory)"
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
  name: "Categories",
  components: {
    ConfirmationDialog,
  },
  data() {
    return {
      defaultCategories: [],
      checkedType: [],
      isLoading: true,
      categoryToDelete: null,
    };
  },
  methods: {
    loadDefaultCategories() {
      this.$axios
        .get("defaultcategories")
        .then((response) => {
          this.isLoading = false;
          this.defaultCategories = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteDefaultCategory(defaultCategory) {
      this.$axios.delete(`defaultcategories/${defaultCategory.id}`).then(() => {
        this.$toast.warning("Category removed", {
          duration: 1000,
        });
        this.$store.dispatch("loadDefaultCategories");
        //this.$socket.emit('user_deleted', user.id)
      });
    },
    editDefaultCategory(defaultCategory) {
      this.$router.push({
        name: "EditDefaultCategory",
        params: { id: defaultCategory.id },
      });
    },
    addCategory() {
        this.$router.push({name: 'AddCategory'})
    },
  },
  computed: {
    filteredDefaultCategories: function () {
      return this.defaultCategories.filter((defaultCategory) => {
        if (this.checkedType.length == 0) {
          return this.defaultCategories;
        }
        if (this.checkedType.includes(defaultCategory.type)) {
          return defaultCategory.type;
        }
      });
    },
    totalDefaultCategories() {
      return this.filteredDefaultCategories.length;
    },
  },
  mounted() {
    this.loadDefaultCategories();
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