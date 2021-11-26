<template>
  <form @submit.prevent="handleSubmit">
        <label >Amount:</label>
        <input type="number" min="0.01" step="0.01" required v-model="transactionValue">
        <label>Transaction Type:</label>
        <input type="radio" name="transaction type" value="VCard" v-model="transactionType">VCard
        <br>
        <input type="radio" name="transaction type" value="MBway" v-model="transactionType">MBway
        <br>
        <input type="radio" name="transaction type" value="Iban" v-model="transactionType">Iban
        <br>
        <input type="radio" name="transaction type" value="Mastercard" v-model="transactionType">Mastercard
        <br>
        <input type="radio" name="transaction type" value="Visa" v-model="transactionType">Visa
        <br>
        <input type="radio" name="transaction type" value="Paypal" v-model="transactionType">Paypal
        <br>
        <div v-if="transactionType ==='VCard' || transactionType ==='MBway'">
            <label >Addressee Phone Number:</label>
            <input type="number" min=0 required v-model="adressee">
            <div v-if="adresseeError" class="error">{{adresseeError}}</div>
        </div>
        <div v-if="transactionType ==='Iban'">
            <label >Addressee Iban:</label>
            <input type="text" required v-model="adressee">
            <div v-if="adresseeError" class="error">{{adresseeError}}</div>
        </div>
        <div v-if="transactionType ==='Mastercard' || transactionType==='Visa'">
            <label >Addressee Card Number:</label>
            <input type="number" min=0 required v-model="adressee">
            <div v-if="adresseeError" class="error">{{adresseeError}}</div>
        </div>
        <div v-if="transactionType ==='Paypal'">
            <label >Addressee email:</label>
            <input type="email" required v-model="adressee">
            <div v-if="adresseeError" class="error">{{adresseeError}}</div>
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
            adressee:'',
            adresseeError:'',
            transactionType:'',
            transactionValue:''
        }
    },
    methods: {
        handleSubmit(){
            if (this.transactionType =='VCard' || this.transactionType =='MBway') {
                this.adresseeError = this.adressee.length == 9 ?
                'Invalid Phone Number: needs 9 digits':''
                if (this.adressee <900000000 || this.adressee>999999999) {
                    this.adresseeError = 'Invalid Phone Number: number must start with 9'
                }
            }
            if (this.transactionType=='Iban') {
                let regExp = /[A-Z]+$/;
                if (!regExp.test(this.adressee.charAt(0)) ||!regExp.test(this.adressee.charAt(1)) ) {
                    this.adresseeError = 'Invalid Iban: Invalid country code'
                }
                if (this.adressee.length<15 || this.adressee.length>34) {
                        this.adresseeError = 'Invalid Iban: size must be between 22 or 34'
                }
            }
            if (this.transactionType =='Mastercard' || this.transactionType =='Visa') {
                this.adresseeError = this.adressee.length == 16 ?
                'Invalid Card Number: needs 16 digits':''
            }
        }
        
    },

}
</script>

<style>

</style>