<template>
  <div>
    <div v-if="isLoading">
      <img src="../../../public/loading.gif" />
      <h1>Loading the page</h1>
    </div>
    <div v-if="!isLoading">
      <h1>Make a Transaction</h1>
      <form @submit.prevent="handleSubmit" method="post">
        <label>Send to:</label>
        <input type="number" v-model="transactions.pair_vcard" />
        <div v-if="phone_referenceError" class="error">
          {{ phone_referenceError }}
        </div>
        <label>Ammount:</label>
        <input type="number" step="0.01" v-model="transactions.value" />
        <div v-if="ammount_referenceError" class="error">
          {{ ammount_referenceError }}
        </div>
        <label>Password:</label>
        <input type="password" v-model="password" />
        <div v-if="password_referenceError" class="error">
          {{ password_referenceError }}
        </div>
        <div class="submit">
          <button>Send</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      transactions: {
        pair_vcard: null,
        payment_type: "VCARD",
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
      password: "",
      payment_referenceError: "",
      ammount_referenceError: "",
      phone_referenceError: "",
      password_referenceError: "",
      vcards: [],
      isLoading: true,
      phoneExists: true,
    };
  },
  methods: {
    handleSubmit() {
      if (this.password.length == 0) {
        return (this.password_referenceError = "All fields required");
      } else {
        this.password_referenceError = "";
      }
      if (this.transactions.value.length == 0) {
        return (this.ammount_referenceError = "All fields required");
      } else {
        this.ammount_referenceError = "";
      }
      if (this.transactions.pair_vcard.length == 0) {
        return (this.phone_referenceError = "All fields required");
      } else {
        this.phone_referenceError = "";
      }
      if (
        this.transactions.pair_vcard > 999999999 ||
        this.transactions.pair_vcard < 900000000
      ) {
        return (this.phone_referenceError = "Phone number is not valid");
      } else {
        this.phone_referenceError = "";
      }
      if (this.transactions.value <= 0) {
        return (this.ammount_referenceError =
          "Amount needs to be higher than zero");
      }
      this.password_referenceError = "";
      this.ammount_referenceError = "";
      this.phone_referenceError = "";
      this.transactions.pair_vcard = this.transactions.pair_vcard.toString();
      this.transactions.payment_reference = this.transactions.pair_vcard;
      for (let i = 0; i < this.vcards.length; i++) {
        if (this.vcards[i].phone_number == this.transactions.pair_vcard) {
          this.payment_referenceError = "";
          this.$axios
            .post("newtransaction", this.transactions)
            .then((result) => {
              this.$toast.warning("Transaction done!", {
                duration: 5000,
              });
              this.$router.push("/");
              console.warn(result);
            });
        } else {
          this.phoneExists == false;
        }
      }
      if (this.phoneExists == false) {
        return (this.payment_referenceError =
          "The number is not associated, can't make transaction");
      }
    },
    loadVCards() {
      this.$axios
        .get("vcards")
        .then((response) => {
          this.isLoading = false;
          this.vcards = response.data.data;
        })
        .catch((error) => {
          console.log("ERRRR:: ", error.response.data);
        });
    },
  },
  mounted() {
    this.loadVCards();
  },
};
</script>

<style>
</style>