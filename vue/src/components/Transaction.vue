<template>
  <form @submit.prevent="handleSubmit" method="post">
    <label>value:</label>
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
      value="VCard"
      v-model="transactions.payment_type"
    />VCard
    <br />
    <input
      type="radio"
      name="transaction type"
      value="MBway"
      v-model="transactions.payment_type"
    />MBway
    <br />
    <input
      type="radio"
      name="transaction type"
      value="Iban"
      v-model="transactions.payment_type"
    />Iban
    <br />
    <input
      type="radio"
      name="transaction type"
      value="Mastercard"
      v-model="transactions.payment_type"
    />Mastercard
    <br />
    <input
      type="radio"
      name="transaction type"
      value="Visa"
      v-model="transactions.payment_type"
    />Visa
    <br />
    <input
      type="radio"
      name="transaction type"
      value="Paypal"
      v-model="transactions.payment_type"
    />Paypal
    <br />
    <div v-if="transactions.payment_type === 'VCard' || transactions.payment_type === 'MBway'">
      <label>Addressee Phone Number:</label>
      <input type="text" required v-model="transactions.pair_vcard" />
      <div v-if="pair_vcardError" class="error">{{ pair_vcardError }}</div>
    </div>
    <div v-if="transactions.payment_type === 'Iban'">
      <label>Addressee Iban:</label>
      <input type="text" required v-model="transactions.pair_vcard" />
      <div v-if="pair_vcardError" class="error">{{ pair_vcardError }}</div>
    </div>
    <div v-if="transactions.payment_type === 'Mastercard' || transactions.payment_type === 'Visa'">
      <label>Addressee Card Number:</label>
      <input type="number" min="0" required v-model="transactions.pair_vcard" />
      <div v-if="pair_vcardError" class="error">{{ pair_vcardError }}</div>
    </div>
    <div v-if="transactions.payment_type === 'Paypal'">
      <label>Addressee email:</label>
      <input type="email" required v-model="transactions.pair_vcard" />
      <div v-if="pair_vcardError" class="error">{{ pair_vcardError }}</div>
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
          vcard_destiny : null,
          vcard_receiver : null,
          transactions:{
            pair_vcard:'',
            payment_type:'',
            value:'',
            type:'D',
            vcard:'900000001',
            date:'2021-11-13',
            datetime:'2021-11-13 05:43:22',
            old_balance:'200',
            new_balance:'100',
            payment_reference:'910101010',
          },
          pair_vcardError:'',
        }
    },
    methods: {

        handleSubmit(){
            // if (this.transactions.payment_type =='VCard' || this.transactions.payment_type =='MBway') {
            //     this.pair_vcardError = this.transactions.pair_vcard.length == 9 ?
            //     'Invalid Phone Number: needs 9 digits':''
            //     if (this.transactions.pair_vcard <900000000 || this.transactions.pair_vcard>999999999) {
            //         this.pair_vcardError = 'Invalid Phone Number: number must start with 9'
            //     }
            // }
            // if (this.transactions.payment_type=='Iban') {
            //     let regExp = /[A-Z]+$/;
            //     if (!regExp.test(this.transactions.pair_vcard.charAt(0)) ||!regExp.test(this.transactions.pair_vcard.charAt(1)) ) {
            //         this.pair_vcardError = 'Invalid Iban: Invalid country code'
            //     }
            //     if (this.transations.pair_vcard.length<15 || this.transactions.pair_vcard.length>34) {
            //             this.pair_vcardError = 'Invalid Iban: size must be between 22 or 34'
            //     }
            // }
            // if (this.transactions.payment_type =='Mastercard' || this.transactions.payment_type =='Visa') {
            //     this.pair_vcardError = this.transactions.pair_vcard.length == 16 ?
            //     'Invalid Card Number: needs 16 digits':''
            // }
            // String(this.transactions.pair_vcard)

            this.vcard_destiny = this.$axios.get(`vcards/${this.transactions.pair_vcard}`)
            console.log(this.vcard_destiny)
            this.vcard_receiver = this.$axios.get(`vcards/${this.transactions.vcard}`)

            this.$axios.post('newtransaction',this.transactions)
            .then((result)=> {

                console.warn(result)

            })
        
        },

}   
}
</script>

<style>
</style>