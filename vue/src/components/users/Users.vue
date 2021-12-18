<template>
  
  <users-table
    :users="$store.getters.users"
    :showId="false"
    @edit="editUser"
  ></users-table>
</template>

<script>
import UsersTable from "./UsersTable.vue"

export default {
  name: 'Users',
  components: {
    UsersTable
  },
  methods: {
    editUser (user) {
      if (user.type == 'A') {
        this.$router.push({name: 'User', params: { id: user.id }})
      } else {
        this.$router.push({ name: 'vCard', params: { phone_number: user.id } })
      }
    },
    removeAdmin (user) {
      if (user.type == 'A') {
        return this.user.type == 'V'
      }
    }
  },
}
</script>

<style scoped>
.filter-div {
  min-width: 12rem;
}
.total-filtro {
  margin-top: 2.3rem;
}
</style>
