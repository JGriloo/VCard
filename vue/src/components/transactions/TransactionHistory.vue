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

      <div class="datapicker">
        <Datepicker v-model="mydate" :enableTimePicker="false" range />
      </div>

      <div class="table-wrapper">
        <div style="overflow-x: auto">
          <table class="fl-table">
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
            <tbody>
              <template v-if="!totalTransactions">
                <tr>
                  <td>No data to display</td>
                </tr>
              </template>
              <template v-if="totalTransactions">
                <tr
                  v-for="transaction in filteredTransactions"
                  :key="transaction.id"
                >
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
              </template>
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
import Datepicker from "vue3-date-time-picker";
import "vue3-date-time-picker/dist/main.css";
import { ref } from "vue";
import moment from "moment";

export default {
  name: "Transaction History",
  setup() {
    const date = ref();

    // For demo purposes assign range from the current date
    /*onMounted(() => {
          const startDate = new Date();
          const endDate = new Date(new Date().setDate(startDate.getDate() + 7));
          date.value = [startDate, endDate];
      })*/

    return {
      date,
    };
  },
  components: {
    ConfirmationDialog,
    Datepicker,
  },
  data() {
    return {
      transactions: [],
      checkedType: [],
      isLoading: true,
      transactionToDelete: null,
      mydate: null,
    };
  },
  methods: {
    loadTransactions() {
      setTimeout(() => {
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
      }, 5000);
    },
    deleteTransaction(transaction) {
      this.$axios.delete(`transactions/${transaction.id}`).then(() => {
        this.$toast.warning("Transaction removed", {
          duration: 3000,
        });
        //this.$socket.emit('user_deleted', user.id)
      });
      console.log(this.mydate);
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
      let startDate = this.mydate
        ? moment(this.mydate[0]).format("YYYY-MM-DD")
        : null;
      let endDate = this.mydate
        ? moment(this.mydate[1]).format("YYYY-MM-DD")
        : null;

      console.log("date1   " + startDate);
      console.log("date2   " + endDate);
      const transactionsByType = this.transactions.filter((transaction) => {
        if (this.checkedType.length == 0) {
          return this.transactions;
        }
        if (this.checkedType.includes(transaction.type)) {
          return transaction.type;
        }
      });
      return transactionsByType.filter((transaction) => {
        const itemDate = moment(transaction.date).format("YYYY-MM-DD");
        if (!startDate || !endDate) return true;
        if (startDate && endDate) {
          return startDate <= itemDate && itemDate <= endDate;
        }
        if (startDate && !endDate) {
          return startDate <= itemDate;
        }
        if (!startDate && endDate) {
          return itemDate <= endDate;
        }
        return true;
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
// table {
//   margin-left: 50px;
//   display: flex;
//   flex-direction: column;
//   justify-content: center;
//   align-items: center;
// }

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
.datapicker {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  padding: 10px;
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