<template>
  <b-modal
    :id="modalId"
    title="Tűzoltó készülék törlése"
    header-bg-variant="danger"
  >
    <div class="d-block">
      Biztosan törli a kiválasztott Tűzoltó készüléket?
    </div>
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
          @click="confirm"
        >
          Igen
        </b-button>
      </div>
    </template>
  </b-modal>
</template>

<script>
export default {
  name: 'ConfirmModal',
  props: {
    modalId: {
      type: String,
      required: true
    },
  },
  methods: {
    cancel () {
      this.$emit('cancel')
    },
    confirm () {
      this.$emit('confirm')
    }
  }
}
</script>

<style>
  .confirm-modal-footer {
    text-align: right;
  }
</style>
