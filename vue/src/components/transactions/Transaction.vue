<<<<<<< HEAD
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
    <!-- <div>
      <label>Category:</label>
      <select v-model="transactions.category_id">
        <option v-for="category in categories" :key="category.id">
          {{ category.id }}
        </option>
      </select>
    </div> -->
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
import moment from 'moment';
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
        datetime: moment().format('YYYY-MM-DD h:mm:ss'),
        old_balance: 0,
        new_balance: 0,
        payment_reference: "",
        // category_id: null,
        description: "",
      },
      payment_referenceError: "",
      categories: [],
    };
  },
  methods: {
   async handleSubmit() {
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
        console.log('result',result)
        console.log(this.transactions)

        this.$socket.emit('updateVcardTransaction', this.transactions.pair_vcard,this.transactions.vcard)
        console.warn(result);
      });
      
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
  computed() {
    this.loadVCards();
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
      <h1>Make a Transaction</h1>
      <form @submit.prevent="handleSubmit" method="POST">
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
        //password: ""
      },
      password: "",
      payment_referenceError: "",
      ammount_referenceError: "",
      phone_referenceError: "",
      password_referenceError: "",
      vcards: [],
      isLoading: true,
      phoneExists: true,
      errors: null,
    };
  },
  methods: {
    async handleSubmit() {

      const formData = new FormData()
      formData.append('password', this.password)

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

      this.errors = null;
      await this.$axios.post("checktransactionpassword", formData, {})
      .then((response) => {
        
        if (response.status == 200) {
          console.log(this.password);
        }
        
        
        /* else {
          console.log("asd");
          console.log(response.status);
          return this.password_referenceError = "Password does not match";
        } */

        
        
      }).catch((error) => {
        this.errors = error.response.data.errors;
        console.log(error.response.data.errors);
        return this.password_referenceError = "Password does not match";
      });

      //this.password_referenceError = "";
      this.ammount_referenceError = "";
      this.phone_referenceError = "";
      this.transactions.pair_vcard = this.transactions.pair_vcard.toString();
      this.transactions.payment_reference = this.transactions.pair_vcard;
      for (let i = 0; i < this.vcards.length; i++) {
        if (this.vcards[i].phone_number == this.transactions.pair_vcard) {
          this.payment_referenceError = "";
          await this.$axios
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
          return this.phone_referenceError = "The number is not associated, can't make transaction";
        }
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
>>>>>>> 2b051026b75e280f09607fa3e9db532d3067424a
</style>