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
        <delete-modal :deleteItem="is_permission_to_delete ? deletePermission:deleteRole"></delete-modal>
        <!-- role modal -->
        <pop-modal
          title="Add New Role"
          id="add-role"
          btn-title="Save Role"
          v-bind:saveData="saveRole"
          v-bind:onClose="onClose"
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
            :ischecked="data.ids[index] ? true:false"
            :checkboxvalue="permission.id"
            v-model="data.ids[index]"
            :key="permission.id"
          ></input-modal>
        </pop-modal>
        <!-- permission Modal -->
        <pop-modal
          title="Add New Permission"
          id="add-permission"
          v-bind:saveData="savePermission"
          btn-title="Save Permission"
          v-bind:onClose="onClose"
        >
          <input-modal
            id="name"
            label-text="Permission Name"
            placeholder="Enter Permission Name"
            v-model="data.name"
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
            <tr v-for="(role) in roles.data">
              <td>{{role.name}}</td>
              <td>{{role.guard_name}}</td>
              <td>
                <button
                  class="btn btn-warning btn-sm"
                  data-toggle="modal"
                  data-target="#add-role"
                  @click="onRoleEdit(role.id)"
                >Edit</button>
                <button
                  class="btn btn-danger btn-sm"
                  @click="wantToDelete(role.id)"
                  data-toggle="modal"
                  data-target="#delete"
                >Delete</button>
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
                <button
                  class="btn btn-warning btn-sm"
                  @click="onPermissionEdit(permission.id)"
                  data-toggle="modal"
                  data-target="#add-permission"
                >Edit</button>
                <button
                  class="btn btn-danger btn-sm"
                  @click="wantToDelete(permission.id, true)"
                  data-toggle="modal"
                  data-target="#delete"
                >Delete</button>
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
import DeleteModal from "../modals/delete";
export default {
  components: {
    PopModal,
    InputModal,
    Pagination,
    DeleteModal
  },
  data() {
    return {
      temp_id: "",
      is_permission_to_delete: false,
      errors: [],
      roles: {},
      permissions: {},
      data: {
        id: 0,
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
      this.errors = [];
      this.data.name = "";
      this.data.id = 0;
      this.data.ids = [];
      this.temp_id = "";
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
    onRoleEdit(id) {
      axios.get("/admin/role/" + id).then(res => {
        this.data.id = res.data.id;
        this.data.name = res.data.name;
        res.data.permissions.forEach((ps, index) => {
          this.permissions.forEach((permission, i) => {
            if (permission.id == ps.id) {
              this.data.ids[i] = ps.id;
            }
          });
        });
      });
    },
    wantToDelete(temp_id, is_permission = false) {
      if (is_permission == true) this.is_permission_to_delete = true;
      this.temp_id = temp_id;
    },
    deleteRole() {
      axios.delete("/admin/delete-role/" + this.temp_id).then(res => {
        this.onClose();
        this.fetchRoles();
        this.$root.closeModal("#delete");
      });
    },

    //permission CRUD
    savePermission() {
      axios.post("/admin/add-permission", this.data).then(res => {
        this.onClose();
        this.fetchPermissions();
        this.$root.closeModal("#add-permission");
      });
    },

    onPermissionEdit(id) {
      axios.get("/admin/permission/" + id).then(res => {
        this.data.id = res.data.id;
        this.data.name = res.data.name;
      });
    },
    deletePermission() {
      axios.delete("/admin/delete-permission/" + this.temp_id).then(res => {
        this.is_permission_to_delete = false;
        this.onClose();
        this.fetchPermissions();
        this.$root.closeModal("#delete");
      });
    }
  }
};
</script>