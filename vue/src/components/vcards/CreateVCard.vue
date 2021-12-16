<<<<<<< HEAD:vue/src/components/vcards/CreateVCard.vue
<template>
  <form @submit.prevent="handleSubmit" method="post">
    <label>Phone Number:</label>
    <input type="number" min="0" required v-model="phoneNr" />
    <div v-if="phoneNrError" class="error">{{ phoneNrError }}</div>
    <label>Name:</label>
    <input type="text" required v-model="name" />
    <label>Email:</label>
    <input type="email" required v-model="email" />
    <label>Password:</label>
    <input type="password" required v-model="password" />
    <label>Confirmation Code:</label>
    <input type="text" required v-model="confirmationCode" />
    <div class="submit">
      <button>Submit</button>
    </div>
  </form>
</template>


<script>
export default {
  data() {
    return {
      phoneNr: "",
      name: "",
      email: "",
      password: "",
      confirmationCode: "",
      phoneNrError: "",
      blocked: 0,
      balance: 0,
      max_debit: 0,
    };
  },
  methods: {
    handleSubmit() {
      if (this.phoneNr < 900000000 || this.phoneNr > 999999999) {
        this.phoneNrError = "Invalid phone number";
      }
      if (!this.phoneNrError) {
        console.log("phone nr: ", this.phoneNr);
        console.log("email: ", this.email);
        console.log("password: ", this.password);
        console.log("Confirmation Code: ", this.confirmationCode);
        console.log("Blocked", this.blocked);
        console.log("Balance ", this.balance);
        console.log("Max_debit ", this.confirmationCode);
      }
      this.$axios
        .post("newvcard", {
          phone_number: this.phoneNr.toString(),
          name: this.name,
          email: this.email,
          password: this.password,
          confirmation_code: this.confirmationCode,
          balance: this.balance,
          blocked: this.blocked,
          max_debit: this.max_debit,
        })
        .then((result) => {
          alert("WELL DONE!");
          console.warn(result);
        })
        .catch((error) => {
          console.log("ERRRR:: ", error.response.data);
        });
    },
  },
};
</script>

<style>
form {
  max-width: 420px;
  margin: 30px auto;
  background: white;
  text-align: left;
  padding: 40px;
  border-radius: 10px;
}
label {
  color: #aaa;
  display: inline-block;
  margin: 25px 0 15px;
  font-size: 0.6em;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: bold;
}
input {
  display: block;
  padding: 10px 6px;
  width: 100%;
  box-sizing: border-box;
  border: none;
  border-bottom: 1px solid #ddd;
  color: #555;
}
button {
  background: #0b6dff;
  border: 0;
  padding: 10px 20px;
  margin-top: 20px;
  color: white;
  border-radius: 20px;
  cursor: pointer;
}
.submit {
  text-align: center;
}
.error {
  color: #ff0062;
  margin-top: 10px;
  font-size: 0.8em;
  font-weight: bold;
}

/* Chrome, Safari, Edge, Opera, remove number input arrows */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
/* Firefox  remove number input arrows */
input[type="number"] {
  -moz-appearance: textfield;
}
=======
<template>
  <form @submit.prevent="handleSubmit" method="post">
    <label>Phone Number:</label>
    <input type="number" min="0" required v-model="phone_number" />
    <div v-if="phoneNrError" class="error">{{ phoneNrError }}</div>
    <label>Name:</label>
    <input type="text" required v-model="name" />
    <label>Email:</label>
    <input type="email" required v-model="email" />
    <label>Password:</label>
    <input type="password" required v-model="password" />
    <label>Confirmation Code:</label>
    <input type="text" required v-model="confirmation_code" />
    <div class="submit">
      <button>Submit</button>
    </div>
  </form>
</template>


<script>
export default {
  data() {
    return {
      phone_number: "",
      name: "",
      email: "",
      password: "",
      confirmation_code: "",
      phoneNrError: "",
      blocked: 0,
      balance: 0,
      max_debit: 0,
    };
  },
  methods: {
    handleSubmit() {
      if (this.phone_number < 900000000 || this.phone_number > 999999999) {
        this.phoneNrError = "Invalid phone number";
      }
      if (!this.phoneNrError) {
        console.log("phone nr: ", this.phone_number);
        console.log("email: ", this.email);
        console.log("password: ", this.password);
        console.log("Confirmation Code: ", this.confirmation_code);
        console.log("Blocked", this.blocked);
        console.log("Balance ", this.balance);
        console.log("Max_debit ", this.confirmation_code);
      }
      this.$axios
        .post("newvcard", {
          phone_number: this.phone_number.toString(),
          name: this.name,
          email: this.email,
          password: this.password,
          confirmation_code: this.confirmation_code,
          balance: this.balance,
          blocked: this.blocked,
          max_debit: this.max_debit,
        })
        .then((result) => {
          this.$router.push("/");
          console.warn(result);
        })
        .catch((error) => {
          console.log("ERRRR:: ", error.response.data);
        });
    },
  },
};
</script>

<style>
form {
  max-width: 420px;
  margin: 30px auto;
  background: white;
  text-align: left;
  padding: 40px;
  border-radius: 10px;
}
label {
  color: #aaa;
  display: inline-block;
  margin: 25px 0 15px;
  font-size: 0.6em;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: bold;
}
input {
  display: block;
  padding: 10px 6px;
  width: 100%;
  box-sizing: border-box;
  border: none;
  border-bottom: 1px solid #ddd;
  color: #555;
}
button {
  background: #0b6dff;
  border: 0;
  padding: 10px 20px;
  margin-top: 20px;
  color: white;
  border-radius: 20px;
  cursor: pointer;
}
.submit {
  text-align: center;
}
.error {
  color: #ff0062;
  margin-top: 10px;
  font-size: 0.8em;
  font-weight: bold;
}

/* Chrome, Safari, Edge, Opera, remove number input arrows */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
/* Firefox  remove number input arrows */
input[type="number"] {
  -moz-appearance: textfield;
}
>>>>>>> 2b051026b75e280f09607fa3e9db532d3067424a:vue/src/components/CreateVcard.vue
</style>