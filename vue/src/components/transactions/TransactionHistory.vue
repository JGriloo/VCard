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
        <td>Total Transactions: {{ totalTransactions }}</td>
        <thead>
          <th>Data</th>
          <th>Type</th>
          <th>Value</th>
          <th>New Balance</th>
          <th>Payment Type</th>
          <th>Payment Reference</th>
          <th>Category</th>
          <th>Options</th>
        </thead>
        <div v-if="totalTransactions == 0">
          <h1>No data to display</h1>
        </div>
        <tbody>
          <tr v-for="transaction in filteredTransactions" :key="transaction.id">
            <td>{{ transaction.date }}</td>
            <td>{{ transaction.type }}</td>
            <td>{{ transaction.value }}€</td>
            <td>{{ transaction.new_balance }}€</td>
            <td>{{ transaction.payment_type }}</td>
            <td>{{ transaction.payment_reference }}</td>
            <td>{{ transaction.category_id }}</td>
            <td>
              <button
                class="btn btn-danger btn-sm"
                @click="deleteTransaction(transaction)"
              >
                Delete
              </button>
              <button
                class="btn btn-danger btn-sm"
                @click="editTransaction(transaction)"
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
//import moment from "moment";

export default {
  name: "Transaction History",
  components: {
    ConfirmationDialog,
  },
  data() {
    return {
      transactions: [],
      checkedType: [],
      isLoading: true,
      transactionToDelete: null,
    };
  },
  methods: {
    loadTransactions() {
      this.$axios
        .get("vcards/" + this.$store.state.user.id + "/transactions-send")
        .then((response) => {
          console.log(response.data);
          this.isLoading = false;
          this.transactions = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteTransaction(transaction) {
      this.$axios.delete(`transactions/${transaction.id}`).then(() => {
        this.$toast.warning("Transaction removed", {
          duration: 3000,
        });
        //this.$socket.emit('user_deleted', user.id)
      });
    },
    editTransaction(transaction) {
      this.$router.push({
        name: "EditTransaction",
        params: { id: transaction.id },
      });
    },
  },
  computed: {
    filteredTransactions: function () {
      return this.transactions.filter((transaction) => {
        if (this.checkedType.length == 0) {
          return this.transactions;
        }
        if (this.checkedType.includes(transaction.type)) {
          return transaction.type;
        }
      });
    },
    totalTransactions() {
      return this.filteredTransactions.length;
    },
  },
  mounted() {
    this.loadTransactions();
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