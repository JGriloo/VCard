<template>
    <div class="transactionshistory">
        <TransactionHistory/>
    </div>
</template>

<script>
import TransactionHistory from "../components/TransactionHistory.vue"
export default {
name:'TransactionsHistory',
components:{
    TransactionHistory
},
data() {
    return {
        
    }
},
methods: {
    
}  
}
</script>

<style lang="scss">


.avatar-img {
  margin: -1.2rem 0.8rem -2rem 0.8rem;
  width: 3.3rem;
  height: 3.3rem;
  // border-width: 1px;
  // border-color: rgb(33, 37, 41);
  // border-style: solid;
}
.avatar-text {
  line-height: 2.2rem;
  margin: 1rem 0.5rem -2rem 0;
  padding-top: 1rem;
}

.dropdown-item {
  font-size: 0.875rem;
}
</style>