<template>
  <div>
    <div id="delete" class="modal fade">
      <div class="modal-dialog modal-confirm">
        <div class="modal-content">
          <div class="text-center">
            <h4 class="modal-title">Are you sure?</h4>
            <button
              type="button"
              class="close my-5 mx-3"
              data-dismiss="modal"
              aria-hidden="true"
            >&times;</button>
          </div>
          <div class="modal-body">
            <p>Do you really want to delete these records? This process cannot be undone.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" @click="deleteItem">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    deleteItem: {
      type: Function
    }
  }
};
</script>