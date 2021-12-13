<template>
  <form @submit.prevent="handleSubmit" method="post">
    <label>Value:</label>
    <input
      type="number"
      min="0.01"
      step="0.01"
      required
      v-model="transactions.value"
    />
    <label>Transaction Type:</label>
    <input
      type="radio"
      name="transaction type"
      value="VCARD"
      v-model="transactions.payment_type"
    />VCard
    <br />
    <input
      type="radio"
      name="transaction type"
      value="MBWAY"
      v-model="transactions.payment_type"
    />MBWay
    <br />
    <input
      type="radio"
      name="transaction type"
      value="IBAN"
      v-model="transactions.payment_type"
    />IBAN
    <br />
    <input
      type="radio"
      name="transaction type"
      value="MB"
      v-model="transactions.payment_type"
    />Multibanco
    <br />
    <input
      type="radio"
      name="transaction type"
      value="VISA"
      v-model="transactions.payment_type"
    />VISA
    <br />
    <input
      type="radio"
      name="transaction type"
      value="PAYPAL"
      v-model="transactions.payment_type"
    />PayPal
    <br />
    <div
      v-if="
        transactions.payment_type === 'VCARD' ||
        transactions.payment_type === 'MBWAY'
      "
    >
      <label>Addressee Phone Number:</label>
      <input type="text" required v-model="transactions.payment_reference" />
      <div v-if="payment_referenceError" class="error">
        {{ payment_referenceError }}
      </div>
    </div>
    <div v-if="transactions.payment_type === 'IBAN'">
      <label>Addressee Iban:</label>
      <input type="text" required v-model="transactions.payment_reference" />
      <div v-if="payment_referenceError" class="error">
        {{ payment_referenceError }}
      </div>
    </div>
    <div v-if="transactions.payment_type === 'VISA'">
      <label>Addressee Card Number:</label>
      <input
        type="number"
        min="0"
        required
        v-model="transactions.payment_reference"
      />
      <div v-if="payment_referenceError" class="error">
        {{ payment_referenceError }}
      </div>
    </div>
    <div v-if="transactions.payment_type === 'PAYPAL'">
      <label>Addressee email:</label>
      <input type="email" required v-model="transactions.payment_reference" />
      <div v-if="payment_referenceError" class="error">
        {{ payment_referenceError }}
      </div>
    </div>
    <div v-if="transactions.payment_type === 'MB'">
      <input type="hidden" required v-model="transactions.payment_reference" />
      <div v-if="payment_referenceError" class="error">
        {{ payment_referenceError }}
      </div>
    </div>
    <div>
      <label>Category:</label>
      <select v-model="transactions.category_id">
        <option v-for="category in categories" :key="category.id">
          {{ category.id }}
        </option>
      </select>
    </div>
    <div>
      <label>Description:</label>
      <input type="text" v-model="transactions.description" />
    </div>
    <div class="submit">
      <button>Transfer</button>
    </div>
  </form>
</template>

<script>
export default {
  data() {
    return {
      transactions: {
        pair_vcard: null,
        payment_type: "",
        value: "",
        type: "D",
        vcard: this.$store.state.user.id.toString(),
        date: new Date().toJSON().slice(0, 10).replace(/-/g, "/"),
        datetime: "2021-11-13 05:43:22",
        old_balance: 0,
        new_balance: 0,
        payment_reference: "",
        category_id: "",
        description: "",
      },
      payment_referenceError: "",
      categories: [],
    };
  },
  methods: {
    handleSubmit() {
      if (
        this.transactions.payment_type == "VCARD" ||
        this.transactions.payment_type == "MBWAY"
      ) {
        this.payment_referenceError =
          this.transactions.payment_reference.length !== 9
            ? "Invalid Phone Number: needs 9 digits"
            : "";
        if (
          this.transactions.payment_reference < 900000000 ||
          this.transactions.payment_reference > 999999999
        ) {
          this.payment_referenceError =
            "Invalid Phone Number: number must start with 9";
        }
      }
      if (
        this.transactions.payment_type == "VCARD" ||
        this.transactions.payment_type == "MBWAY"
      ) {
        this.transactions.pair_vcard = this.transactions.payment_reference;
      }
      if (this.transactions.payment_type == "MB") {
        this.transactions.payment_reference = Math.ceil(
          Math.random() * 10000000000000
        ).toString();
      }
      this.$axios.post("newtransaction", this.transactions).then((result) => {
        console.warn(result);
      });
    },
    loadCategories() {
      this.$axios
        .get("mycategories/" + this.$store.state.user.id)
        .then((response) => {
          this.isLoading = false;
          this.categories = response.data.data;
          this.$router.push("/");
        })
        .catch((error) => {
          console.log("ERRRR:: ", error.response.data);
        });
    },
  },
  mounted() {
    this.loadCategories();
  },
};
</script>

<style>
</style>