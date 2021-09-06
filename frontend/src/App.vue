<template>
  <div id="app">
    <div class="container">
      <div class="row">
        <div class="col-12 mb-5">
          <h3 class="page-title">Tűzoltó készülék üzemeltetési napló</h3>
        </div>
        <div class="col-12 mt-5 text-left">
          <b-btn class="add-extinguisher" variant="warning" @click="showStoreModal">+ Új tűzoltó készülék</b-btn>
        </div>
        <div class="col-12 mt-5">
          <extinguishers-table :fire-extinguishers="fireExtinguishersState" />
        </div>
      </div>
    </div>
    <store-fire-extinguisher-modal
        :modal-id="modalId"
    />
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex"

import ExtinguishersTable from "./components/ExtinguishersTable"
import StoreFireExtinguisherModal from "./components/Modals/StoreFireExtinguisherModal"

export default {
  name: 'App',
  components: {
    ExtinguishersTable,
    StoreFireExtinguisherModal
  },
  data() {
    return {
      modalId: 'store-modal-id'
    }
  },
  computed: {
    ...mapState({
      fireExtinguishersState: state => state.fireExtinguishers
    })
  },
  mounted() {
    this.fetchFireExtinguishers()
  },
  methods: {
    ...mapActions({
      fetchFireExtinguishers: 'fetchFireExtinguishers',
    }),
    showStoreModal () {
      this.$bvModal.show(this.modalId)
    },
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.text-left {
  text-align: left;
}
.page-title {
  text-align: left;
  color: #c82333;
  text-decoration: underline;
}
.add-extinguisher {
  color: white !important;
}
</style>
