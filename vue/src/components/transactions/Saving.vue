<<<<<<< HEAD
<template>
  <div>
    <div v-if="isLoading">
      <img src="../../../public/loading.gif" />
      <h1>Loading the page</h1>
    </div>
    <div v-if="!isLoading">
      <h1>Savings: {{ vcard.custom_data }} €</h1>
      <form @submit.prevent="handleSubmit" method="post">
        <label>Value:</label>
        <input
          type="number"
          min="0.01"
          step="0.01"
          required
          v-model="savings.value"
        />
        <div class="submit">
          <button>Save</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      savings: {
        pair_vcard: null,
        payment_type: "VCARD",
        value: "",
        type: "D",
        vcard: this.$store.state.user.id.toString(),
        date: new Date().toJSON().slice(0, 10).replace(/-/g, "/"),
        datetime: "2021-11-13 05:43:22",
        old_balance: 0,
        new_balance: 0,
        payment_reference: this.$store.state.user.id.toString(),
        category_id: "",
        description: "",
      },
      vcard: null,
      isLoading: true,
    };
  },
  methods: {
    handleSubmit() {
      this.$axios.post("newsaving", this.savings).then((result) => {
        this.$toast.warning("Saving done!", {
          duration: 1000,
        });
        this.$router.push("/");
        console.warn(result);
      });
    },
    loadVCard() {
      this.$axios.get("vcards/" + this.$store.state.user.id).then((result) => {
        this.vcard = result.data.data;
        this.isLoading = false;
      });
    },
  },
  mounted() {
    this.loadVCard();
  },
};
</script>

<style>
=======
<template>
  <div>
    <div v-if="isLoading">
      <img src="../../../public/loading.gif" />
      <h1>Loading the page</h1>
    </div>
    <div v-if="!isLoading">
      <h1>Savings: {{ vcard.custom_data }} €</h1>
      <form @submit.prevent="handleSubmitAddSaving" method="post">
        <label>Value:</label>
        <input type="number" step="0.01" v-model="addSaving.value" />
        <div v-if="addSaving_referenceError" class="error">
          {{ addSaving_referenceError }}
        </div>
        <div class="submit">
          <button style="background-color: green">Add</button>
        </div>
      </form>
      <form @submit.prevent="handleSubmitRemoveSaving" method="post">
        <label>Value:</label>
        <input type="number" step="0.01" v-model="removeSaving.value" />
        <div v-if="removeSaving_referenceError" class="error">
          {{ removeSaving_referenceError }}
        </div>
        <div class="submit">
          <button style="background-color: red">Remove</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      addSaving: {
        pair_vcard: null,
        payment_type: "VCARD",
        value: "",
        type: "D",
        vcard: this.$store.state.user.id.toString(),
        date: new Date().toJSON().slice(0, 10).replace(/-/g, "/"),
        datetime: "2021-11-13 05:43:22",
        old_balance: 0,
        new_balance: 0,
        payment_reference: this.$store.state.user.id.toString(),
        category_id: "",
        description: "",
      },
      removeSaving: {
        pair_vcard: null,
        payment_type: "VCARD",
        value: "",
        type: "C",
        vcard: this.$store.state.user.id.toString(),
        date: new Date().toJSON().slice(0, 10).replace(/-/g, "/"),
        datetime: "2021-11-13 05:43:22",
        old_balance: 0,
        new_balance: 0,
        payment_reference: this.$store.state.user.id.toString(),
        category_id: "",
        description: "",
      },
      addSaving_referenceError: "",
      removeSaving_referenceError: "",
      vcard: null,
      isLoading: true,
    };
  },
  methods: {
    handleSubmitAddSaving() {
      if (this.addSaving.value > this.vcard.balance) {
        return (this.addSaving_referenceError = "Amount Invalid!");
      }
      if (this.addSaving.value.length == 0) {
        return (this.addSaving_referenceError = "All fields required!");
      }
      if (this.addSaving.value <= 0) {
        return (this.addSaving_referenceError = "Invalid Amount!");
      } else {
        this.addSaving_referenceError = "";
      }
      this.$axios.post("newsaving", this.addSaving).then((result) => {
        this.$toast.warning("Saving done!", {
          duration: 5000,
        });
        this.$router.push("/");
        console.warn(result);
      });
    },
    handleSubmitRemoveSaving() {
      if (this.removeSaving.value > this.vcard.custom_data) {
        return (this.removeSaving_referenceError = "Amount Invalid!");
      }
      if (this.removeSaving.value.length == 0) {
        return (this.removeSaving_referenceError = "All fields required!");
      }
      if (this.removeSaving.value <= 0) {
        return (this.removeSaving_referenceError = "Invalid Amount!");
      } else {
        this.removeSaving_referenceError = "";
      }
      this.$axios.post("removesaving", this.removeSaving).then((result) => {
        this.$toast.warning("Withdraw from savings successfully!", {
          duration: 5000,
        });
        this.$router.push("/savings");
        console.warn(result);
      });
    },
    loadVCard() {
      this.$axios.get("vcards/" + this.$store.state.user.id).then((result) => {
        this.vcard = result.data.data;
        console.log(this.vcard.password);
        this.isLoading = false;
        if (this.vcard.custom_data == null) {
          this.vcard.custom_data = 0;
        }
      });
    },
  },
  mounted() {
    this.loadVCard();
  },
};
</script>

<style>
>>>>>>> 2b051026b75e280f09607fa3e9db532d3067424a
</style>