<template>
  <b-modal
      :id="modalId"
      ref="modal"
      title="Új karbantartás"
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
          Művelet:
        </div>
        <div class="col-9">
          <b-form-select
              v-model="form.action_type"
              :options="options.actionTypes"
              style="width: 100%"
              required
          ></b-form-select>
        </div>
      </div>
      <div class="row form-group mt-3">
        <div class="col-3 font-weight-bold">
          Dátum:
        </div>
        <div class="col-9">
          <b-form-datepicker id="example-datepicker" v-model="form.date" class="mb-2"></b-form-datepicker>
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
import { mapActions } from "vuex"

export default {
  name: "UpdateFireExtinguisherModal",
  data() {
    return {
      form: {
        action_type: 'maintenance',
        date: '',
        comments: '',
      },
      options: {
        actionTypes: [{ text: 'Alap karbantartás', value: 'maintenance' }, { text: 'Üzemeltetői ellenőrzés', value: 'periodic_check' }],
      },
      errors: [],
      saving: false
    }
  },
  props: {
    modalId: {
      type: String,
      required: true
    },
    itemToUpdate: {
      required: true
    }
  },
  methods: {
    ...mapActions({
      fetchFireExtinguishers: 'fetchFireExtinguishers',
      updateFireExtinguisher: 'updateFireExtinguisher'
    }),
    cancel () {
      this.errors = []
      this.$bvModal.hide(this.modalId)
    },
    save () {
      this.saving = true
      this.errors = []

      if (!this.form.date) {
        this.errors.push('A Dátum mező kitöltése kötelező!')
      }

      if (this.errors.length > 0) {
        this.saving = false
        return
      }

      this.updateFireExtinguisher({ id: this.itemToUpdate, payload: this.form})
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