<template>
    <form @submit.prevent="handleSubmit">
        <label >Phone Number:</label>
        <input type="number" min=0 required v-model="phoneNr">
        <div v-if="phoneNrError" class="error">{{phoneNrError}}</div>
        <label >Email:</label>
        <input type="email" required v-model="email">
        <label >Password:</label>
        <input type="password" required v-model="password"> 
        <label >Confirmation Code:</label>
        <input type="text" required v-model="confirmationCode">
        <div class="submit">
        <button>Submit</button>
        </div>
    </form>
</template>


<script>
export default {
    
    data(){
        return{
            phoneNr:'',
            email:'',
            password:'',
            confirmationCode:'',
            phoneNrError: ''
        }
    },
    methods:{
        handleSubmit(){
            //console.log('form submitted')
            this.phoneNrError = this.phoneNr.length == 9 ?
            'Invalid phone number':''
            if (this.phoneNr <900000000 || this.phoneNr>999999999) {
                this.phoneNrError = 'Invalid phone number'
            }
            if(!this.phoneNrError){
                console.log('phone nr: ',this.phoneNr)
                console.log('email: ',this.email)
                console.log('password: ',this.password)
                console.log('Confirmation Code: ',this.confirmationCode)
                console.log('Erro nr telefone: ',this.phoneNrError)
            }
        }
    }
}
</script>

<style>

    form{
        max-width: 420px;
        margin: 30px auto;
        background: white;
        text-align: left;
        padding: 40px;
        border-radius: 10px;
    }
    label{
        color: #aaa;
        display: inline-block;
        margin: 25px 0 15px;
        font-size: 0.6em;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: bold;
    }
    input{
        display: block;
        padding: 10px 6px;
        width: 100%;
        box-sizing: border-box;
        border: none;
        border-bottom: 1px solid #ddd;
        color: #555;
    }
    button{
        background: #0b6dff;
        border: 0;
        padding: 10px 20px;
        margin-top: 20px;
        color: white;
        border-radius: 20px;
    }
    .submit{
        text-align: center;
    }
    .error{
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
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>