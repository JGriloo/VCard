<template>
  <form @submit.prevent="handleSubmit" method="post">
    <label>value:</label>
    <input
      type="number"
      min="0.01"
      step="0.01"
      required
      v-model="value"
    />
    <label>Transaction Type:</label>
    <input
      type="radio"
      name="transaction type"
      value="VCard"
      v-model="payment_type"
    />VCard
    <br />
    <input
      type="radio"
      name="transaction type"
      value="MBway"
      v-model="payment_type"
    />MBway
    <br />
    <input
      type="radio"
      name="transaction type"
      value="Iban"
      v-model="payment_type"
    />Iban
    <br />
    <input
      type="radio"
      name="transaction type"
      value="Mastercard"
      v-model="payment_type"
    />Mastercard
    <br />
    <input
      type="radio"
      name="transaction type"
      value="Visa"
      v-model="payment_type"
    />Visa
    <br />
    <input
      type="radio"
      name="transaction type"
      value="Paypal"
      v-model="payment_type"
    />Paypal
    <br />
    <div v-if="payment_type === 'VCard' || payment_type === 'MBway'">
      <label>Addressee Phone Number:</label>
      <input type="number" min="0" required v-model="pair_vcard" />
      <div v-if="pair_vcardError" class="error">{{ pair_vcardError }}</div>
    </div>
    <div v-if="payment_type === 'Iban'">
      <label>Addressee Iban:</label>
      <input type="text" required v-model="pair_vcard" />
      <div v-if="pair_vcardError" class="error">{{ pair_vcardError }}</div>
    </div>
    <div v-if="payment_type === 'Mastercard' || payment_type === 'Visa'">
      <label>Addressee Card Number:</label>
      <input type="number" min="0" required v-model="pair_vcard" />
      <div v-if="pair_vcardError" class="error">{{ pair_vcardError }}</div>
    </div>
    <div v-if="payment_type === 'Paypal'">
      <label>Addressee email:</label>
      <input type="email" required v-model="pair_vcard" />
      <div v-if="pair_vcardError" class="error">{{ pair_vcardError }}</div>
    </div>
    <div class="submit">
      <button>Transfer</button>
    </div>
  </form>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            pair_vcard:'',
            pair_vcardError:'',
            payment_type:'',
            value:'',
            type:'D',
            vcard:'901111111',
            date:'2021-11-13',
            datetime:'2021-11-13 05:43:22',
            old_balance:'200',
            new_balance:this.old_balance - this.value,
            payment_reference:'910101010',
            posts:{

            }
        }
    },
    methods: {

        handleSubmit(){
            if (this.payment_type =='VCard' || this.payment_type =='MBway') {
                this.pair_vcardError = this.pair_vcard.length == 9 ?
                'Invalid Phone Number: needs 9 digits':''
                if (this.pair_vcard <900000000 || this.pair_vcard>999999999) {
                    this.pair_vcardError = 'Invalid Phone Number: number must start with 9'
                }
            }
            if (this.payment_type=='Iban') {
                let regExp = /[A-Z]+$/;
                if (!regExp.test(this.pair_vcard.charAt(0)) ||!regExp.test(this.pair_vcard.charAt(1)) ) {
                    this.pair_vcardError = 'Invalid Iban: Invalid country code'
                }
                if (this.pair_vcard.length<15 || this.pair_vcard.length>34) {
                        this.pair_vcardError = 'Invalid Iban: size must be between 22 or 34'
                }
            }
            if (this.payment_type =='Mastercard' || this.payment_type =='Visa') {
                this.pair_vcardError = this.pair_vcard.length == 16 ?
                'Invalid Card Number: needs 16 digits':''
            }
            axios.post('http://localhost/api/newtransaction',{pair_vcard:this.pair_vcard,payment_type:this.payment_type,value:this.value,type:this.type,vcard:this.vcard,date:this.date,datetime:this.datetime,
            old_balance:this.old_balance,new_balance:this.new_balance,payment_reference:this.payment_reference})
            .then((result)=> {
                debugger
                console.warn(result)

            })
        
        },

}   
}
</script>

<style>
</style>