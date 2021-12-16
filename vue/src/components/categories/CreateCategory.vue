<template>
  <form @submit.prevent="handleSubmit" method="post">
    <label>Name:</label>
    <input
      type="text"
      name="category name"
      required
      v-model="categories.name"
    />
    <label>Category Type:</label>
    <input
      type="radio"
      name="category type"
      value="C"
      v-model="categories.type"
    />Credit
    <br />
    <input
      type="radio"
      name="category type"
      value="D"
      v-model="categories.type"
    />Debit
    <br />
    <div class="submit">
      <button>Submit</button>
    </div>
  </form>
</template>


<script>
//import { router } from "../../router/index";
export default {
  data() {
    return {
      categories: {
        type: "",
        name: "",
        vcard: this.$store.state.user.id.toString(),
      },
    };
  },
  methods: {
    handleSubmit() {
      this.vcard_up = this.$axios
        .get(`vcards/${this.categories.vcard}`)
        .then(() => {
          this.$axios.post("newcategory", this.categories).then((result) => {
            console.warn(result);
            this.$toast.success("Category created successfully!");
            this.$store.commit("setCategories");
            this.$socket.emit('newCategory',this.category)
            this.$router.push("/");
          });
        })
        .catch((error) => error);
      console.log(this.vcard_up);
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
</style>