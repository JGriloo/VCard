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
      <div class="table-wrapper">
      <div style="overflow-x: auto">
      <table class="fl-table">
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
      setTimeout(()=>{
      this.$axios
        .get("mycategories/" + this.$store.state.user.id)
        .then((response) => {
          this.isLoading = false;
          this.categories = response.data.data;
        })
        .catch((error) => {
          console.log("ERRRR:: ", error.response.data);
        });
      },5000);
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

.table-wrapper {
  margin: 10px 70px 70px;
  box-shadow: 0px 35px 50px rgba(0, 0, 0, 0.2);
}

.fl-table {
  border-radius: 5px;
  font-size: 12px;
  font-weight: normal;
  border: none;
  border-collapse: collapse;
  width: 100%;
  max-width: 100%;
  white-space: nowrap;
  background-color: white;
}

.fl-table td,
.fl-table th {
  text-align: center;
  padding: 8px;
}

.fl-table td {
  border-right: 1px solid #f8f8f8;
  font-size: 12px;
}

.fl-table thead th {
  color: #ffffff;
  background: #4fc3a1;
}

.fl-table thead th:nth-child(odd) {
  color: #ffffff;
  background: #324960;
}

.fl-table tr:nth-child(even) {
  background: #f8f8f8;
}



/* Responsive */

@media (max-width: 767px) {
  .fl-table {
    display: block;
    width: 100%;
  }
  .table-wrapper:before {
    content: "Scroll horizontally >";
    display: block;
    text-align: right;
    font-size: 11px;
    color: white;
    padding: 0 0 10px;
  }
  .fl-table thead,
  .fl-table tbody,
  .fl-table thead th {
    display: block;
  }
  .fl-table thead th:last-child {
    border-bottom: none;
  }
  .fl-table thead {
    float: left;
  }
  .fl-table tbody {
    width: auto;
    position: relative;
    overflow-x: auto;
  }
  .fl-table td,
  .fl-table th {
    padding: 20px 0.625em 0.625em 0.625em;
    height: 60px;
    vertical-align: middle;
    box-sizing: border-box;
    overflow-x: hidden;
    overflow-y: auto;
    width: 120px;
    font-size: 13px;
    text-overflow: ellipsis;
  }
  .fl-table thead th {
    text-align: left;
    border-bottom: 1px solid #f7f7f9;
  }
  .fl-table tbody tr {
    display: table-cell;
  }
  .fl-table tbody tr:nth-child(odd) {
    background: none;
  }
  .fl-table tr:nth-child(even) {
    background: transparent;
  }
  .fl-table tr td:nth-child(odd) {
    background: #f8f8f8;
    border-right: 1px solid #e6e4e4;
  }
  .fl-table tr td:nth-child(even) {
    border-right: 1px solid #e6e4e4;
  }
  .fl-table tbody td {
    display: block;
    text-align: center;
  }
}
</style>