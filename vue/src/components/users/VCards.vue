<template>
  <VCardsTable
    :vcards="$store.getters.vcards"
    :showId="false"
    @edit="editUser"
  ></VCardsTable>
</template>

<script>
import VCardsTable from "./VCardsTable.vue"

export default {
  name: 'VCards',
  components: {
    VCardsTable
  },
  methods: {
    editUser (vcard) {
      this.$router.push({ name: 'VCard', params: { phone_number: vcard.phone_number } })
    },
    deleteUser (vcard) {
      this.$axios.delete(`vcards/${vcard.phone_number}`).then(() => {
        this.$toast.warning("VCard removed", {
          duration: 3000,
        });
      });
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
