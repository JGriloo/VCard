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
</style>