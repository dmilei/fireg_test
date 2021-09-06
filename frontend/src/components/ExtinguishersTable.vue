<template>
  <div>
    <b-table-simple hover small caption-top responsive>
      <b-thead head-variant="dark">
        <b-tr>
          <b-th colspan="5">Tűzoltókészülék</b-th>
          <b-th colspan="1">Gyártás</b-th>
          <b-th colspan="4">Ellenőrzések időpontja</b-th>
          <b-th colspan="1">Karbantartás időpontja</b-th>
          <b-th colspan="1">Eszköz megj.</b-th>
        </b-tr>
        <b-tr>
          <b-th></b-th>
          <b-th></b-th>
          <b-th>Gyári szám</b-th>
          <b-th>Készenléti helye</b-th>
          <b-th>Típusa</b-th>
          <b-th></b-th>
          <b-th>I. n.év</b-th>
          <b-th>II. n.év</b-th>
          <b-th>III. n.év</b-th>
          <b-th>IV. n.év</b-th>
          <b-th></b-th>
          <b-th></b-th>
        </b-tr>
      </b-thead>
      <b-tbody>
        <b-tr
            v-for="(item, key) in fireExtinguishers"
            :key="key"
            :class="item.maintenance_date ? 'maintained' : 'not-maintained'"
        >
          <b-td class="vertical-align">{{ item.id }}</b-td>
          <b-td>
            <div class="row">
              <div class="col-12">
                <b-btn variant="danger" style="width: 50px" @click="showDeleteModal(item.id)">
                  <b-icon-trash-fill />
                </b-btn>
              </div>
              <div class="col-12 mt-3">
                <b-btn variant="danger" style="width: 50px" @click="showUpdateModal(item.id)">
                  <b-icon-wrench />
                </b-btn>
              </div>
            </div>
          </b-td>
          <b-td class="vertical-align">{{ item.manufacturing_number }}</b-td>
          <b-td class="vertical-align">{{ item.standby_place }}</b-td>
          <b-td class="vertical-align">{{ item.equipment_type.name }}</b-td>
          <b-td class="vertical-align">{{ item.manufactured_at }}</b-td>
          <b-td class="vertical-align">{{ item.q1_check }}</b-td>
          <b-td class="vertical-align">{{ item.q2_check }}</b-td>
          <b-td class="vertical-align">{{ item.q3_check }}</b-td>
          <b-td class="vertical-align">{{ item.q4_check }}</b-td>
          <b-td class="vertical-align">{{ item.maintenance_date }}</b-td>
          <b-td class="vertical-align"></b-td>
        </b-tr>
      </b-tbody>
    </b-table-simple>
    <confirm-modal
        :modal-id="confirmModalId"
        @cancel="cancel"
        @confirm="confirm"
    />
    <update-fire-extinguisher-modal
        :modal-id="updateModalId"
        :item-to-update="itemToUpdate"
    />
  </div>
</template>

<script>
import { mapActions } from "vuex";

import ConfirmModal from "./Modals/ConfirmModal"
import UpdateFireExtinguisherModal from "./Modals/UpdateFireExtinguisherModal"

export default {
  name: 'ExtinguishersTable',
  components: {
    ConfirmModal,
    UpdateFireExtinguisherModal
  },
  props: {
    fireExtinguishers: {
      type: Array,
      required: true
    },
  },
  data() {
    return {
      confirmModalId: 'confirm-modal-id',
      itemToDelete: null,
      updateModalId: 'update-modal-id',
      itemToUpdate: null,
    }
  },
  methods: {
    ...mapActions({
      fetchFireExtinguishers: 'fetchFireExtinguishers',
      deleteFireExtinguisher: 'deleteFireExtinguisher',
    }),
    showDeleteModal (id) {
      this.itemToDelete = id
      this.$bvModal.show(this.confirmModalId)
    },
    showUpdateModal (id) {
      this.itemToUpdate = id
      this.$bvModal.show(this.updateModalId)
    },
    cancel() {
      this.itemToDelete = null
      this.$bvModal.hide(this.confirmModalId)
    },
    confirm() {
      this.deleteFireExtinguisher(this.itemToDelete)
        .then(() => this.fetchFireExtinguishers())
      this.$bvModal.hide(this.confirmModalId)
    },
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
 .vertical-align {
   display: table-cell;
   vertical-align: middle;
 }
 .maintained {
   background-color: #d4edda;
 }
 .not-maintained {
   background-color: #f8d7da;
 }
</style>
