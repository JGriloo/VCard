<template>
<h3 class="mt-5 mb-3" style="background-color: darkblue; color: white;">Users</h3>
  <hr>
        <h5 class="mt-4">Total: {{ totalUsers }}</h5>
  <hr>
  <table class="table table-striped" style="position: absolute; left: 200px;">
    <thead>
      <tr>
        <th
          class="align-middle"
        >#ID</th>
        <th class="align-middle">Name</th>
        <th
          v-if="showEmail"
          class="align-middle"
        >Email</th>
        <th
          v-if="showAdmin"
          class="align-middle"
        >Admin?</th>
        <th
          class="align-middle"
        >Edit</th>
        <th
          class="align-middle"
        >Change Status</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="user in users"
        :key="user.id"
      >
        <td
          class="align-middle"
        >{{ user.id }}</td>
        <td class="align-middle">{{ user.name }}</td>
        <td
          v-if="showEmail"
          class="align-middle"
        >{{ user.email }}</td>
        <td
          v-if="showAdmin"
          class="align-middle"
        >{{ user.type == 'A' ? 'Sim' : ''}}</td>
        <td
          class="text-end align-middle"
          v-if="showEditButton"
        >
          <div
            class="d-flex justify-content-end"
            v-if="canViewUserDetail(user.id)"
          >
            <button
              class="btn btn-xs btn-light"
              @click="editClick(user)"
              v-if="showEditButton"
              v-show="user.id == this.$store.state.user.id"
              style="background-color: orange;"
            ><i class="far fa-edit"></i> Edit
            </button>
          </div>
        </td>
        <td>
          <div
            class="d-flex justify-content-end"
            v-if="canViewUserDetail(user.id)"
          >
            <button
              class="btn btn-xs btn-light"
              @click="removeAdmin(user)"
              v-if="showEditButton"
              v-show="!(user.id == this.$store.state.user.id)"
              style="background-color: red;"
            ><i class="fas fa-times-circle"></i> Remove
            </button>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {

  name: "UsersTable",
  props: {
    users: {
      type: Array,
      default: () => [],
    },
    showId: {
      type: Boolean,
      default: true,
    },
    showEmail: {
      type: Boolean,
      default: true,
    },
    showAdmin: {
      type: Boolean,
      default: true,
    },
    showPhoto: {
      type: Boolean,
      default: true,
    },
    showEditButton: {
      type: Boolean,
      default: true,
    },
  },
  emits: [
    'edit',
    'remove',
  ],
  methods: {
    canViewUserDetail (userId) {
      if (!this.$store.state.user) {
        return false
      }
      return this.$store.state.user.type == 'A' || this.$store.state.user.id == userId
    },
    photoFullUrl (user) {
      return user.photo_url
        ? this.$serverUrl + "/storage/fotos/" + user.photo_url
        : "./assets/img/avatar-none.png"
    },
    editClick (user) {
      this.$emit('edit', user)
    },
    removeAdmin: function(user){
				this.$axios.delete('/users/admin/no/'+ user.id, user).then(() => {
                    this.$toast.warning("Admin removed!");
                    this.$store.dispatch('refresh')
				});
      },
  },
  computed: {
    totalUsers () {
      return this.$store.getters.totalUsers
    }
  }
}
</script>

<style scoped lang="scss">
button {
  margin-left: 3px;
  margin-right: 3px;
}

.img_photo {
  width: 3.2rem;
  height: 3.2rem;
}
</style>
