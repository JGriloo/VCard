<template>
  <div class="jumbotron">
    <div v-if="isLoading">
      <img src="../../../public/loading.gif" />
      <h1>Loading the page</h1>
    </div>
    <div v-if="!isLoading">
      <h2>Edit transaction: {{ transaction.id }}</h2>
      <form @submit.prevent="updateTransaction()">
        <div class="form-group">
          <label for="inputCategory">Category</label>
          <input
            type="text"
            class="form-control"
            v-model="transaction.category_id"
            name="category"
            id="inputCategory"
            placeholder="category"
            required
          />
        </div>
        <div class="form-group">
          <label for="inputDescription">Transaction Description</label>
          <input
            type="text"
            class="form-control"
            v-model="transaction.description"
            name="description"
            id="inputDescription"
            placeholder="Description"
            required
          />
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
      transaction: {
        vcard: "",
        date: "",
        datetime: "",
        type: "",
        value: "",
        old_balance: "",
        new_balance: "",
        payment_type: "",
        payment_referenc: "",
        pair_transaction: "",
        pair_vcard: "",
        category_id: "",
        description: "",
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
        this.loadTransaction(newValue);
      },
    },
  },
  methods: {
    loadTransaction(id) {
      this.$axios
        .get("transactions/" + id)
        .then((response) => {
          this.isLoading = false;
          this.transaction = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateTransaction() {
      this.$axios
        .put(`transactions/` + this.transaction.id, this.transaction)
        .then(() => {
          console.log("Transaction has been updated");
          this.$router.push("/");
        })
        .catch((error) => {
          console.log("ERRRR:: ", error.response.data);
        });
    },
  },
};
</script>