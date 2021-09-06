<template>
  <b-modal
      :id="modalId"
      ref="modal"
      title="Tűzoltó készülék hozzáadása"
      size="lg"
  >
    <b-alert show variant="danger" v-if="errors.length > 0">
      <ul>
        <li v-for="error in errors">{{ error }}</li>
      </ul>
    </b-alert>
    <form ref="form">
      <div class="row form-group">
        <div class="col-3 font-weight-bold">
          Telephely:
        </div>
        <div class="col-9">
          <b-form-select
              v-model="form.customer_site_id"
              :options="options.customerSites"
              style="width: 100%"
              required
          ></b-form-select>
        </div>
      </div>
      <div class="row form-group mt-3">
        <div class="col-3 font-weight-bold">
          Készenléti helye:
        </div>
        <div class="col-9">
          <b-form-input
              v-model="form.standby_place"
              required
          ></b-form-input>
        </div>
      </div>
      <div class="row form-group mt-3">
        <div class="col-3 font-weight-bold">
          Készülék típus:
        </div>
        <div class="col-9">
          <b-form-select
              v-model="form.equipment_type_id"
              :options="options.equipmentTypes"
              style="width: 100%"
              required
          ></b-form-select>
        </div>
      </div>
      <div class="row form-group mt-3">
        <div class="col-3 font-weight-bold">
          Gyári száma:
        </div>
        <div class="col-9">
          <b-form-input
              v-model="form.manufacturing_number"
              required
          ></b-form-input>
        </div>
      </div>
      <div class="row form-group mt-3">
        <div class="col-3 font-weight-bold">
          Gyártás:
        </div>
        <div class="col-9">
          <b-form-datepicker id="example-datepicker" v-model="form.manufactured_at" class="mb-2"></b-form-datepicker>
        </div>
      </div>
      <div class="row form-group mt-3">
        <div class="col-3 font-weight-bold">
          Megjegyzés:
        </div>
        <div class="col-9">
          <b-form-textarea
              v-model="form.comments"
              required
          ></b-form-textarea>
        </div>
      </div>
      <div class="row form-group mt-3">
        <div class="col-3 font-weight-bold">
          Többszörösítés:
        </div>
        <div class="col-9">
            <b-form-select
                v-model="form.replicas"
                :options="options.replicas"
                style="width: 100%;"
                required
            ></b-form-select>
        </div>
      </div>
    </form>
    <template v-slot:modal-footer>
      <div class="w-100 confirm-modal-footer">
        <b-button
            class="float-right btn-no"
            @click="cancel"
        >
          Mégsem
        </b-button>
        <b-button
            variant="warning"
            class="float-right ml-3 btn-yes"
            style="margin-left: 20px"
            @click="save"
            :disabled="saving"
        >
          {{ saving ? 'Mentés folyamatban...' : 'Mentés' }}
        </b-button>
      </div>
    </template>
  </b-modal>
</template>

<script>
import { mapActions, mapState } from "vuex"

export default {
  name: "StoreFireExtinguisherModal",
  data() {
    return {
      form: {
        customer_site_id: '',
        equipment_type_id: '',
        standby_place: '',
        manufacturing_number: '',
        manufactured_at: '',
        comments: '',
        replicas: '-',
      },
      options: {
        customerSites: [],
        equipmentTypes: [],
        replicas: ['-', '2', '3', '4', '5', '6', '7', '8', '9'],
      },
      errors: [],
      saving: false
    }
  },
  computed: {
    ...mapState({
      optionsState: state => state.options
    })
  },
  mounted() {
    this.fetchOptions().then(() => {
      this.options.customerSites = this.optionsState.customerSites.map(item => {
        return  { text: item.name, value: item.id }
      })
      this.options.equipmentTypes = this.optionsState.equipmentTypes.map(item => {
        return  { text: item.name, value: item.id }
      })

      this.form.customer_site_id = this.options.customerSites.length > 0 ? this.options.customerSites[0].value : ''
      this.form.equipment_type_id = this.options.equipmentTypes.length > 0 ? this.options.equipmentTypes[0].value : ''
    })
  },
  props: {
    modalId: {
      type: String,
      required: true
    },
  },
  methods: {
    ...mapActions({
      fetchOptions: 'fetchOptions',
      fetchFireExtinguishers: 'fetchFireExtinguishers',
      saveFireExtinguisher: 'saveFireExtinguisher'
    }),
    cancel () {
      this.errors = []
      this.$bvModal.hide(this.modalId)
    },
    save () {
      this.saving = true
      this.errors = []

      if (!this.form.standby_place) {
        this.errors.push('A Készenléti helye mező kitöltése kötelező!')
      }
      if (!this.form.manufacturing_number) {
        this.errors.push('A Gyártási száma mező kitöltése kötelező!')
      }
      if (!this.form.manufactured_at) {
        this.errors.push('A Gyártás mező kitöltése kötelező!')
      }

      if (this.errors.length > 0) {
        this.saving = false
        return
      }

      if (this.form.replicas === '-') {
        this.form.replicas = null
      }

      this.saveFireExtinguisher(this.form)
          .then(() => {
            this.fetchFireExtinguishers()
            this.$bvModal.hide(this.modalId)
          })
          .catch((errors) => this.errors = errors)

      this.saving = false
    }
  }
}
</script>

<style scoped>

</style>