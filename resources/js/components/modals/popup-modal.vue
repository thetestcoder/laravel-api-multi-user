<template>
  <div>
    <!-- Modal -->
    <div class="modal fade" v-bind:id="id" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{title}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <slot></slot>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
              @click="onClose()"
            >Close</button>
            <button type="button" class="btn btn-primary" @click="saveData">{{btnTitle}}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: String,
    id: String,
    btnTitle: String,
    saveData: {
      type: Function
    },
    onClose: {
      type: Function
    }
  }
};
</script>