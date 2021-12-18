<template>
<h3 class="mt-5 mb-3" style="background-color: darkblue; color: white;">vCards</h3>
  <hr>
<div>
<table class="table" style="position: relative; left: 200px;">
        <thead>
          <tr>
            <th>
              <label for="inputSource" style="color: black;">Email</label>
              <input
                type="text"
                class="form-control"
                v-model="filter.params.email"
                id="inputSource"
                placeholder="Email"
                style="position: relative; font-size: 1em;"
              />
            </th>

              <th>
              <label for="inputName" style="position: relative; left: 100px; color: black;">Name</label>
              <input
                type="text"
                class="form-control"
                v-model="filter.params.name"
                id="inputName"
                placeholder="Name"
                style="position: relative; left: 100px;"
              />
            </th>
            
          </tr>
        </thead>
      </table>
      <hr>
<div class="form-group">
      <button class="btn btn-primary" style="background-color: green; position: absolute; left: 250px; top: 170px;" v-on:click="filterVCards">Filter</button>
      <button class="btn btn-secondary" style="background-color: lightblue; position: absolute; left: 330px; top: 170px;" v-on:click="cancelFilter">Cancel</button>
      <h5 class="mt-4">Total: {{ totalVCards }}</h5>
  </div>
  <hr>
  <div style="overflow-x: auto">
      <div class="table-wrapper">
  <table class="f1-table" style="position: absolute; left: 200px;">
    <thead>
      <tr>
        <th
          class="align-middle"
        >Phone Number</th>
        <th
          v-if="showPhoto"
          class="align-middle"
        >Photo</th>
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
          style="position:relative; right: -40px;"
        >Balance</th>
        <th
          class="align-middle"
          style="position:relative; right: -80px;"
        >Max Debit</th>
        <th
          class="align-middle"
          style="position:relative; right: -120px;"
        >Blocked</th>
        <th
          class="align-middle"
          style="position:relative; right: -200px;"
        >Change VCard Status</th>
        <th
          class="align-middle"
          style="position:relative; right: -240px;"
        >Delete</th>
        
      </tr> 
    </thead>
    <tbody>
      <tr
        v-for="vcard in vcards"
        :key="vcard.id"
      >
        <td
          class="align-middle"
        >{{ vcard.phone_number }}</td>
        <td
          v-if="showPhoto"
          class="align-middle"
        >
          <img
            :src="photoFullUrl(vcard)"
            class="rounded-circle img_photo"
            style="width: 6em; height: 6em;"
          >
        </td>
        <td class="align-middle">{{ vcard.name }}</td>
        <td
          v-if="showEmail"
          class="align-middle"
        >{{ vcard.email }}</td>
        <td
          v-if="showAdmin"
          class="align-middle"
        >{{ vcard.type == 'A' ? 'Sim' : 'vCard'}}</td>
        <td
          class="align-middle"
          style="position: relative; right: -40px;"
        >{{ vcard.balance }}</td>
        <td
          class="align-middle"
          style="position: relative; right: -80px;"
        >{{ vcard.max_debit }}</td>
        <td
          class="text-end align-middle"
          v-if="showEditButton"
        >
            <button
              class="btn btn-xs btn-light"
              style="background-color: orange; margin-top: 0px; position: relative; right: 5px; top: 35px; border-radius: 5px;"
              @click="editClick(vcard)"
              v-if="showEditButton"
            ><i class="far fa-edit"></i> Edit
            </button>
        </td>
        <td class="align-middle" style="position: relative; right: 10px;">
          {{ vcard.blocked == '1' ? 'Sim' : 'Não'}}
        </td>

        <td v-if="vcard.blocked==1"
          class="align-middle"
          style="position: relative; right: -80px;"
        ><button
              class="btn btn-xs btn-light"
              style="background-color: green; margin-top: 0px; position: relative; right: 30px; border-radius: 5px;"
              v-on:click.prevent="unblockVCard(vcard)"
            ><i class="fas fa-check"></i> Unblock
            </button>
        </td>
        <td v-if="vcard.blocked==0"
          class="align-middle"
          style="position: relative; right: -80px;"
        ><button
              class="btn btn-xs btn-light"
              style="background-color: red; margin-top: 0px; position: relative; right: 30px; border-radius: 5px;"
              v-on:click.prevent="blockVCard(vcard)"
            ><i class="fas fa-ban"></i> Block
            </button>
        </td>
        <td
          class="text-end align-middle"
          v-if="showDeleteButton"
        >
            <button
              class="btn btn-xs btn-light"
              style="background-color: darkred; margin-top: 0px; position: relative; right: -150px; border-radius: 5px;"
              @click="deleteClick(vcard)"
              v-if="showDeleteButton"
            ><i class="fas fa-trash-alt"></i>
            </button>
        </td>
      </tr>
        </tbody>
      
    </table>
    </div>
  </div>
  </div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {

  name: "VCardsTable",
  components: {
    
  },
  data() {
    return {
      vcards: [],
      page: 1,
      maxPages: 1000,
      filter: {
        params: {
          name:"",
          email:"",
          },
          headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + this.$root.$data.access_token
                    }
      },
    }
  },
  props: {
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
    showEdit: {
      type: Boolean,
      default: true,
    },
    showDeleteButton: {
      type: Boolean,
      default: true,
    },
  },
  emits: [
    'edit',
    'delete',
    'totalVCards'
  ],
  methods: {
    photoFullUrl (vcard) {
      return vcard.photo_url
        ? this.$serverUrl + "/storage/fotos/" + vcard.photo_url
        : "./assets/img/avatar-none.png"
    },
    editClick (vcard) {
      this.$emit('edit', vcard)
    },
    deleteClick (vcard) {
      if (vcard.balance > 0 ) {
        this.$toast.error("Cant remove because balance is greater than 0.");
      } else {
        this.$axios.delete(`vcards/${vcard.phone_number}`).then(() => {
        this.$toast.success("VCard removed", {
          duration: 3000,
        });
        this.loadVCards();
      })
    }
      
    },
    cancelFilter: function() {
      for (const key in this.filter) {
        if (Object.prototype.hasOwnProperty.call(this.filter, key)) {
          this.filter[key] = "";
        }
      }
      return this.loadVCards()

    },
    filterVCards () {
      this.$axios
        .get("/vcards", this.filter)
        .then((response) => {
          this.vcards = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    loadVCards () {
      this.$axios
        .get("/vcards")
        .then((response) => {
          this.vcards = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    blockVCard: function(vcard){
				this.$axios.patch('/vcards/blocked/yes/'+ vcard.phone_number, vcard).then(() => {
                    this.$toast.warning("VCard blocked!");
                    this.loadVCards();
				});
      },
    unblockVCard: function(vcard){
				this.$axios.patch('/vcards/blocked/no/'+ vcard.phone_number, vcard).then(() => {
                    this.$toast.success("VCard unblocked!");
                    this.loadVCards();
				});
      },
  },
  computed: {
    ...mapGetters(["vcards"]),
    totalVCards () {
      return this.$store.getters.totalVCards
    }
  },
  mounted() {
				this.loadVCards()
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

.fl-table {
    border-radius: 5px;
    font-size: 12px;
    font-weight: normal;
    border: none;
    border-collapse: collapse;
    width: 100%;
    max-width: 100%;
    white-space: nowrap;
    background-color: white;
}

.fl-table td, .fl-table th {
    text-align: center;
    padding: 8px;
}

.fl-table td {
    border-right: 1px solid #f8f8f8;
    font-size: 12px;
}

.fl-table thead th {
    color: #ffffff;
    background: #4FC3A1;
}


.fl-table thead th:nth-child(odd) {
    color: #ffffff;
    background: #324960;
}

.fl-table tr:nth-child(even) {
    background: #F8F8F8;
}

/* Responsive */

@media (max-width: 767px) {
    .fl-table {
        display: block;
        width: 100%;
    }
    .table-wrapper:before{
        content: "Scroll horizontally >";
        display: block;
        text-align: right;
        font-size: 11px;
        color: white;
        padding: 0 0 10px;
    }
    .fl-table thead, .fl-table tbody, .fl-table thead th {
        display: block;
    }
    .fl-table thead th:last-child{
        border-bottom: none;
    }
    .fl-table thead {
        float: left;
    }
    .fl-table tbody {
        width: auto;
        position: relative;
        overflow-x: auto;
    }
    .fl-table td, .fl-table th {
        padding: 20px .625em .625em .625em;
        height: 60px;
        vertical-align: middle;
        box-sizing: border-box;
        overflow-x: hidden;
        overflow-y: auto;
        width: 120px;
        font-size: 13px;
        text-overflow: ellipsis;
    }
    .fl-table thead th {
        text-align: left;
        border-bottom: 1px solid #f7f7f9;
    }
    .fl-table tbody tr {
        display: table-cell;
    }
    .fl-table tbody tr:nth-child(odd) {
        background: none;
    }
    .fl-table tr:nth-child(even) {
        background: transparent;
    }
    .fl-table tr td:nth-child(odd) {
        background: #F8F8F8;
        border-right: 1px solid #E6E4E4;
    }
    .fl-table tr td:nth-child(even) {
        border-right: 1px solid #E6E4E4;
    }
    .fl-table tbody td {
        display: block;
        text-align: center;
    }
}
</style>
