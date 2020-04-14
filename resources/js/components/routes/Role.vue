<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <button
          class="btn btn-primary btn-round"
          data-toggle="modal"
          data-target="#add-role"
        >Add New Role</button>
        <button
          class="btn btn-primary btn-round"
          data-toggle="modal"
          data-target="#add-permission"
        >Add New Permission</button>

        <!-- modals -->
        <!-- role modal -->
        <pop-modal
          title="Add New Role"
          id="add-role"
          btn-title="Save Role"
          v-bind:saveData="saveRole"
        >
          <input-modal
            id="name"
            label-text="Role Name"
            placeholder="Enter Role Name"
            type="text"
            v-model="data.name"
          ></input-modal>
          <p class="text-danger" v-if="errors.name">{{errors.name[0]}}</p>
          <p>
            <strong>Select Permission</strong>
          </p>
          <input-modal
            v-for="(permission, index) in permissions"
            :id="`permission-input-`+ permission.id"
            :label-text="permission.name"
            type="checkbox"
            :checkboxvalue="permission.id"
            v-model="data.ids[index]"
            :key="permission.id"
          ></input-modal>
        </pop-modal>
        <!-- permission Modal -->
        <pop-modal title="Add New Permission" id="add-permission" v-bind:saveData="savePermission">
          <input-modal
            id="name"
            label-text="Permission Name"
            placeholder="Enter Permission Name"
            type="text"
          ></input-modal>
        </pop-modal>
      </div>
      <div class="col-md-6">
        <h3 class="border-bottom border-primary">Roles</h3>
        <div class>
          <table class="table table-hover table-bordered">
            <tr>
              <th>Role Name</th>
              <th>Guard</th>
              <th>Actions</th>
            </tr>
            <tr v-for="role in roles.data">
              <td>{{role.name}}</td>
              <td>{{role.guard_name}}</td>
              <td>
                <button class="btn btn-warning btn-sm">Edit</button>
                <button class="btn btn-danger btn-sm">Delete</button>
              </td>
            </tr>
          </table>
          <pagination :data="roles" @pagination-change-page="getResults"></pagination>
        </div>
      </div>
      <div class="col-md-6">
        <h3 class="border-bottom border-primary">Permissions</h3>
        <div class>
          <table class="table table-hover table-bordered">
            <tr>
              <th>Permission Name</th>
              <th>Guard</th>
              <th>Actions</th>
            </tr>
            <tr v-for="permission in permissions">
              <td>{{permission.name}}</td>
              <td>{{permission.guard_name}}</td>
              <td>
                <button class="btn btn-warning btn-sm">Edit</button>
                <button class="btn btn-danger btn-sm">Delete</button>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PopModal from "../modals/popup-modal";
import InputModal from "../modals/input.vue";
import Pagination from "laravel-vue-pagination";
export default {
  components: {
    PopModal,
    InputModal,
    Pagination
  },
  data() {
    return {
      errors: [],
      roles: {},
      permissions: [],
      data: {
        name: "",
        ids: []
      }
    };
  },
  created() {
    this.fetchRoles();
    this.fetchPermissions();
  },
  methods: {
    getResults(page = 1) {
      axios.get("/admin/fetch/roles?page=" + page).then(response => {
        this.roles = response.data;
      });
    },
    fetchRoles() {
      axios.get("/admin/fetch/roles").then(res => (this.roles = res.data));
    },
    fetchPermissions() {
      axios
        .get("/admin/fetch/permissions")
        .then(res => (this.permissions = res.data));
    },
    onClose() {
      // this.closeModal();
      this.errors = [];
      this.data.name = "";
      this.data.ids = [];
    },
    saveRole() {
      axios
        .post("/admin/add-role", this.data)
        .then(res => {
          this.fetchRoles();
          this.onClose();
          this.$root.closeModal("#add-role");
        })
        .catch(err => {
          if (err.response.status == 422) {
            this.errors = err.response.data.errors;
          }
        });
    },

    savePermission() {
      // axios.post("/admin/add-role", this.data).then(res => {
      //   console.log(res.data);
      // });
      console.log("Permission Saved");
    }
  }
};
</script>