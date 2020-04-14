<template>
  <div>
    <div class="form-group" v-if="type != 'checkbox'">
      <label v-bind:for="id">{{labelText}}</label>
      <input
        v-bind:type="type"
        class="form-control"
        v-bind:id="id"
        v-bind:placeholder="placeholder"
        autocomplete="off"
        :value="inputvalue"
        @input="$emit('update', $event.target.value)"
      />
    </div>

    <div class="form-group ml-4 form-check-inline" v-if="type == 'checkbox'">
      <input
        v-bind:id="id"
        class="form-check-input"
        v-bind:type="type"
        :value="checkboxvalue"
        @change="onCheckboxChange"
      />
      <label class="form-check-label" v-bind:for="id">{{labelText}}</label>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    id: String,
    labelText: String,
    type: String,
    placeholder: String,
    checkboxvalue: Number,
    inputvalue: undefined
  },
  model: {
    prop: "inputvalue",
    event: "update"
  },
  methods: {
    onCheckboxChange(e) {
      if (e.target.checked) {
        this.$emit("update", e.target.value);
      } else {
        this.$emit("update", null);
      }
    }
  }
};
</script>